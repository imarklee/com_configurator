<?php
defined ('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.archive');
jimport('joomla.filesystem.path');

class ConfiguratorController extends JController {

	function manage() {
		global $mainframe;
		$database = JFactory::getDBO();
		$option = JRequest::getVar('option');
		$template = 'morph';
		$cid = JRequest::getVar('cid',null,'request','array');
		if(is_array($cid)) {
			$template = $cid[0];
		}

		$goto_link = 'index2.php?option='.$option.'&task=manage&t='.$template.'&preset=';
		$goto_javascript = '<script language="JavaScript" type="text/javascript">'."\n".
		'  <!--'."\n".
		'  function gotoPreset(choice) {'."\n".
		'	var index=choice.selectedIndex'."\n".
		'	if (choice.options[index].value != "") {'."\n".
		'	location="'.$goto_link.'"+choice.options[index].value;}'."\n".
		'  }'."\n".
		'  //-->'."\n".
		'  </script>';

		$mainframe->addCustomHeadTag( $goto_javascript );

		$morph_installed = JFolder::exists(JPath::clean( JPATH_ROOT . DS .'templates' ) . DS . $template);
		if ($morph_installed){
			include_once (JPATH_COMPONENT_ADMINISTRATOR . DS . "configurator.common.php");
			$preset_choice = JRequest::getVar('preset',null);
			$preset_values = null;

			$templateBaseDir = JPath::clean( JPATH_ROOT . DS .'templates' ) . DS . $template;
			if(!empty($preset_choice)) {
				// Load select preset values from the XML file.
				$preset_values = getPresetParamList( $templateBaseDir . DS . 'core/morphDetails.xml', $preset_choice );
		}

		$paramList = getTemplateParamList( $templateBaseDir . DS . 'core/morphDetails.xml' );
		for($i=0;$i<count($paramList);$i++) $paramList[$i] .= '=';

			if ( $template ) {
				// do stuff for existing records
				// load existing settings for this template.
				$query="SELECT * FROM #__configurator AS t WHERE t.template_name='{$template}'";
				$database->setQuery( $query );
				$template_params = $database->loadAssocList('param_name');
				$template_settings = array();

				foreach ( (array) $template_params as $template_param ) {
					$template_settings[] = $template_param['param_name'] . '=' . $template_param['param_value'] . "\n";
				}
			} else {
				// do stuff for new records
				$row->published     =1;
				$row->date_submitted=date('Y-m-d H:i:s');
				$row->id            =0;
				$pics               =null;
			}

			if( count( $template_settings ) && empty($preset_choice) ) {
				// Got settings from the DB.
				$current_params = implode( "\n", $template_settings );
			} elseif( isset($preset_values) ) {
				// Got settings from the preset.
				$current_params = implode( "\n", $preset_values );
			} else {
				// Default empty.
				$current_params = implode( "\n", $paramList );
			}

			// Load customization file for dynamic option parameters.
			$custom_params = '';
			if(file_exists($templateBaseDir.DS.'core'.DS.'morphCustom.php')) {
				include($templateBaseDir.DS.'core'.DS.'morphCustom.php');
				if(function_exists('getCustomMorphParams')) {
					$custom_params = getCustomMorphParams($template);
				}
			}

			// Create the morph params
			$params = new JParameter($current_params, $templateBaseDir.DS.'core'.DS.'morphDetails.xml');        
			if(!empty($custom_params)) {
				// Merge loaded custom dynamic params into existing.
				// $params->insertEntities( $custom_params, 'params' );
			}
			$params->name = $template;
			
			$lists = array();
			// Load presets from XML file.
			$xml_param_loader = new morphXMLLoader($templateBaseDir.DS.'core'.DS.'morphDetails.xml');
			$main_xml_params = $xml_param_loader->getParamDefaults();
			
			$params->use_favicons = $xml_param_loader->use_favicons;
			
			$presets = $xml_param_loader->preset_list;
			
			if(isset($presets)) {
				$preset_options = array();
				$preset_options[] = JHTML::_('select.option','Custom/None');
			
				foreach($presets as $preset) {
					$preset_options[] = JHTML::_('select.option',$preset, $preset);
				}
			
				$selected_option = isset($preset_choice)? $preset_choice : null;
				if(!isset($selected_option)) isset($template_params['preset']['param_value'])?$template_params['preset']['param_value']:null;
				$lists['preset_list'] = JHTML::_( 'select.genericlist', $preset_options, 'params[preset]','id="preset" onchange="gotoPreset(this)"', 'value','text',$selected_option);
			} else {
				$lists['preset_list'] = ' No presets defined.';
			}

			// Load list of themelets (if they exist).
			$themelet_dir = JPATH_SITE . DS . 'morph_assets' . DS . 'themelets';          

			if(is_dir($themelet_dir)) $lists['themelets'] = JFolder::folders( $themelet_dir );
			else $lists['themelets'] = null;
			foreach ($lists['themelets'] as $themelet){
				// Create the morph params
				$themelet_params = $this->parsexml_themelet_file($themelet_dir.DS.$themelet);
				$lists[$themelet] = $themelet_params;
			}

			$lists['themelets_dir'] = $themelet_dir;
			
			// Load list of logos (if they exist).
			$logo_dir = JPATH_SITE.DS.'morph_assets'.DS.'logos';
			if(is_dir($logo_dir)) $lists['logos'] = JFolder::files( $logo_dir, '.jpg|.png|.gif' );
			else $lists['logos'] = null;
			$lists['logo_dir'] = $logo_dir;
			
			// Load list of backgrounds (if they exist).
			$bg_dir = JPATH_SITE.DS.'morph_assets'.DS.'backgrounds';
			if(is_dir($bg_dir)) $lists['backgrounds'] = JFolder::files( $bg_dir, '.jpg|.png|.gif' );
			else $lists['backgrounds'] = null;
			$lists['bg_dir'] = $bg_dir;
			
			unset($xmlDoc);

		}
	HTML_configurator_admin::manage( $params, $lists, $morph_installed );
	}


