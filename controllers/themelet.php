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
 * ComConfiguratorControllerThemelet
 *
 * The themelet configurator controller, for installing and such
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
 class ComConfiguratorControllerThemelet extends ComConfiguratorControllerDefault
 {
 	function themelet_upload($file = '', $activate = '') {
		$msg = '';
		$error = '';
		$template = 'morph';
		if($file == ''){
			$themelet_details = JRequest::getVar( 'insfile', null, 'files', 'array' );
		}else{
			$themelet_details = $file;
		}
		$themelet_type = $themelet_details['type'];
		// if there is no file error then continue
		if($themelet_details['error'] != 4) {
			$themelet_dir = JPATH_ROOT.'/morph_assets/themelets';
			
			// errors
			if( $themelet_details['error'] ){
				return array('error' => 'Upload error ('.$themelet_details['error'].')');
			}
			if( !is_uploaded_file($themelet_details['tmp_name']) ){ 
				return array('error' => 'Not an uploaded file! Hack attempt?');
			}
			
			if( !is_dir($themelet_dir) ) {
				// Directory doesnt exist, try to create it.
				if( !mkdir($themelet_dir) ){
					return array('error' => 'Could not save file, directory does not exist!');
				}else{
					JPath::setPermissions($themelet_dir);
				}
			}
			
			if( !is_writable($themelet_dir) ){
				return array('error' => 'Could not save file, permission error!');
			}
			
			if( !JFile::upload($themelet_details['tmp_name'], $themelet_dir.'/'.strtolower(basename($themelet_details['name']))) ){
				return array('error' => 'Could not move file to required location!');
			}
			
			$themelet_name = str_replace('themelet_', '', strtolower(basename($themelet_details['name'])));
			$themelet_name = str_replace(strstr($themelet_name, '_'), '', $themelet_name);
			if(is_dir($themelet_dir.'/'.$themelet_name)){
				$backupdir = JPATH_SITE.'/morph_assets/backups';
				$backupfile = $backupdir.'/file_themelet_'.$themelet_name . '_' . time();
				if(!@Jarchive::create($backupfile, $themelet_dir.'/'.$themelet_name, 'gz', '', $themelet_dir, true)){
					return array('error' => 'Could not backup themelet!');
				}
				JFolder::delete($themelet_dir.'/'.$themelet_name);
			}else{
				$backupfile = '';
			}
		
			JPath::setPermissions($themelet_dir.'/'.strtolower(basename($themelet_details['name'])));
			
			// Backup custom files
			//$unpack_dir = $themelet_dir.'/'.strtolower(basename($themelet_details['name']));
			//$backups = array('/css/custom.css','/js/custom.js');
			//foreach($backups as $backup)
			//{
			//	if(JFile::exists($unpack_dir.$backup)) JFile::move($backup, dirname($backup).'/backup.'.basename($backup), $unpack_dir);
			//}
			$msg = $this->unpackThemelet($themelet_dir.'/'.strtolower(basename($themelet_details['name'])), $backupfile);
			
			$db = JFactory::getDBO();
			// db queries to add custom CSS/PHP/JS to the database table for the themelet.
			// custom PHP
			// @TODO add check for preventing loss of custom code
			$db->setQuery("SELECT COUNT(*) from `#__configurator_customfiles` WHERE `filename` = 'custom.php' AND `parent_name` = '".$themelet_name."';");
			if($db->loadResult() == 0) {
				$db->setQuery("INSERT INTO `#__configurator_customfiles` VALUES ( NULL, 'themelet', '".$themelet_name."', 'custom.php', '', FROM_UNIXTIME(".time().") );");
				$db->query();
			}
			// custom CSS
			// @TODO add check for preventing loss of custom code
			$db->setQuery("SELECT COUNT(*) from `#__configurator_customfiles` WHERE `filename` = 'custom.css.php' AND `parent_name` = '".$themelet_name."';");
			if($db->loadResult() == 0) {
				$db->setQuery("INSERT INTO `#__configurator_customfiles` VALUES ( NULL, 'themelet', '".$themelet_name."', 'custom.css.php', '', FROM_UNIXTIME(".time().") );");
				$db->query();
			}
			// custom JS
			// @TODO add check for preventing loss of custom code
			$db->setQuery("SELECT COUNT(*) from `#__configurator_customfiles` WHERE `filename` = 'custom.js.php' AND `parent_name` = '".$themelet_name."';");
			if($db->loadResult() == 0) {
				$db->setQuery("INSERT INTO `#__configurator_customfiles` VALUES ( NULL, 'themelet', '".$themelet_name."', 'custom.js.php', '', FROM_UNIXTIME(".time().") );");
				$db->query();
			}
			
			// custom footer code
			// @TODO add check for preventing loss of custom code
			$db->setQuery("SELECT COUNT(*) from `#__configurator_customfiles` WHERE `filename` = 'script.php' AND `parent_name` = '".$themelet_name."';");
			if($db->loadResult() == 0) {
				$db->setQuery("INSERT INTO `#__configurator_customfiles` VALUES ( NULL, 'themelet', '".$themelet_name."', 'script.php', '', FROM_UNIXTIME(".time().") );");
				$db->query();
			}
			
			return $msg;
		}
		return array('error' => 'There was an error uploading the file. Please try again.');
	}
	
	protected function _actionGet_current_themelet(){
		$themelet = $this->getModel()->getItem()->themelet;
		
		echo $themelet;
		return true;
	}

	protected function _actionThemelet_activate(KCommandContext $context)
	{
		$themelet = isset($context->data->themelet) ? $context->data->themelet : '';
	
		$db		= JFactory::getDBO();
		$table	= $this->getModel()->getTable();
		
		$template_dir = JPATH_ROOT.'/templates/morph';
		$themelet_dir = JPATH_ROOT.'/morph_assets/themelets';
		
		$query="SELECT * FROM `#__configurator` WHERE template_name='morph'";
		$db->setQuery($query);
		$template_params = $db->loadAssocList('param_name');
				
		// themelet
		$curr_themelet = '';
		if(isset($template_params['themelet'])) { $curr_themelet = $template_params['themelet']['param_value']; }
		if(isset($_COOKIE['current_themelet'])) { $curr_themelet = $_COOKIE['current_themelet']; }
			
		// get existing themelet values
		$query = "select * from #__configurator where source = 'themelet';";
		$query = $db->setQuery( $query );
		$result = $db->loadAssocList();
		
		$db_themelet = array();

		if(!empty($result)){
			foreach($result as $t){
				$db_themelet[$t['param_name']] = $t['param_value'];
			}
		}

		if(!empty($db_themelet)){

			$template_xml = $template_dir.'/core/morphDetails.xml';
			
			$xml_param_loader = new ComConfiguratorHelperParamLoader($template_xml);
			$template_xml_params = $xml_param_loader->getParamDefaults();
			
			$removeParams = array(
				'Color Picker Param',
				'Filelist Param',
				'Folderlist Param',
				'Heading Param',
				'Imagelist Param',
				'List Param',
				'Radio Param',
				'Spacer Param',
				'Text Param',
				'Textarea Param',
				'Themelet Param',
			);
							
			$defaults = array();
			foreach($db_themelet as $key => $value){
				if(array_key_exists($key, $template_xml_params)){
					$defaults[$key] = $template_xml_params[$key];
				}
			}
			
			// backup
			$this->create_db_backup('themelet-settings', $curr_themelet);

			// delete themelet settings from database
			$query = "delete from #__configurator where source = 'themelet';";
			$db->setQuery( $query );
			$db->query();
			
			// update original themelet values with
			foreach($defaults as $param_name => $param_value)
			{
				$query	= KFactory::tmp('lib.koowa.database.query')
																	->where('template_name', '=', 'morph')
																	->where('published',	 '=', 1)
																	->where('source',		 '=', 'template')
																	->where('param_name',	 '=', $param_name);
				$row			= $table->select($query, KDatabase::FETCH_ROW);

				$row->template	= 'morph';
				$row->source	= 'template';
				$row->name		= $param_name;
				$row->value		= $param_value;

				$row->save();
			}
		
		}
		
		$themelet = $themelet_dir.'/'.$themelet;
		if(is_file($themelet.'/themeletDetails.xml')){
			$xml_param_loader = new ComConfiguratorHelperParamLoader($themelet.'/themeletDetails.xml');
			$themelet_xml_params = $xml_param_loader->getParamDefaults();
			
			foreach($themelet_xml_params as $param_name => $param_value)
			{
				$query	= KFactory::tmp('lib.koowa.database.query')
																	->where('template_name', '=', 'morph')
																	->where('published',	 '=', 1)
																	->where('source',		 '=', 'template')
																	->where('param_name',	 '=', $param_name);
				$row			= $table->select($query, KDatabase::FETCH_ROW);

				$row->template	= 'morph';
				$row->source	= 'template';
				$row->name		= $param_name;
				$row->value		= $param_value;

				$row->save();
			}
		}
		
		$this->clear_cache();
	}

	protected function _actionThemelet_check_existing(KCommandContext $context)
	{
		if(!isset($context->data->themelet)) return false;
		$themelet = $context->data->themelet;
		
		$backupdir = JPATH_SITE.'/morph_assets/backups/db';
		$files = JFolder::files($backupdir);
		foreach($files as $f){
			if(preg_match('/'.$themelet.'/i', $f)){
				if(file_exists($backupdir.'/'.$f)){
					echo json_encode(array('exists' => 'true'));
					return true;
				}
			}else{
				$exists = false;
			}
		}
		if(!$exists){
			echo json_encode(array('exists' => 'false'));
		}
		
	}
	
	protected function _actionThemelet_activate_existing(KCommandContext $context)
	{
		$db = JFactory::getDBO();
		$query = $db->setQuery("DELETE FROM `#__configurator` where source='themelet';");
		$db->query($query);
		
		if(!isset($context->data->themelet)) return false;
		$themelet = $context->data->themelet;

		$backupdir = JPATH_SITE.'/morph_assets/backups/db';		
		$files = JFolder::files($backupdir);
		foreach($files as $f){
			if(preg_match('/'.$themelet.'/i', $f)){
				JArchive::extract($backupdir.'/'.$f, $backupdir);
				if(file_exists($backupdir.'/'.str_replace('.gz', '', $f))){
					$this->parse_mysql_dump($backupdir.'/'.str_replace('.gz', '', $f));
					JFile::delete($backupdir.'/'.str_replace('.gz', '', $f));
					return true;
				}
			}
		}
		
		$this->clear_cache();
	}

	function unpackThemelet($p_filename='', $b){

		$archivename = $p_filename;
		$dirname = uniqid('themeletins_');
		$extractdir = JPath::clean(dirname($p_filename).'/'.$dirname);
		$archivename = JPath::clean($archivename);
		
		$result = JArchive::extract( $archivename, $extractdir);
		if ( $result === false ) {
			return false;
		}
	
		$retval['extractdir'] = $extractdir;
		$retval['packagefile'] = $archivename;
		
		if (JFile::exists($extractdir.'/themeletDetails.xml')){
			$themelet_params = $this->parsexml_themelet_file($extractdir);
		}else{
			$this->cleanupThemeletInstall($retval['packagefile'], $retval['extractdir']);
			return array('error' => 'This is not a valid Themelet Package:<br />The file <strong>themeletDetails.xml</strong> doesn\'t exist or is incorrectly structured!');
		}
		
		//get install dir
		if ($themelet_params) {
			$_themeletdir = trim( strtolower(str_replace(array(' ','_'),'-',$themelet_params->name)) );
		}
		
		if (!$_themeletdir){		
			if (count($dirList) == 1){
				if (JFolder::exists($extractdir.'/'.$dirList[0])){
					$extractdir = JPath::clean($extractdir.'/'.$dirList[0]);
				}
			}
		} else {
			JFolder::move($extractdir, dirname($p_filename).'/'.$_themeletdir);	
		}
		
		if (JFolder::exists( dirname($p_filename).'/'.$_themeletdir ) ) {
			$retval['dir'] = $extractdir;
			$this->cleanupThemeletInstall($retval['packagefile'], $retval['extractdir']);
			return array(
				'error'			=> '',
				'success'		=> 'Themelet Successfully Installed',
				'themelet'		=> $_themeletdir,
				'backuploc'		=> $b,
				'msg'			=> 'Themelet Successfully Installed',
				
				
			);
		}
		
	}
	
	function cleanupThemeletInstall($package='', $resultdir=''){
		$config = JFactory::getConfig();
		if (is_dir($resultdir)) { JFolder::delete($resultdir); }
		if (is_file($package)) {
			JFile::delete($package);
		} elseif (is_file(JPath::clean($config->getValue('config.tmp_path').'/'.$package))) {
			// It might also be just a base filename
		JFile::delete(JPath::clean($config->getValue('config.tmp_path').'/'.$package));
		}
	}
	
	function parsexml_themelet_file($themeletDir){
		// Check if the xml file exists
		if(!is_file($themeletDir.'/themeletDetails.xml')) {
			return false;
		}
		
		$xml = simplexml_load_file($themeletDir.'/themeletDetails.xml');
		
		if ((string)$xml['type'] != 'themelet') {
			return false;
		}
		
		$data = (array) clone $xml;
		$data['type']		 = (string)$xml['type'];
		$data['directory'] = $themeletDir;
		
		$data['checked_out'] = 0;
		$data['mosname'] = JString::strtolower(str_replace(' ', '_', $data['name']));

		return (object) $data;
	}
 }