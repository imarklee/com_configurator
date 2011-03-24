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
 	
 	
 }