	function removeicon() {
		global $mainframe;
		$option = JRequest::getVar('option');
		$template = JRequest::getVar('t',null);
		$icon_file = JRequest::getVar('f',null);
		
		if( is_null($template) || is_null($icon_file) ) $mainframe->redirect("index2.php?option={$option}&task=dashboard");
		$full_filename = JPATH_ROOT . DS . 'templates' . DS . $template . DS . 'favicons' . DS . $icon_file;
		
		if( file_exists( $full_filename ) ) @unlink( $full_filename );
		$mainframe->redirect("index2.php?option={$option}&task=manage", "Favicon ({$icon_file}) removed." );
	}  
	
	
	function applytemplate() {
		global $mainframe;
		$database = JFactory::getDBO();
		$template_name = JRequest::getVar('t');
		$option = JRequest::getVar('option');
		
		//$params[0] = JRequest::getVar( 'params', null, 'post', 'array' );
		$params[1] = JRequest::getVar( 'general', null, 'post', 'array' );
		$params[2] = JRequest::getVar( 'logo', null, 'post', 'array' );
		$params[3] = JRequest::getVar( 'backgrounds', null, 'post', 'array' );
		$params[4] = JRequest::getVar( 'color', null, 'post', 'array' );
		$params[5] = JRequest::getVar( 'progressive', null, 'post', 'array' );
		$params[6] = JRequest::getVar( 'menu', null, 'post', 'array' );
		$params[7] = JRequest::getVar( 'performance', null, 'post', 'array' );
		$params[8] = JRequest::getVar( 'debugging', null, 'post', 'array' );
		//$params[9] = JRequest::getVar( 'miscellaneous', null, 'post', 'array' );
		$params[10] = JRequest::getVar( 'toolbar', null, 'post', 'array' );
		$params[11] = JRequest::getVar( 'masterhead', null, 'post', 'array' );
		$params[12] = JRequest::getVar( 'subhead', null, 'post', 'array' );
		$params[13] = JRequest::getVar( 'topnav', null, 'post', 'array' );
		$params[14] = JRequest::getVar( 'shelves', null, 'post', 'array' );
		$params[15] = JRequest::getVar( 'inlineshelves', null, 'post', 'array' );
		$params[16] = JRequest::getVar( 'insets', null, 'post', 'array' );
		$params[17] = JRequest::getVar( 'main', null, 'post', 'array' );
		$params[18] = JRequest::getVar( 'inner-sidebar', null, 'post', 'array' );
		$params[19] = JRequest::getVar( 'outer-sidebar', null, 'post', 'array' );
		$params[20] = JRequest::getVar( 'footer', null, 'post', 'array' );
		
		$preset_name = JRequest::getVar('preset_coice', '');
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_configurator'.DS.'tables');
				
		foreach ($params as $currentblock){      
	
			foreach($currentblock as $param_key => $param_value) {
			
				$setting = JTable::getInstance('ConfiguratorTemplateSettings','Table');
				$setting->template_name = $template_name;
				$setting->param_name = $param_key;
				
				$setting->loadByKey();
				
				$setting->param_value = $param_value;
				$setting->published = 1;
	
				if (!$setting->store()) {
					echo "<script> alert('" . $setting->getError() . "'); window.history.go(-1); </script>\n";
					exit();
				}
	
				unset($setting);
				$setting = null;        	
			}
		}
		if(!JRequest::getVar('isajax', null, 'post')){
			$msg = JText::_('Successfully saved your settings');
			// delete change cookie if exists
			if(isset($_COOKIE['formChanges'])){ setcookie('formChanges', 'false', time()-3600); }
			$mainframe->redirect("index2.php?option={$option}&task=manage",$msg);
		}else{
			// delete change cookie if exists
			if(isset($_COOKIE['formChanges'])){ setcookie('formChanges', 'false', time()-3600); }
			return true;
		}
		
		
		
	}    
	
