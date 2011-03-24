<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined('_JEXEC') or die('Restricted access');

/**
 * ComConfiguratorControllerTemplate
 *
 * For updating the Morph base template.
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorControllerTemplate extends ComConfiguratorControllerDefault
{
	protected function _actionInstall_template()
	{
		$db = JFactory::getDBO();
	
		if(isset($_COOKIE['upgrade-type']) && $_COOKIE['upgrade-type'] === 'fresh-install'){
			$query = $db->setQuery('DROP TABLE #__configurator');
			$db->query($query);
			$query = $db->setQuery('DROP TABLE #__configurator_preferences');
			$db->query($query);
			$this->parse_mysql_dump(JPATH_ADMINISTRATOR.'/components/com_configurator/install.sql');
		}
		
		$newtemplatefile = @JRequest::getVar( 'template-file', null, 'files', 'array' );
		$templatesdir = JPATH_SITE.'/templates';
		$backupdir = JPATH_SITE.'/morph_assets/backups';
		$logosdir = JPATH_SITE.'/morph_assets/logos';
		$backgroundsdir = JPATH_SITE.'/morph_assets/backgrounds';
		$themeletsdir = JPATH_SITE.'/morph_assets/themelets';
		$ret = '';
				
		
		if(is_dir($templatesdir.'/morph')){
			KFactory::get('admin::com.configurator.helper.utilities')->setInstallState('upgrade_morph', true);
			// template folder
			if($_REQUEST['backup'] == 'true'){
				KFactory::get('admin::com.configurator.helper.utilities')->setInstallState('installed_bkpmorph', true);
				// backup existing
				$backupfile = $backupdir.'/file_template_morph_' . time();
				if(!@Jarchive::create($backupfile, $templatesdir.'/morph', 'gz', '', $templatesdir, true)){
					// error creating archive
					echo json_encode(array('error' => 'There was an error creating the archive. Install failed'));
				}else{
					// remove existing
					if(!JFolder::delete($templatesdir.'/morph')){
						// fail: error removing existing folder
						echo json_encode(array('error' => 'There was an error removing the old install. Install failed'));
					}else{
						if( !JFile::upload($newtemplatefile['tmp_name'], $templatesdir.'/'.strtolower(basename($newtemplatefile['name']))) ){
							echo json_encode(array('error' => 'Could not move file to required location!'));
						}
						// directory doesn't exist - install as per usual
						@JPath::setPermissions($templatesdir.'/'.strtolower(basename($newtemplatefile['name'])));
						$msg = $this->unpackTemplate($templatesdir.'/'.strtolower(basename($newtemplatefile['name'])), $_REQUEST['publish']);
						$msg['backuploc'] = $backupfile.'.gz';
						
						$this->_dbUpdate();
						
						KFactory::get('admin::com.configurator.helper.utilities')->setInstallState('installed_morph', true);
						echo json_encode($msg);
					}
				}
			}
		}else{
			if( !JFile::upload($newtemplatefile['tmp_name'], $templatesdir.'/'.strtolower(basename($newtemplatefile['name']))) ){
				echo json_encode(array('error' => 'Could not move file to required location!'));
			}
			// directory doesn't exist - install as per usual
			@JPath::setPermissions($templatesdir.'/'.strtolower(basename($newtemplatefile['name'])));
			$msg = $this->unpackTemplate($templatesdir.'/'.strtolower(basename($newtemplatefile['name'])), $_REQUEST['publish']);
			$this->_dbUpdate();
			KFactory::get('admin::com.configurator.helper.utilities')->setInstallState('installed_morph', true);
			echo json_encode($msg);
		}
		
		//@TODO temp fix
		die;
	}
	
	function unpackTemplate($p_filename, $publish = ''){
		$type = 'upgraded';
		$exists = JPATH_ROOT.'/templates/morph/templateDetails.xml';
		if(!file_exists($exists)) $type = 'installed';
		$archivename = $p_filename;
		$dirname = uniqid('tempins_');
		$extractdir = JPath::clean(dirname($p_filename).'/'.$dirname);
		$archivename = JPath::clean($archivename);
		
		$result = JArchive::extract( $archivename, $extractdir);
		if ( !$result ) {
			return array('error' => 'There was an error extracting the file! '.$extractdir);
		}
	
		$retval['extractdir'] = $extractdir;
		$retval['packagefile'] = $archivename;
		
		if (JFile::exists($extractdir.'/templateDetails.xml')){
			$template_params = $this->parsexml_template_file($extractdir);
		}else{
			$this->cleanupThemeletInstall($retval['packagefile'], $retval['extractdir']);
			return array('error' => 'This is not a valid Template Package:<br />The file <strong>templateDetails.xml</strong> doesn\'t exist or is incorrectly structured!');
		}
		
		//get install dir
		if ($template_params) {
			$_templatedir = trim( strtolower(str_replace(array(' ','_'),'-',$template_params->name)) );
		}
		
		if (!$_templatedir){		
			if (count($dirList) == 1){
				if (JFolder::exists($extractdir.'/'.$dirList[0])){
					$extractdir = JPath::clean($extractdir.'/'.$dirList[0]);
				}
			}
		} else {
			
			//Fix for picking up language files
			jimport('joomla.installer.installer');
			$installer = JInstaller::getInstance();
			$installer->install($extractdir);
			JFolder::move($extractdir, dirname($p_filename).'/'.$_templatedir);
		}
		
		if (JFolder::exists( dirname($p_filename).'/'.$_templatedir ) ) {
			$retval['dir'] = $extractdir;
			$this->cleanupThemeletInstall($retval['packagefile'], $retval['extractdir']);
			
			if($publish !== 'false'){
				$db = JFactory::getDBO();
				$db->setQuery("UPDATE #__templates_menu SET template = 'morph' WHERE client_id = '0'");
				
				if($db->query()) {
					KFactory::get('admin::com.configurator.helper.utilities')->setInstallState('installed_pubmorph', true);
				} else {
					return array('error' => $db->getErrorMsg());
				}
			}
			
			return array(
				'error'		=> '',
				'msg'		=> 'Morph '.$type.' Successfully',
				'success'	=> 'Morph '.$type.' successfully'
			);
		}
		
	}

	function parsexml_template_file($templateDir){
		// Check if the xml file exists
		if(!is_file($templateDir.'/templateDetails.xml')) {
			return false;
		}
		
		$xml = JApplicationHelper::parseXMLInstallFile($templateDir.'/templateDetails.xml');
		
		if ($xml['type'] != 'template') {
			return false;
		}
		
		$data = new StdClass();
		$data->directory = $templateDir;
		
		foreach($xml as $key => $value) {
			$data->$key = $value;
		}
		
		$data->checked_out = 0;
		$data->mosname = JString::strtolower(str_replace(' ', '_', $data->name));
		
		return $data;
	}

	function template_upload(){
		$newtemplatefile = JRequest::getVar( 'insfile', null, 'files', 'array' );
		$templatesdir = JPATH_SITE.'/templates';
		$backupdir = JPATH_SITE.'/morph_assets/backups';
		$backupfile = $backupdir.'/file_template_morph_' . time();
		if(!@Jarchive::create($backupfile, $templatesdir.'/morph', 'gz', '', $templatesdir, true)){
			return array('error' => 'There was an error creating a backup archive. Upload failed');
		}else{
			// remove existing
			if(!JFolder::delete($templatesdir.'/morph')){
				return array('error' => 'There was an error removing the old install. Upload failed');
			}else{
				if( !JFile::upload($newtemplatefile['tmp_name'], $templatesdir.'/'.strtolower(basename($newtemplatefile['name']))) ){
					return array('error' => 'Could not move file to required location!');
				}
				// directory doesn't exist - install as per usual
				@JPath::setPermissions($templatesdir.'/'.strtolower(basename($newtemplatefile['name'])));
				$msg = $this->unpackTemplate($templatesdir.'/'.strtolower(basename($newtemplatefile['name'])));
				
				$msg['backuploc'] = $backupfile.'.gz';
				return $msg;
			}
		}
	}

}