	function savetemplate() {
		global $mainframe;
		$database = JFactory::getDBO();
		$template_name = JRequest::getVar('t');
		$option = JRequest::getVar('option');
	
		
		$params[0] = JRequest::getVar( 'params', null, 'post', 'array' );
		$params[1]	= JRequest::getVar( 'general', null, 'post', 'array' );
		$params[2]    = JRequest::getVar( 'logo', null, 'post', 'array' );
		$params[3]    = JRequest::getVar( 'background', null, 'post', 'array' );
		$params[4]    = JRequest::getVar( 'color', null, 'post', 'array' );
		$params[5]    = JRequest::getVar( 'progressive', null, 'post', 'array' );
		$params[6]    = JRequest::getVar( 'menu', null, 'post', 'array' );
		$params[7]    = JRequest::getVar( 'performance', null, 'post', 'array' );
		$params[8]    = JRequest::getVar( 'debugging', null, 'post', 'array' );
		$params[9]    = JRequest::getVar( 'miscellaneous', null, 'post', 'array' );
		$params[10]    = JRequest::getVar( 'toolbar', null, 'post', 'array' );
		$params[11]    = JRequest::getVar( 'masterhead', null, 'post', 'array' );
		$params[12]    = JRequest::getVar( 'subhead', null, 'post', 'array' );
		$params[13]    = JRequest::getVar( 'topnav', null, 'post', 'array' );
		$params[14] = JRequest::getVar( 'shelves', null, 'post', 'array' );
		$params[15] = JRequest::getVar( 'inlineshelves', null, 'post', 'array' );
		$params[16] = JRequest::getVar( 'insets', null, 'post', 'array' );
		$params[17] = JRequest::getVar( 'main', null, 'post', 'array' );
		$params[18] = JRequest::getVar( 'inner-sidebar', null, 'post', 'array' );
		$params[19] = JRequest::getVar( 'outer-sidebar', null, 'post', 'array' );
		$params[20] = JRequest::getVar( 'footer', null, 'post', 'array' );
		
		$preset_name = JRequest::getVar('preset_coice', '');
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_configurator'.DS.'tables');
		//$row = &JTable::getInstance('ConfiguratorTemplateSettings','Table');
		
		
		foreach ($params as $currentblock){      		
			foreach($currentblock as $param_key=>$param_value) {
			
				$setting = JTable::getInstance('ConfiguratorTemplateSettings','Table');
				$setting->template_name = $template_name;
				$setting->param_name = $param_key;
				
				$setting->loadByKey();
				
				$setting->param_value = $param_value;
				$setting->published = 1;
				
				if (!$setting->store()) {
					echo "<script> alert('" . $setting->getError() . "'); window.history.go(-1); </script>\n";
					exit();
				}
			
				unset($setting);
				$setting = null;        	
			}
		}      
		
		$msg = JText::_('Successfully saved your settings!');
		$mainframe->redirect("index2.php?option={$option}&task=dashboard",$msg);
	} 
	
	function dashboard() {
		global $mainframe;
		$mainframe->redirect('index.php?option=com_configurator&task=manage');
		parent::display();
		//HTML_configurator_admin::dashboard();
	}
	
	function display(){
		global $mainframe;
		$mainframe->redirect('index.php?option=com_configurator&task=manage');
		parent::display();
	}
	
	function findLine($filename, $str){
		$file = file($filename);
		$file = array_map('trim', $file);
		$find = array_search($str, $file);
		return $find === false ? false:$find + 1;
	}  
	
	function makehash(){
		if(isset($_POST['tempuserpass'])){
			$pass = $_POST['tempuserpass'];
			if($pass){
				$salt = 'we are the champions, my friend';
				echo sha1(md5($pass.$salt));
			}
		}else{
			die('no post data');
		}
	}
	
	function uni_installer(){
		$return = '';		
		if( JRequest::getVar('do') && JRequest::getVar('do') == 'upload' ){
			$install_type =  JRequest::getVar('itype');
			$the_files = JRequest::getVar( 'insfile', null, 'files', 'array' );
			if($install_type != 'undefined'){
				if($the_files['name'] != ''){
					switch($install_type){
						case 'themelet':
						$return = $this->themelet_upload();
						break;
						case 'logo':
						$return = $this->logo_upload();
						break;
						case 'background':
						$return = $this->background_upload();
						break;
						case 'favicon':
						$return = $this->favicon_upload();
						break;
					}
				}else{
					$return = 'error: "No file has been selected. Please select a file in <strong>Step 2</strong> and try again."';
					$ret = ' {'.$return.'}';
					echo $ret;
					return false;
				}
			}else{
				$return = 'error: "No install type has been selected. Please make a selection in <strong>Step 1</strong> and try again."';
				$ret = ' {'.$return.'}';
				echo $ret;
				return false;
			}
		}else{
			$return = 'error: "Upload failed: No post data!"';
		}
		
		$ret = '{'.$return.'}';
		echo $ret;
	}
	
	function themelet_upload($file = '') {
		$msg = '';
		$error = '';
		$template = 'morph';
		if($file == ''){
			$themelet_details = JRequest::getVar( 'insfile', null, 'files', 'array' );
		}else{
			$themelet_details = $file;
		}
		$themelet_type = $themelet_details['type'];
		$allowed_types = array('application/zip', 'application/x-zip-compressed', 'application/octet-stream');
		if(!in_array($themelet_type, $allowed_types)){
			$error = 'error: "This is not a valid themelet package.<br />Please try again with a valid themelet package (zip file)"';
			return $error;
		}else{
			// if there is no file error then continue
			if($themelet_details['error'] != 4) {
				$themelet_dir = JPATH_ROOT . DS .'morph_assets'. DS . 'themelets';
				
				// errors
				if( $themelet_details['error'] ){
					$error = 'error: "Upload error ('.$themelet_details['error'].')"';
					return $error;
				}
				if( !is_uploaded_file($themelet_details['tmp_name']) ){ 
					$error = 'error: "Not an uploaded file! Hack attempt?"';
					return $error;
				}
				if( file_exists($themelet_dir . DS . strtolower(basename($themelet_details['name']))) ) {
					$error = 'error: "A file with that name already exists!"';
					return $error;
				}
				if( !is_dir($themelet_dir) ) {
					// Directory doesnt exist, try to create it.
					if( !mkdir($themelet_dir) ){
						$error = 'error: "Could not save file, directory does not exist!"';
						return $error;
					}else{
						JPath::setPermissions($themelet_dir);
					}
				}
				if( !is_writable($themelet_dir) ){
					$error = 'error: "Could not save file, permission error!"';
					return $error;
				}
				if( !move_uploaded_file($themelet_details['tmp_name'], $themelet_dir . DS . strtolower(basename($themelet_details['name']))) ){
					$error = 'error: "Could not move file to required location!"';
					return $error;
				}
			
				JPath::setPermissions($themelet_dir . DS . strtolower(basename($themelet_details['name'])));
				$msg = $this->unpackThemelet($themelet_dir . DS . strtolower(basename($themelet_details['name'])));
				return $msg;
			}
			$error = 'error: "There was an error uploading the file. Please try again."';
			return $error;
		}
	}
	
	function unpackThemelet($p_filename){
		$archivename = $p_filename;
		$dirname = uniqid('themeletins_');
		$extractdir = JPath::clean(dirname($p_filename).DS.$dirname);
		$archivename = JPath::clean($archivename);
		
		$result = JArchive::extract( $archivename, $extractdir);
		if ( $result === false ) {
			return false;
		}
	
		$retval['extractdir'] = $extractdir;
		$retval['packagefile'] = $archivename;
		
		if (JFile::exists($extractdir.DS.'themeletDetails.xml')){
			$themelet_params = $this->parsexml_themelet_file($extractdir);
		}else{
			$this->cleanupThemeletInstall($retval['packagefile'], $retval['extractdir']);
			$error = 'error: "This is not a valid Themelet Package:<br />The file <strong>themeletDetails.xml</strong> doesn\'t exist or is incorrectly structured!"';
			return $error;
		}
		
		//get install dir
		if ($themelet_params) {
			$_themeletdir = trim( strtolower(str_replace(array(' ','_'),'-',$themelet_params->name)) );
		}
		
		if (!$_themeletdir){		
			if (count($dirList) == 1){
				if (JFolder::exists($extractdir.DS.$dirList[0])){
					$extractdir = JPath::clean($extractdir.DS.$dirList[0]);
				}
			}
		} else {
			JFolder::move($extractdir, dirname($p_filename).DS.$_themeletdir);	
		}
		
		if (JFolder::exists( dirname($p_filename).DS.$_themeletdir ) ) {
			$retval['dir'] = $extractdir;
			$this->cleanupThemeletInstall($retval['packagefile'], $retval['extractdir']);
			$success = 'success: "Themelet Successfully Installed", themelet: "'.$_themeletdir.'", error: "", msg: "Themelet Successfully Installed", themelet: "'.$_themeletdir.'"';
			return $success;
		}
		
	}
	
	function cleanupThemeletInstall($package, $resultdir){
		$config =& JFactory::getConfig();
		if (is_dir($resultdir)) { JFolder::delete($resultdir); }
		if (is_file($package)) {
			JFile::delete($package);
		} elseif (is_file(JPath::clean($config->getValue('config.tmp_path').DS.$package))) {
			// It might also be just a base filename
		JFile::delete(JPath::clean($config->getValue('config.tmp_path').DS.$package));
		}
	}
	
	function parsexml_themelet_file($themeletDir){
		// Check if the xml file exists
		if(!is_file($themeletDir.DS.'themeletDetails.xml')) {
			return false;
		}
		
		$xml = JApplicationHelper::parseXMLInstallFile($themeletDir.DS.'themeletDetails.xml');
		
		if ($xml['type'] != 'themelet') {
			return false;
		}
		
		$data = new StdClass();
		$data->directory = $themeletDir;
		
		foreach($xml as $key => $value) {
			$data->$key = $value;
		}
		
		$data->checked_out = 0;
		$data->mosname = JString::strtolower(str_replace(' ', '_', $data->name));
		
		return $data;
	}
	
	function logo_upload() {
		$msg = '';
		$error = '';
		$template = 'morph';
		$logo_details = JRequest::getVar( 'insfile', null, 'files', 'array' );
		$image_type = $logo_details['type'];
		$allowed_types = array('image/jpeg','image/png', 'image/jpg', 'image/gif');
	
		if(!in_array($image_type, $allowed_types)){
			$error = 'error: "This is not a valid logo file.<br />Please try again with a valid logo (png/gif/jpg)"';
			return $error;
		}else{
			// if there is no file error then continue
			if($logo_details['error'] != 4) {
				$logo_dir = JPATH_SITE.DS.'morph_assets'.DS.'logos';
				
				// errors
				if( $logo_details['error'] ){
					$error = 'error: "Upload error ('.$logo_details['error'].')"';
					return $error;
				}
				if( !is_uploaded_file($logo_details['tmp_name']) ){ 
					$error = 'error: "Not an uploaded file! Hack attempt?"';
					return $error;
				}
				if( file_exists($logo_dir . DS . strtolower(basename($logo_details['name']))) ) {
					$error = 'error: "A file with that name already exists!"';
					return $error;
				}
				if( !is_dir($logo_dir) ) {
					// Directory doesnt exist, try to create it.
					if( !mkdir($logo_dir) ){
						$error = 'error: "Could not save file, directory does not exist!"';
						return $error;
					}else{
						JPath::setPermissions($logo_dir);
					}
				}
				if( !is_writable($logo_dir) ){
					$error = 'error: "Could not save file, permission error!"';
					return $error;
				}
				if( !move_uploaded_file($logo_details['tmp_name'], $logo_dir . DS . strtolower(basename($logo_details['name']))) ){
					$error = 'error: "Could not move file to required location!"';
					return $error;
				}
			
				JPath::setPermissions($logo_dir . DS . strtolower( basename( $logo_details['name'] ) ) );
				JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_configurator'.DS.'tables');
				$setting = JTable::getInstance('ConfiguratorTemplateSettings','Table');
				$setting->template_name = $template;
				$setting->param_name = 'templatelogo';
				$setting->loadByKey();
				$setting->param_value = strtolower( basename( $logo_details['name'] ) );
				$setting->store();
				$msg = 'success: "Logo uploaded successfully!", error: "", logo: "'.$logo_details['name'].'"';
				return $msg;
			}
			
			$error = 'error: "There was an error uploading the file. Please try again."';
			return $error;
		}
	}
	
	function background_upload() {
		$msg = '';
		$error = '';
		$template = 'morph';
		$background_details = JRequest::getVar( 'insfile', null, 'files', 'array' );
		$image_type = $background_details['type'];
		$allowed_types = array('image/jpeg','image/png', 'image/jpg', 'image/gif');
	
		if(!in_array($image_type, $allowed_types)){
			$error = 'error: "This is not a valid background file.<br />Please try again with a valid background (png/gif/jpg)"';
			return $error;
		}else{
			// if there is no file error then continue
			if($background_details['error'] != 4) {
				$background_dir = JPATH_SITE.DS.'morph_assets'.DS.'backgrounds';
				
				// errors
				if( $background_details['error'] ){
					$error = 'error: "Upload error ('.$background_details['error'].')"';
					return $error;
				}
				if( !is_uploaded_file($background_details['tmp_name']) ){ 
					$error = 'error: "Not an uploaded file! Hack attempt?"';
					return $error;
				}
				if( file_exists($background_dir . DS . strtolower(basename($background_details['name']))) ) {
					$error = 'error: "A file with that name already exists!"';
					return $error;
				}
				if( !is_dir($background_dir) ) {
					// Directory doesnt exist, try to create it.
					if( !mkdir($background_dir) ){
						$error = 'error: "Could not save file, directory does not exist!"';
						return $error;
					}else{
						JPath::setPermissions($background_dir);
					}
				}
				if( !is_writable($background_dir) ){
					$error = 'error: "Could not save file, permission error!"';
					return $error;
				}
				if( !move_uploaded_file($background_details['tmp_name'], $background_dir . DS . strtolower(basename($background_details['name']))) ){
					$error = 'error: "Could not move file to required location!"';
					return $error;
				}
			
				JPath::setPermissions($background_dir . DS . strtolower( basename( $background_details['name'] ) ) );
				JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_configurator'.DS.'tables');
				$setting = JTable::getInstance('ConfiguratorTemplateSettings','Table');
				$setting->template_name = $template;
				$setting->param_name = 'templatebackground';
				$setting->loadByKey();
				$setting->param_value = strtolower( basename( $background_details['name'] ) );
				$setting->store();
				$msg = 'success: "Background Uploaded Successfully", error: "", background: "'.$background_details['name'].'"';
				return $msg;
			}
			
			$error = 'error: "There was an error uploading the file. Please try again."';
			return $error;
		}
	}
	
	function favicon_upload() {
		$msg = '';
		$error = '';
		$overwrite = '';
		$template = 'morph';
		$favicon_details = JRequest::getVar( 'insfile', null, 'files', 'array' );
		$image_type = $favicon_details['type'];
		$allowed_types = array('image/png', 'image/gif', 'image/ico', 'image/x-icon');
	
		if(!in_array($image_type, $allowed_types)){
			$error = 'error: "This is not a valid favicon file.<br />Please try again with a valid favicon (ico/gif/png)"';
			return $error;
		}else{
			// if there is no file error then continue
			if($favicon_details['error'] != 4) {
				$favicon_dir = JPATH_ROOT . DS .'templates'. DS . $template;
				
				// errors
				if( $favicon_details['error'] ){
					$error = 'error: "Upload error ('.$favicon_details['error'].')"';
					return $error;
				}
				if( !is_uploaded_file($favicon_details['tmp_name']) ){ 
					$error = 'error: "Not an uploaded file! Hack attempt?"';
					return $error;
				}
				if( file_exists($favicon_dir . DS . strtolower(basename('favicon.ico'))) ) {
					$overwrite = 'overwrite: "A favicon file already exists.<br />Overwrite?"';
					return $overwrite;
				}
				if( !is_dir($favicon_dir) ) {
					// Directory doesnt exist, try to create it.
					if( !mkdir($favicon_dir) ){
						$error = 'error: "Could not save file, directory does not exist!"';
						return $error;
					}else{
						JPath::setPermissions($favicon_dir);
					}
				}
				if( !is_writable($favicon_dir) ){
					$error = 'error: "Could not save file, permission error!"';
					return $error;
				}
				if( !move_uploaded_file($favicon_details['tmp_name'], $favicon_dir . DS . strtolower(basename('favicon.ico'))) ){
					$error = 'error: "Could not move file to required location!"';
					return $error;
				}
			
				JPath::setPermissions($favicon_dir . DS . strtolower( basename( $favicon_details['name'] ) ) );
				$msg = 'success: "Favicon Uploaded Successfully", error: ""';
				return $msg;
			}
			
			$error = 'error: "There was an error uploading the file. Please try again."';
			return $error;
		}
	}
	
	function deleteAsset(){
		$type = $_GET['deltype'];
		$asset = $_GET['asset'];
		$assetsdir = JPATH_SITE . DS . 'morph_assets' . DS;
		
		switch($type){
		
			case 'themelet':
			$assetsdir .= 'themelets';
			$assetsfile = $assetsdir . DS . $asset;
			if (is_dir($assetsdir)) {
				if(JFolder::delete($assetsfile)){
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
			break;
			case 'logo':
			$assetsdir .= 'logos';
			$assetsfile = $assetsdir . DS . $asset;			
			if (is_dir($assetsdir)) {
				if(JFile::delete($assetsfile)){
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
			break;
			case 'background':
			$assetsdir .= 'backgrounds';
			$assetsfile = $assetsdir . DS . $asset;			
			if (is_dir($assetsdir)) {
				if(JFile::delete($assetsfile)){
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
			break;
		
		}		
	}
	function install_themelet(){
		ini_set('memory_limit', '32M');
		$newthemeletfile = JRequest::getVar( 'insfile', null, 'files', 'array' );
		$activation = $_REQUEST['act_themelet'];
		$return = $this->themelet_upload($newthemeletfile);
		setcookie('installed_themelet', 'true');
		$themelet = explode(',', $return);
		$themelet = str_replace(array('"', ':', 'themelet', ' '), '', $themelet[1]);
		$themelet_name = str_replace('-',  ' ', $themelet);
		setcookie('ins_themelet_name', $themelet_name);
		if(isset($activation) && $activation == 'true'){
			setcookie('installed_actthemelet', 'true');
			$db = JFactory::getDBO();
			$query = $db->setQuery("select * from #__configurator where param_name = 'themelet'");
			$query = $db->query($query);
			$themelet_num = $db->getNumRows($query);
			if($themelet_num == '0'){
				$new_query = "INSERT INTO jos_configurator VALUES ('' , 'morph', 'themelet', '".mysql_real_escape_string($themelet)."', '1');";
			}else{
				$new_query = "UPDATE jos_configurator SET param_value = '".mysql_real_escape_string($themelet)."' where param_name = 'themelet';";
			}
			$query = $db->setQuery( $new_query );
			$db->query($query) or die($db->getErrorMsg());
		}
		$ret = '{'.$return.'}';
		echo $ret;
	}
	function assets_create(){
	
		$backupdir = JPATH_SITE . DS . 'morph_assets' . DS . 'backups';
		$logosdir = JPATH_SITE . DS . 'morph_assets' . DS . 'logos';
		$backgroundsdir = JPATH_SITE . DS . 'morph_assets' . DS . 'backgrounds';
		$themeletsdir = JPATH_SITE . DS . 'morph_assets' . DS . 'themelets';
		
		JPath::setPermissions(JPATH_SITE);
		
		// create assets folder
		if(!@mkdir(JPATH_SITE . DS . 'morph_assets')){
			$error = 'error: "There was an error creating the assets folder. Please check your permissions."';
		}else{
			JPath::setPermissions(JPATH_SITE . DS . 'morph_assets');
		}
	
		if(!@mkdir($backupdir)){
			$error = 'error: "There was an error creating the backup folder. Please check your permission on the assets folder"'; 
		}else{
			JPath::setPermissions($backupdir);
		}
	
		if(!@mkdir($logosdir)){
			$error = 'error: "There was an error creating the logos folder. Please check your permission on the assets folder"'; 
		}else{
			JPath::setPermissions($logosdir);
		}
		
		if(!@mkdir($backgroundsdir)){
				$error = 'error: "There was an error creating the backup folder. Please check your permission on the assets folder"'; 
		}else{
			JPath::setPermissions($backgroundsdir);
		}
		if(!@mkdir($themeletsdir)){
			$error = 'error: "There was an error creating the backup folder. Please check your permission on the assets folder"'; 
		}else{
			JPath::setPermissions($themeletsdir);
		}
		$error = 'error: "There was an error creating the backup folder. Please check your permission on the assets folder"'; 
		if(isset($error)){
			$ret = '{'.$error.'}';
			echo $ret;
		}else{
			echo '{ error: "", success: "Assets folder structure successfully created. You may continue with the installation." }';
		}
	}
	function install_template(){
		ini_set('memory_limit', '32M');
		$newtemplatefile = @JRequest::getVar( 'template-file', null, 'files', 'array' );
		$templatesdir = JPATH_SITE . DS . 'templates';
		$backupdir = JPATH_SITE . DS . 'morph_assets' . DS . 'backups';
		$logosdir = JPATH_SITE . DS . 'morph_assets' . DS . 'logos';
		$backgroundsdir = JPATH_SITE . DS . 'morph_assets' . DS . 'backgrounds';
		$themeletsdir = JPATH_SITE . DS . 'morph_assets' . DS . 'themelets';
		$ret = '';
				
		if(in_array($newtemplatefile['type'], array('application/octet-stream', 'application/zip', 'application/x-zip-compressed'))){
			if(is_dir($templatesdir . DS . 'morph') || $_REQUEST['backup'] !== 'nomorph'){
				// template folder
				if($_REQUEST['backup'] == 'true'){
					setcookie('installed_bkpmorph', 'true');
					// backup existing
					$backupfile = $backupdir . DS . 'morph_files_' . date("His_dmY");
					if(!@Jarchive::create($backupfile, $templatesdir . DS . 'morph', 'gz', '', $templatesdir, true)){
						// error creating archive
						$error = 'There was an error creating the archive. Install failed'; 
						$ret = '{'.$error.'}';
						echo $ret;
					}else{
						// remove existing
						@JPath::setPermissions($templatesdir . DS . 'morph');
						if(!$this->deleteDirectory($templatesdir . DS . 'morph')){
							// fail: error removing existing folder
							$error = 'There was an error removing the old install. Install failed';	
							$ret = '{'.$error.'}';
							echo $ret;
						}else{
							if( !move_uploaded_file($newtemplatefile['tmp_name'], $templatesdir . DS . strtolower(basename($newtemplatefile['name']))) ){
								$error = 'error: "Could not move file to required location!"';
								$ret = '{'.$error.'}';
								echo $ret;
							}
							// directory doesn't exist - install as per usual
							@JPath::setPermissions($templatesdir . DS . strtolower(basename($newtemplatefile['name'])));
							$msg = $this->unpackTemplate($templatesdir . DS . strtolower(basename($newtemplatefile['name'])), $_REQUEST['publish']);
							$msg .= ', backuploc: "'.$backupfile.'.gz"';
							setcookie('installed_morph', 'true');
							$ret = '{'.$msg.'}';
							echo $ret;
						}
					}
				}else{
					// remove existing
					if(!$this->deleteDirectory($templatesdir . DS . 'morph')){
						// fail: error removing existing folder
						$error = 'There was an error removing the old install. Install failed';	
						$ret = '{'.$error.'}';
						echo $ret;
					}else{
						if( !move_uploaded_file($newtemplatefile['tmp_name'], $templatesdir . DS . strtolower(basename($newtemplatefile['name']))) ){
							$error = 'error: "Could not move file to required location!"';
							$ret = '{'.$error.'}';
							echo $ret;
						}
						// directory doesn't exist - install as per usual
						@JPath::setPermissions($templatesdir . DS . strtolower(basename($newtemplatefile['name'])));
						$msg = $this->unpackTemplate($templatesdir . DS . strtolower(basename($newtemplatefile['name'])), $_REQUEST['publish']);
						setcookie('installed_morph', 'true');
						$ret = '{'.$msg.'}';
						echo $ret;
					}
				}
			}else{
				if( !move_uploaded_file($newtemplatefile['tmp_name'], $templatesdir . DS . strtolower(basename($newtemplatefile['name']))) ){
					$error = 'error: "Could not move file to required location!"';
					$ret = '{'.$error.'}';
					echo $ret;
				}
				// directory doesn't exist - install as per usual
				@JPath::setPermissions($templatesdir . DS . strtolower(basename($newtemplatefile['name'])));
				$msg = $this->unpackTemplate($templatesdir . DS . strtolower(basename($newtemplatefile['name'])), $_REQUEST['publish']);
				setcookie('installed_morph', 'true');
				$ret = '{'.$msg.'}';
				echo $ret;
			}
		}else{
			$error = 'error: "This is not a valid template package.<br />Please try again with a valid template package (zip file)"';
			$ret = '{'.$error.'}';
			echo $ret;
		}
	}
	
	function deleteDirectory($dir) {
        if (!file_exists($dir)) return true;
        if (!is_dir($dir)) return unlink($dir);
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') continue;
            if (!$this->deleteDirectory($dir.DIRECTORY_SEPARATOR.$item)) return false;
        }
        return rmdir($dir);
    }
	
	function parsexml_template_file($templateDir){
		// Check if the xml file exists
		if(!is_file($templateDir.DS.'templateDetails.xml')) {
			return false;
		}
		
		$xml = JApplicationHelper::parseXMLInstallFile($templateDir.DS.'templateDetails.xml');
		
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
	
	function unpackTemplate($p_filename, $publish = ''){
		$archivename = $p_filename;
		$dirname = uniqid('tempins_');
		$extractdir = JPath::clean(dirname($p_filename).DS.$dirname);
		$archivename = JPath::clean($archivename);
		
		$result = JArchive::extract( $archivename, $extractdir);
		if ( !$result ) {
			$error = 'error: "There was an error extracting the file! '.$extractdir.'"';
			return $error;
		}
	
		$retval['extractdir'] = $extractdir;
		$retval['packagefile'] = $archivename;
		
		if (JFile::exists($extractdir.DS.'templateDetails.xml')){
			$template_params = $this->parsexml_template_file($extractdir);
		}else{
			$this->cleanupThemeletInstall($retval['packagefile'], $retval['extractdir']);
			$error = 'error: "This is not a valid Template Package:<br />The file <strong>templateDetails.xml</strong> doesn\'t exist or is incorrectly structured!"';
			return $error;
		}
		
		//get install dir
		if ($template_params) {
			$_templatedir = trim( strtolower(str_replace(array(' ','_'),'-',$template_params->name)) );
		}
		
		if (!$_templatedir){		
			if (count($dirList) == 1){
				if (JFolder::exists($extractdir.DS.$dirList[0])){
					$extractdir = JPath::clean($extractdir.DS.$dirList[0]);
				}
			}
		} else {
			JFolder::move($extractdir, dirname($p_filename).DS.$_templatedir);	
		}
		
		if (JFolder::exists( dirname($p_filename).DS.$_templatedir ) ) {
			$retval['dir'] = $extractdir;
			$this->cleanupThemeletInstall($retval['packagefile'], $retval['extractdir']);
			
			if($publish !== 'false'){
				setcookie('installed_pubmorph', 'true');
				if(file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_configurator'.DS.'installer'.DS.'sql'.DS.'set-template-as-default.sql')){
					$this->parse_mysql_dump(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_configurator'.DS.'installer'.DS.'sql'.DS.'set-template-as-default.sql');
				}else{
					$error = 'error: "SQL file doesn\'t exist"';
					return $error;
				}
			}
			
			$success = 'msg: "Template Successfully Installed", error: ""';
			return $success;
		}
		
	}
	
	function get_structure() { 
        $sql = null;
		$sql_structure = null;
		$sql_data = null;
		$i = 0;
		
		$db = JFactory::getDBO();
		$td = $db->getTableList();
		$r = $db->getTableCreate($td);
			
		$sql_structure = null;
		if($r){
			foreach($r as $k => $v){
				$sql_structure .= 'DROP TABLE IF EXISTS `'. $k . "`;\n" . $v . ";\n\n";
				$table[] = $k;
			}
		}
		
		$insert_sql = null;
		foreach($table as $t){
			$db->setQuery("SELECT * FROM `$t`"); 
			$data = $db->loadAssocList();
			if(!empty($data)){
				foreach ($data as $v){
					$sql_data .= "INSERT INTO `$t` VALUES(";
					foreach ($v as $row) { 
						if ($i++>0) $sql_data .=", ";
						$sql_data .=  "'" . mysql_real_escape_string($row) . "'";
					} 
					$sql_data .= ");\n";	
				}
				if ($i++>0) $sql_data .="\n";
			}
		}
		
		$sql = '--- Create Database Structure' . "\n\n" . $sql_structure  . "\n\n" . '--- Create Inserts' . "\n\n" . $sql_data;
		return $sql; 
	}
	
	function create_sql_file($filename, $str){
		ini_set('memory_limit', '32M');
		$h = fopen($filename, 'w'); 
    	$gzdata = gzencode($str, 9); 
   		fwrite($h, $gzdata);
		fclose($h);
	}
	
	function parse_mysql_dump($url, $json = 'false') {
	    $handle = fopen($url, "r");
	    $query = "";
	    $db = JFactory::getDBO();
	    while(!feof($handle)) {
	        $sql_line = fgets($handle);
	        if (trim($sql_line) != "" && strpos($sql_line, "--") === false) {
	            $query .= $sql_line;
	            if (preg_match("/;[\040]*\$/", $sql_line)) {
		            if(!$json){
		            	
						$query = $db->setQuery( $query );
						$result = $db->query($query) or die($db->getErrorMsg());
		               	$query = "";
		            }else{
		            	$query = $db->setQuery( $query );
						$result = $db->query($query) or die(json_encode(array('error' => 'MySQL error!<br />Line: <small>'.$sql_line.'</small><br />File: '.$url.'<br />Error: '.$db->getErrorMsg())));
		            	$query = "";
		            }
	            }
	        }
	    }
	}
	
	function install_sample(){
		(isset($_POST['sample_data'])) ? $sample = $_POST['sample_data'] : $sample = false;
		(isset($_POST['db'])) ? $dbdata = $_POST['db'] : $dbdata = false;
		(isset($_POST['gzip'])) ? $gzip = true : $gzip = false;
		
		if($gzip){
			$path = JPATH_CONFIGURATION.DS.'configuration.php';
			JPath::setPermissions($path, '0777');
			if(file_exists($path) && is_writable($path)){			
				$str = file_get_contents($path);
				$line = str_replace('var $gzip = \'0\';', 'var $gzip = \'1\';', $str);
				file_put_contents($path, $line);
			}		
			JPath::setPermissions($path, '0644');
			setcookie('installed_gzip', 'true');
		}
				
		$message = array();
		$backupdir = JPATH_SITE . DS . 'morph_assets' . DS . 'backups' . DS . 'db';
		$sqldir = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_configurator'.DS.'installer'.DS.'sql'.DS;
		
		$sqlfiles = array(
			'sample' => 'sample.sql',
			'module' => 'modules.sql',
			'basic' => 'base-setup.sql'
		);
		
		if(!is_dir($backupdir)){mkdir($backupdir);}
		@JPath::setPermissions($backupdir);
		
		// validation
		if(!$sample && !$dbdata && !$gzip){
			$message['error'] = 'No options selected: Please select an option or skip this step.';
		}else{
			if($dbdata == 'backup'){
				
				$conf = JFactory::getConfig();
				$database = $conf->getValue('config.db');
				
				$backupfile = 'morphdb_'.$database.'_'.date("His_dmY").'.sql.gz';
				$this->create_sql_file($backupdir.'/'.$backupfile, $this->get_structure());
				$message['db'] = 'backedup';
				$message['dbstore'] = "$backupdir/$backupfile"; 
				setcookie('installed_bkpdb', 'true');
				
			}else{
				$message['db'] = 'destroyed';
			}
			
			if(!empty($sample)){
				$error = false;
				foreach($sample as $data){
					if(file_exists($sqldir . $sqlfiles[$data])){
						$message['error'] = $this->parse_mysql_dump($sqldir	. $sqlfiles[$data], true);
					}else{
						$error = true;
					}
				}
				if(in_array('module', $sample)){
					$path = JPATH_SITE.DS.'templates/system/html';
					$override = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_configurator'.DS.'installer'.DS.'overrides'.DS.'modules.php';
					JPath::setPermissions($path, '0777');
					if(is_writable($path)){			
						unlink($path.'/modules.php');
						copy($override, $path.'/modules.php');
					}		
					JPath::setPermissions($path, '0644');
					setcookie('installed_samplemods', 'true');
				}
				
				if(in_array('sample', $sample)){
					setcookie('installed_samplecont', 'true');
				}
				
				if(!$error){
					$message['success'] = 'Sample data successfully installed';
					if($message['error'] == null){ $message['error'] = ''; }
				}else{
					$message['error'] = 'There was a problem installing the sample data.';
				}
			}else{
				$message['success'] = 'No Sample Data Installed.';
				$message['error'] = '';
			}
		}
		
		$return = json_encode($message);
		echo $return;
		die();
	}
}
?>