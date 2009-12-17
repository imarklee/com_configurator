<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2009 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

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
				$preset_values = getPresetParamList( $templateBaseDir . DS . 'core'.DS.'morphDetails.xml', $preset_choice );
		}

		$paramList = getTemplateParamList( $templateBaseDir . DS . 'core'.DS.'morphDetails.xml' );
		for($i=0;$i<count($paramList);$i++) $paramList[$i] .= '=';

			if ( $template ) {
				// do stuff for existing records
				// load existing settings for this template.
				$query="SELECT * FROM #__configurator AS t WHERE t.template_name='{$template}'";
				$database->setQuery( $query );
				$template_params = $database->loadAssocList('param_name');
				$template_settings = array();
				
				// themelet
				$themelet = $template_params['themelet']['param_value'];
				$themelet_xml_params = array();
				$xml_param_loader = new morphXMLLoader(JPATH_ROOT.DS.'morph_assets'.DS.'themelets'.DS.$themelet.DS.'themeletDetails.xml');
				if(!empty($xml_param_loader)) {
					$themelet_xml_params = $xml_param_loader->getParamDefaults();	
					foreach($themelet_xml_params as $param_name => $param_value){
						if(!array_key_exists($param_name,$template_params)) $template_params[$param_name] = array('param_name' => $param_name, 'param_value' => $param_value);
					}
				} 
			
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
			
			// Create the morph params
			$params = new JParameter($current_params, $templateBaseDir.DS.'core'.DS.'morphDetails.xml');        
			$params->name = $template;
			//$params->merge($themelet_params);
			
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
		// preferences variables
			$cfg_pref='';
			$pref_xml='';
			$query="SELECT * FROM #__configurator_preferences;";
			$database->setQuery( $query );
			$pref_params = $database->loadObjectList();
						
			$pref_list = getTemplateParamList( dirname(__FILE__) . '/includes/layout/preferences.xml', TRUE );
			foreach ($pref_list as $pref) {
				$pref = explode( '=', $pref );
				$defpref_params[$pref[0]] = $pref[1];
			}
			
			// Replace default settings with any settings found in the DB.
			if($pref_params !== null) {
				foreach( (array) $pref_params as $param ) {
					$defpref_params[$param->pref_name] = $param->pref_value;
				}
			}
			// Create class members dynamically to be used by template.
			foreach( $defpref_params as $key => $value ) {
				$cfg_pref->$key = $value;
			}
			
			// preferences form
			$query="SELECT * FROM #__configurator_preferences";
			$database->setQuery( $query );
			$prefs_params = $database->loadAssocList('pref_name');
			$prefs_settings = array();
			$current_prefs = '';
			
			foreach ( (array) $prefs_params as $prefs_param ) {
				$prefs_settings[] = $prefs_param['pref_name'] . '=' . $prefs_param['pref_value'] . "\n";
			}
			if( count( $prefs_settings ) ) {
				 //Got settings from the DB.
				$current_prefs = implode( "\n", $prefs_settings );
			}
			
			$pref_xml = new Jparameter($current_prefs, dirname(__FILE__).DS.'includes'.DS.'layout'.DS.'preferences.xml');
	HTML_configurator_admin::manage( $params, $lists, $morph_installed, $pref_xml, $cfg_pref );
	}
	
	function help(){
		HTML_configurator_admin::help();
	}
	
	function pt_proxy(){
		$url = urldecode($_GET['url']);
		$content = file_get_contents($url);
		if(!$content){ ?>
			<div id="proxy-warning">
				<p><strong>Warning: </strong>A required PHP function (file_get_contents) has been disallowed on your server.<br />
					To gain the full experience of our Inline Documentation, please request that this be enabled from your host.</p>
			</div>
			<iframe id="pt_iframe" name="pt_iframe" src="<?php echo $url; ?>" height="<?php echo $ih; ?>" width="<?php echo $iw; ?>" frameborder="0" scrolling="<?php echo $is; ?>"></iframe>
		<?php 
		}else{
			echo $content;
		}
	}
	
	function show_assets(){
		if(isset($_GET['a'])) $a = $_GET['a'];
		switch($a){
			case 'recycle': include('includes'.DS.'assets'.DS.'recycle.php'); break;
			case 'themelets': include('includes'.DS.'assets'.DS.'themelets.php'); break;
			case 'backgrounds': include('includes'.DS.'assets'.DS.'backgrounds.php'); break;
			case 'logos': include('includes'.DS.'assets'.DS.'logos.php'); break;
			case 'iphone': include('includes'.DS.'assets'.DS.'iphone.php'); break;
			case 'backup': include('includes'.DS.'assets'.DS.'backup.php'); break;
		}
	}

	function assets_backup(){
		$assets = JPATH_ROOT .DS.'morph_assets';
		
		if(isset($_GET['type'])){ 
			$type = $_GET['type'];
		}else{
			$type = 'gzip';
		}
		
		switch($type){
			case 'gzip':
			JArchive::create(JPATH_ROOT.DS.'morph_assets',$assets, 'gz', '', JPATH_ROOT, true);
			$filename = 'morph_assets.gz';
			header('Content-Type: application/x-gzip');
			break;
			case 'zip':
			$zip_array = array();
			$zip = JArchive::getAdapter('zip');
			$files = JFolder::files($assets, '', true, true, array('.DS_Store', 'Thumbs.db', '.git'));
			foreach($files as $file){
				$data = JFile::read($file);
				$zip_array[] = array('name' => $file, 'data' => $data);
			}
			$zip->create(JPATH_ROOT.DS.'morph_assets',$zip_array);
			$filename = 'morph_assets.zip';
			header('Content-Type: application/zip');
			break;
		}
		
		
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private',false);
		header('Content-Disposition: attachment; filename="'.basename(JPATH_ROOT .DS.$filename).'"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.filesize(JPATH_ROOT .DS.$filename)); 
		readfile(JPATH_ROOT .DS.$filename);
		JFile::delete(JPATH_ROOT .DS.$filename);
		exit();
	}
	
	function handle_backup(){
		$action = $_REQUEST['action'];
		$filename = $_REQUEST['filename'];
		$type = $_REQUEST['type'];
		$fp = '';
		switch($type){
			case 'db':
			$fp = DS.'db';
			break;
			case 'file':
			$fp = '';
			break;
		}
		$db_folder = JPATH_ROOT .DS.'morph_assets'.DS.'backups'.$fp;
		$recyclebin = JPATH_ROOT .DS.'morph_recycle_bin';
		
		if(file_exists($db_folder.DS.$filename)){
			switch($action){
				case 'delete':
					JFile::move($db_folder.DS.$filename, $recyclebin . DS . $filename);
					echo '<strong>'.$filename.'</strong> deleted successfully</div>';
				break;
				case 'download':
				header('Content-Type: application/x-gzip');
				header('Pragma: public');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Cache-Control: private',false);
				header('Content-Disposition: attachment; filename="'.basename($db_folder.DS.$filename).'"');
				header('Content-Transfer-Encoding: binary');
				header('Content-Length: '.filesize($db_folder.DS.$filename)); 
				readfile($db_folder.DS.$filename);
				exit();
				break;
				case 'restore':
					echo $this->restore_db_backup();
				break;
			}
		}else{
			echo 'File doesn\'t exist';
		}
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
	
	function saveprefs(){
		global $mainframe;
		$db = JFactory::getDBO();
		
		$prefs = JRequest::getVar('cfg', null, 'post', 'array');
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_configurator'.DS.'tables');
		
		foreach($prefs as $pref_key => $pref_value){
			$setting = JTable::getInstance('ConfiguratorPreferences','Table');
			$setting->pref_name = $pref_key;			
			$setting->loadByKey();
			$setting->pref_value = $pref_value;
			
			if (!$setting->store()) {
				return $setting->getError();
				die();
			}

			unset($setting);
			$setting = null;
		}
		return true;
	}
	
	function applytemplate() {
		global $mainframe;
		$database = JFactory::getDBO();
		$template_name = JRequest::getVar('t');
		$option = JRequest::getVar('option');

		//$params[0] = JRequest::getVar( 'params', null, 'post', 'array' );
		$params[1] = JRequest::getVar( 'general', null, 'post', 'array' );
		$params[2] = JRequest::getVar( 'logo', null, 'post', 'array' );
		$params[3] = JRequest::getVar( 'tagline', null, 'post', 'array' );
		$params[4] = JRequest::getVar( 'htmlbackgrounds', null, 'post', 'array' );
		$params[5] = JRequest::getVar( 'bodybackgrounds', null, 'post', 'array' );
		$params[6] = JRequest::getVar( 'color', null, 'post', 'array' );
		$params[7] = JRequest::getVar( 'progressive', null, 'post', 'array' );
		$params[8] = JRequest::getVar( 'menu', null, 'post', 'array' );
		$params[9] = JRequest::getVar( 'iphone', null, 'post', 'array' );
		$params[10] = JRequest::getVar( 'performance', null, 'post', 'array' );
		$params[11] = JRequest::getVar( 'debugging', null, 'post', 'array' );
		$params[12] = JRequest::getVar( 'toolbar', null, 'post', 'array' );
		$params[13] = JRequest::getVar( 'masthead', null, 'post', 'array' );
		$params[14] = JRequest::getVar( 'subhead', null, 'post', 'array' );
		$params[15] = JRequest::getVar( 'topnav', null, 'post', 'array' );
		$params[16] = JRequest::getVar( 'topshelf', null, 'post', 'array' );
		$params[17] = JRequest::getVar( 'bottomshelf', null, 'post', 'array' );
		$params[18] = JRequest::getVar( 'user1', null, 'post', 'array' );
		$params[19] = JRequest::getVar( 'user2', null, 'post', 'array' );
		$params[20] = JRequest::getVar( 'inset1', null, 'post', 'array' );
		$params[21] = JRequest::getVar( 'inset2', null, 'post', 'array' );
		$params[22] = JRequest::getVar( 'inset3', null, 'post', 'array' );
		$params[23] = JRequest::getVar( 'inset4', null, 'post', 'array' );
		$params[24] = JRequest::getVar( 'main', null, 'post', 'array' );
		$params[25] = JRequest::getVar( 'innersidebar', null, 'post', 'array' );
		$params[26] = JRequest::getVar( 'inner1', null, 'post', 'array' );
		$params[27] = JRequest::getVar( 'inner2', null, 'post', 'array' );
		$params[28] = JRequest::getVar( 'inner3', null, 'post', 'array' );
		$params[29] = JRequest::getVar( 'inner4', null, 'post', 'array' );
		$params[30] = JRequest::getVar( 'inner5', null, 'post', 'array' );	
		$params[31] = JRequest::getVar( 'outersidebar', null, 'post', 'array' );
		$params[32] = JRequest::getVar( 'outer1', null, 'post', 'array' );
		$params[33] = JRequest::getVar( 'outer2', null, 'post', 'array' );
		$params[34] = JRequest::getVar( 'outer3', null, 'post', 'array' );
		$params[35] = JRequest::getVar( 'outer4', null, 'post', 'array' );
		$params[36] = JRequest::getVar( 'outer5', null, 'post', 'array' );
		$params[37] = JRequest::getVar( 'footer', null, 'post', 'array' );
		$params[38] = JRequest::getVar( 'components_inner', null, 'post', 'array' );
		$params[39] = JRequest::getVar( 'components_outer', null, 'post', 'array' );
		$params[40] = JRequest::getVar( 'captify', null, 'post', 'array' );
		$params[41] = JRequest::getVar( 'lazyload', null, 'post', 'array' );
		$params[42] = JRequest::getVar( 'lightbox', null, 'post', 'array' );
		
		$preset_name = JRequest::getVar('preset_coice', '');
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_configurator'.DS.'tables');
				
		foreach ($params as $currentblock){	
			foreach($currentblock as $param_key => $param_value){
		
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
		
		if(isset($_COOKIE['change_themelet'])){
			$this->themelet_activate($_COOKIE['ct_themelet_name']);
			setcookie('change_themelet', '', time()-3600);
			setcookie('ct_themelet_name', '', time()-3600);
		}
		
		if(!JRequest::getVar('isajax', null, 'post')){
			$msg = JText::_('Successfully saved your settings');
			// delete change cookie if exists
			if(isset($_COOKIE['formChanges'])){ setcookie('formChanges', 'false', time()-3600); }
			$mainframe->redirect("index.php?option={$option}&task=manage",$msg);
		}else{
			// delete change cookie if exists
			if(isset($_COOKIE['formChanges'])){ setcookie('formChanges', 'false', time()-3600); }
			return true;
		}
		
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
	
	function loaduser(){
		$db = JFactory::getDBO();
		$query = "insert into #__configurator_usertable values ('','".$_REQUEST['login']['user_name']."','".$_REQUEST['login']['member_id']."','".$_REQUEST['login']['member_name']."','".$_REQUEST['login']['member_surname']."','".$_REQUEST['login']['member_email']."');";
		$db->setQuery($query);
		$db->query() or die('{ error: "'.$db->getErrorMsg().'" }');
		echo '{ success: "login successfull" }';
		exit();
	}
	
	function checkuser(){
		$db = JFactory::getDBO();
		$db->setQuery('select count(*) from #__configurator_usertable');
		$nums = $db->loadResult();
		if($nums < 1) return false;
		return true;
	}
	
	function getuserdetails(){
		$db = JFactory::getDBO();
		$db->setQuery("select * from #__configurator_usertable;");
		$res = $db->loadAssocList();
		return $res;
	}
	
	function luser(){
		$db = JFactory::getDBO();
		$db->setQuery('truncate table #__configurator_usertable');
		$db->query();
		echo 'success: "true"';
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
						case 'template':
						$return = $this->template_upload();
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
						case 'iphone':
						$return = $this->iphone_upload();
						break;
						case 'sample':
						$return = $this->demo_upload();
						break;
						case 'themelet_assets':
						$return = $this->assets_upload();
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
		die();
	}
	
	function assets_upload(){
		$assetsdir 	= JPATH_SITE . DS . 'morph_assets';
		$logos 		= $assetsdir . DS . 'logos';
		$bg			= $assetsdir . DS . 'backgrounds';
		$iphone		= $assetsdir . DS . 'iphone';
		$tempassets = $assetsdir . DS . 'temp_assets';
		$message 	= array();
		
		$file 		= JRequest::getVar( 'insfile', '', 'files', 'array' );
		
		if(!is_dir($tempassets)){JFolder::create($tempassets);}
		JPath::setPermissions($tempassets);
		
		if(!move_uploaded_file($file['tmp_name'], $tempassets . DS . strtolower(basename($file['name']))) ){
			$error = 'error: "Could not move file to required location!"';
			return $error;
		}
		 		
		$result = JArchive::extract( $tempassets . DS . strtolower(basename($file['name'])), $tempassets);
		
		if ($h = opendir($tempassets)) {
		    while (false !== ($f = readdir($h))) {
		        if ($f !== "." && $f !== ".." && $f !== '.DS_Store' && $f !== '__MACOSX') {
		            if(is_dir($tempassets . DS . $f)){
						if ($h2 = opendir($tempassets . DS . $f)){
							 while (false !== ($f2 = readdir($h2))) {
								if ($f2 !== "." && $f2 !== ".." && $f2 !== '.DS_Store') {
									if(!file_exists($assetsdir . DS . $f . DS . $f2)){
										JFile::move($tempassets . DS . $f . DS . $f2, $assetsdir . DS . $f . DS . $f2);
									}
								}
							}
							closedir($h2);
						}
					}
		        }
		    }
		    closedir($h);
		}
		
		$this->cleanupThemeletInstall(strtolower(basename($file['name'])), $tempassets);
		return 'success: "Assets uploaded successfully.", error: ""';
	}
	
	function demo_upload(){
	
		$backupdir 	= JPATH_SITE . DS . 'morph_assets' . DS . 'backups' . DS . 'db';
		$tempdir 	= JPATH_SITE . DS . 'morph_assets' . DS . 'backups' . DS . 'db' . DS . 'temp';
		$message 	= array();
		$file 		= JRequest::getVar( 'insfile', '', 'files', 'array' );

		if(!is_dir($tempdir)){JFolder::create($tempdir);}
		JPath::setPermissions($tempdir);
		
		$conf = JFactory::getConfig();
		$database = $conf->getValue('config.db');
		
		$this->create_db_backup('full-database');
		
		if( !move_uploaded_file($file['tmp_name'], $tempdir . DS . strtolower(basename($file['name']))) ){
			$error = 'error: "Could not move file to required location!"';
			return $error;
		}
		
		$result = JArchive::extract( $tempdir . DS . strtolower(basename($file['name'])), $tempdir);
		$this->parse_mysql_dump($tempdir . DS . str_replace('.zip', '', strtolower(basename($file['name']))) );
		
		$this->cleanupThemeletInstall(strtolower(basename($file['name'])), $tempdir);
		
		$message = 'error: "", success: "Sample content successfully installed."';
		return $message;

	}
	
	function restore_db_backup(){
	
		$filename = $_REQUEST['filename'];
		$backupdir 	= JPATH_SITE . DS . 'morph_assets' . DS . 'backups' . DS . 'db';
		$tempdir 	= JPATH_SITE . DS . 'morph_assets' . DS . 'backups' . DS . 'db' . DS . 'temp';

		if(!is_dir($tempdir)){JFolder::create($tempdir);}
		JPath::setPermissions($tempdir);
		
		$result = JArchive::extract( $backupdir . DS . strtolower($filename), $tempdir);
		$this->parse_mysql_dump($tempdir . DS . str_replace('.gz', '', strtolower($filename)) );
		
		$this->cleanupThemeletInstall(strtolower($filename), $tempdir);
		
		$message = '<strong>'.$filename.'</strong> restored successfully.';
		echo $message;
		return;
	}
	
	function iphone_upload(){
		$msg = '';
		$error = '';
		$file = JRequest::getVar( 'insfile', null, 'files', 'array' );
		$file_type = $file['type'];

		// if there is no file error then continue
		if($file['error'] !== 4) {
			
			$iphone_dir = JPATH_ROOT . DS .'morph_assets'. DS . 'iphone';
			// errors
			if( $file['error'] ){
				$error = 'error: "Upload error ('.$file['error'].')"';
				return $error;
			}
			if( !is_uploaded_file($file['tmp_name']) ){ 
				$error = 'error: "Not an uploaded file! Hack attempt?"';
				return $error;
			}
			if( file_exists($iphone_dir . DS . strtolower(basename($file['name']))) ) {
				$error = 'error: "A file with that name already exists!"';
				return $error;
			}
			if( !is_dir($iphone_dir) ) {
				// Directory doesnt exist, try to create it.
				if( !mkdir($iphone_dir) ){
					$error = 'error: "Could not save file, directory does not exist!"';
					return $error;
				}else{
					JPath::setPermissions($iphone_dir);
				}
			}else{ 
				JPath::setPermissions($iphone_dir); 
			}
			if( !is_writable($iphone_dir) ){
				$error = 'error: "Could not save file, permission error!"';
				return $error;
			}
			if( !move_uploaded_file($file['tmp_name'], $iphone_dir . DS . strtolower(basename($file['name']))) ){
				$error = 'error: "Could not move file to required location!"';
				return $error;
			}
		
			JPath::setPermissions($iphone_dir . DS . strtolower(basename($file['name'])));
			$msg = 'error: "", success:"File successfully uploaded."';
			return $msg;
		}
		$error = 'error: "There was an error uploading the file. Please try again."';
		return $error;
	}
	
	function template_upload(){
		$newtemplatefile = JRequest::getVar( 'insfile', null, 'files', 'array' );
		$templatesdir = JPATH_SITE . DS . 'templates';
		$backupdir = JPATH_SITE . DS . 'morph_assets' . DS . 'backups';
		$backupfile = $backupdir . DS . 'file_template_morph_' . time();
		if(!@Jarchive::create($backupfile, $templatesdir . DS . 'morph', 'gz', '', $templatesdir, true)){
			// error creating archive
			$error = 'error: "There was an error creating a backup archive. Upload failed"'; 
			return $error;
		}else{
			// remove existing
			@JPath::setPermissions($templatesdir . DS . 'morph');
			if(!$this->deleteDirectory($templatesdir . DS . 'morph')){
				// fail: error removing existing folder
				$error = 'error: "There was an error removing the old install. Upload failed"';	
				return $error;
			}else{
				if( !move_uploaded_file($newtemplatefile['tmp_name'], $templatesdir . DS . strtolower(basename($newtemplatefile['name']))) ){
					$error = 'error: "Could not move file to required location!"';
					return $error;
				}
				// directory doesn't exist - install as per usual
				@JPath::setPermissions($templatesdir . DS . strtolower(basename($newtemplatefile['name'])));
				$msg = $this->unpackTemplate($templatesdir . DS . strtolower(basename($newtemplatefile['name'])));
				$msg .= ', backuploc: "'.$backupfile.'.gz"';
				return $msg;
			}
		}
	}
	
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
			
			$themelet_name = str_replace('themelet_', '', strtolower(basename($themelet_details['name'])));
			$themelet_name = str_replace(strstr($themelet_name, '_'), '', $themelet_name);
			if(is_dir($themelet_dir . DS . $themelet_name)){
				$backupdir = JPATH_SITE . DS . 'morph_assets' . DS . 'backups';
				$backupfile = $backupdir . DS . 'file_themelet_'.$themelet_name . '_' . time();
				if(!@Jarchive::create($backupfile, $themelet_dir . DS . $themelet_name, 'gz', '', $themelet_dir, true)){
					$error = 'error: "Could not backup themelet!"';
					return $error;
				}
				JFolder::delete($themelet_dir . DS . $themelet_name);
			}else{
				$backupfile = '';
			}
		
			JPath::setPermissions($themelet_dir . DS . strtolower(basename($themelet_details['name'])));
			$msg = $this->unpackThemelet($themelet_dir . DS . strtolower(basename($themelet_details['name'])), $backupfile);
			
			$db = JFactory::getDBO();
			// db queries to add custom CSS/PHP/JS to the database table for the themelet.
			// custom PHP
			$db->setQuery("SELECT COUNT(*) from `#__configurator_customfiles` WHERE `filename` = 'custom.php' AND `parent_name` = '".$themelet_name."';");
			if($db->loadResult() == 0) {
				$db->setQuery("INSERT INTO `#__configurator_customfiles` VALUES ( NULL, 'themelet', '".$themelet_name."', 'custom.php', '', FROM_UNIXTIME(".time().") );");
				$db->query();
			}
			// custom CSS
			$db->setQuery("SELECT COUNT(*) from `#__configurator_customfiles` WHERE `filename` = 'custom.css.php' AND `parent_name` = '".$themelet_name."';");
			if($db->loadResult() == 0) {
				$db->setQuery("INSERT INTO `#__configurator_customfiles` VALUES ( NULL, 'themelet', '".$themelet_name."', 'custom.css.php', '', FROM_UNIXTIME(".time().") );");
				$db->query();
			}
			// custom JS
			$db->setQuery("SELECT COUNT(*) from `#__configurator_customfiles` WHERE `filename` = 'custom.js.php' AND `parent_name` = '".$themelet_name."';");
			if($db->loadResult() == 0) {
				$db->setQuery("INSERT INTO `#__configurator_customfiles` VALUES ( NULL, 'themelet', '".$themelet_name."', 'custom.js.php', '', FROM_UNIXTIME(".time().") );");
				$db->query();
			}
			
			// custom footer code
			$db->setQuery("SELECT COUNT(*) from `#__configurator_customfiles` WHERE `filename` = 'script.php' AND `parent_name` = '".$themelet_name."';");
			if($db->loadResult() == 0) {
				$db->setQuery("INSERT INTO `#__configurator_customfiles` VALUES ( NULL, 'themelet', '".$themelet_name."', 'script.php', '', FROM_UNIXTIME(".time().") );");
				$db->query();
			}
			
			return $msg;
		}
		$error = 'error: "There was an error uploading the file. Please try again."';
		return $error;
	}
	
	function get_current_themelet(){
		$db = JFactory::getDBO();
		$query = "select param_value from #__configurator where param_name = 'themelet';";
		$db->setQuery($query);
		$c_themelet = $db->loadResult();
		
		echo $c_themelet;
		return true;
	}
	
	function themelet_check_existing($themelet = ''){
		if($themelet == ''){
			if(isset($_REQUEST['themelet_name'])){
				$themelet = $_REQUEST['themelet_name'];
			}else{
				return false;
			}
		}
		$backupdir = JPATH_SITE . DS . 'morph_assets' . DS . 'backups' . DS . 'db';
		$files = JFolder::files($backupdir);
		foreach($files as $f){
			if(preg_match('/'.$themelet.'/i', $f)){
				if(file_exists($backupdir.DS.$f)){
					echo '{ exists: "true" }';
					return true;
				}
			}else{
				$exists = false;
			}
		}
		if(!$exists){
			echo '{ exists: "false" }';
		}
		
	}
	
	function themelet_activate_existing($themelet=''){
		$db = JFactory::getDBO();
		$query = $db->setQuery("DELETE FROM `#__configurator` where source='themelet';");
		$db->query($query);
		
		if($themelet == ''){
			if(isset($_REQUEST['themelet_name'])){
				$themelet = $_REQUEST['themelet_name'];
			}else{
				return false;
			}
		}

		$backupdir = JPATH_SITE . DS . 'morph_assets' . DS . 'backups' . DS . 'db';		
		$files = JFolder::files($backupdir);
		foreach($files as $f){
			if(preg_match('/'.$themelet.'/i', $f)){
				JArchive::extract($backupdir.DS.$f, $backupdir);
				if(file_exists($backupdir.DS.str_replace('.gz', '', $f))){
					$this->parse_mysql_dump($backupdir.DS.str_replace('.gz', '', $f));
					JFile::delete($backupdir.DS.str_replace('.gz', '', $f));
					return true;
				}
			}
		}
	}
	
	function export_db(){
		$data = $_POST['export_data'];
		foreach($data as $d){
			if(!preg_match('/ /i', $d)){
				$this->create_db_backup($d);
			}else{
				$t = explode(' ', $d);
				$this->create_db_backup($t[0], $t[1]);
			}
		}
		echo '<strong>Database Export Successfull</strong><br />Your files have been exported into the Morph Assets folder and can be managed in the Database Backups tool in Configurator.';
		return;
	}
	
	function import_db(){
		$backupdir 	= JPATH_SITE . DS . 'morph_assets' . DS . 'backups' . DS . 'db';
		$tempdir 	= JPATH_SITE . DS . 'morph_assets' . DS . 'backups' . DS . 'db' . DS . 'temp';
		$file 		= JRequest::getVar( 'import_file', '', 'files', 'array' );
		
		if(!is_dir($tempdir)){JFolder::create($tempdir);}
		JPath::setPermissions($tempdir);
		
		if( !move_uploaded_file($file['tmp_name'], $tempdir . DS . strtolower(basename($file['name']))) ){
			$error = 'error: "Could not move file to required location!"';
			return $error;
		}
		
		$result = JArchive::extract( $tempdir . DS . strtolower(basename($file['name'])), $tempdir);
		$this->parse_mysql_dump($tempdir . DS . str_replace('.gz', '', strtolower(basename($file['name']))) );
		
		$this->cleanupThemeletInstall(strtolower(basename($file['name'])), $tempdir);
		
		echo '{success: "SQL file imported successfully."}';
		return true;
	}
		
	function create_db_backup($type='', $name='', $download=''){
	
		$db = JFactory::getDBO();
		$pref = $db->getPrefix();
		$n = '';
		
		if(isset($_REQUEST['url'])){
			if(isset($_REQUEST['type'])) $type = $_REQUEST['type'];
			if(isset($_REQUEST['name'])) $name = $_REQUEST['name'];
			if(isset($_REQUEST['download'])) $download = $_REQUEST['download'];
		}
		
		$backupdir = JPATH_SITE . DS . 'morph_assets' . DS . 'backups' . DS . 'db';
		if(!is_dir($backupdir)) mkdir($backupdir);
		JPath::setPermissions($backupdir);
		if($name !== '') $n = $name.'_';
		$backupfile = 'db_'.$type.'_'.$n.time().'.sql.gz';
		
		switch($type){
			case 'themelet-settings':
				$files = JFolder::files($backupdir);
				foreach($files as $f){
					if(preg_match('/'.$name.'/i', $f)){
						$backup = $backupdir.DS.$f;
						if(file_exists($backup)) JFile::delete($backup);
					}	
				}
				$this->create_sql_file($backupdir.DS.$backupfile, $this->get_structure($pref . 'configurator', "source='themelet'", false, true));
			break;
			case 'full-database':
				if(isset($download) && $download == 'true'){
					header('Content-disposition: attachment; filename='.$backupfile);
					header('Content-type: application/x-gzip');
					echo gzencode($this->get_structure('','',true, false), 9);
				}else{
					$this->create_sql_file($backupdir.DS.$backupfile, $this->get_structure('','',true, false));
				}
			break;
			case 'configurator-settings':
				$this->create_sql_file($backupdir.DS.$backupfile, $this->get_structure($pref . 'configurator', '', true, false));	
			break;
			case 'configurator-preferences':
				$this->create_sql_file($backupdir.DS.$backupfile, $this->get_structure($pref . 'configurator_preferences', '', true, false));
			break;
		}
		
		return $backupdir.DS.$backupfile;
	}
	
	function themelet_activate($themelet = ''){
		global $mainframe;
		$db = JFactory::getDBO();
		
		if($themelet == ''){
			if(isset($_REQUEST['themelet_name'])){
				$themelet = $_REQUEST['themelet_name'];
			}else{
				return false;
			}
		}
		
		$template_dir = JPATH_ROOT . DS .'templates'. DS . 'morph';
		$themelet_dir = JPATH_ROOT . DS .'morph_assets'. DS . 'themelets';
		
		$query="SELECT * FROM `#__configurator` WHERE template_name='morph'";
		$db->setQuery($query);
		$template_params = $db->loadAssocList('param_name');
				
		// themelet
		$curr_themelet = '';
		if(isset($template_params['themelet'])) { $curr_themelet = $template_params['themelet']['param_value']; }
		if(isset($_COOKIE['current_themelet'])) { $curr_themelet = $_COOKIE['current_themelet']; }
		
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_configurator'.DS.'tables');			
			
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

			$template_xml = $template_dir . DS . 'core' . DS . 'morphDetails.xml';
			
			$xml_param_loader = new morphXMLLoader($template_xml);
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
			foreach($defaults as $param_name => $param_value){
				$setting = JTable::getInstance('ConfiguratorTemplateSettings','Table');
				$setting->template_name = 'morph';
				$setting->published = '1';
				$setting->source = 'template';
				$setting->param_name = $param_name;
				$setting->loadByKey();
				$setting->param_value = $param_value;
				
				if (!$setting->store(TRUE)) {
					echo $setting->getError();
					die();
				}
	
				unset($setting);
				$setting = null;
			}
		
		}
		
		$themelet = $themelet_dir . DS . $themelet;
		if(is_file($themelet.DS.'themeletDetails.xml')){
			$xml_param_loader = new morphXMLLoader($themelet.DS.'themeletDetails.xml');
			$themelet_xml_params = $xml_param_loader->getParamDefaults();
			
			foreach($themelet_xml_params as $param_name => $param_value){
				$setting = JTable::getInstance('ConfiguratorTemplateSettings','Table');
				$setting->template_name = 'morph';
				$setting->published = '1';
				$setting->param_name = $param_name;
				$setting->loadByKey();
				$setting->param_value = $param_value;
				$setting->source = 'themelet';
				
				if (!$setting->store(TRUE)) {
					echo $setting->getError();
					die();
				}
	
				unset($setting);
				$setting = null;
			}
		}
	}
	
	function show_error($err, $type, $cookie){
		if(isset($_COOKIE['notice']) && $_COOKIE['notice'] !== $cookie || !isset($_COOKIE['notice'])) {
			return '<div class="cfg-message"><p class="'.$type.'">'.$err.'<a href="#" class="close-msg">close</a></p></div>';
		}
	}
	
	function reset_database(){
		$db = JFactory::getDBO();
		$template_dir = JPATH_ROOT . DS .'templates'. DS . 'morph';
		$themelet_dir = JPATH_ROOT . DS .'morph_assets'. DS . 'themelets';
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_configurator'.DS.'tables');
		
		if(!isset($_GET['reset_type']) or $_GET['reset_type'] == '') {
			echo 'error: "No reset type detected. Reset failed.", success: ""';
			return false;
		}
		
		switch($_GET['reset_type']){
			case 'prefs':
				$this->create_db_backup('configurator-preferences');
				$query = 'truncate table #__configurator_preferences';
				$db->setQuery($query);
				$db->query();
				echo '{ type: "prefs", success: "Configurator preferences reset successfully", error: "" }';
				return true;
			break;
			case 'cfg':
				$this->create_db_backup('configurator-settings');
				// get themelet name
				$query = "select param_value from #__configurator where param_name = 'themelet';";
				$db->setQuery($query);
				$c_themelet = $db->loadResult();
				
				// truncate table
				$query = 'truncate table #__configurator';
				$db->setQuery($query);
				$db->query();
				
				// add morphDetails.xml defaults
				$template_xml = $template_dir . DS . 'core' . DS . 'morphDetails.xml';
				$xml_param_loader = new morphXMLLoader($template_xml);
				$template_xml_params = $xml_param_loader->getParamDefaults();

				// remove the elements grouping from being added to the database
				$removeParams = array('Color Picker Param','Filelist Param','Folderlist Param','Heading Param','Imagelist Param','List Param','Radio Param','Spacer Param','Text Param','Textarea Param','Themelet Param');
				foreach($template_xml_params as $key => $val){
					if(in_array($key, $removeParams)) unset($template_xml_params[$key]);
				}
				
				// add morphDetails.xml defaults to the CFG table
				foreach($template_xml_params as $param_name => $param_value){
					$setting = JTable::getInstance('ConfiguratorTemplateSettings','Table');
					$setting->template_name = 'morph';
					$setting->published = '1';
					$setting->source = 'templatexml';
					$setting->param_name = $param_name;
					$setting->loadByKey();
					$setting->param_value = $param_value;

					if (!$setting->store(TRUE)) {
						echo '{ error: "' . $setting->getError() . '", success: "" }';
						die();
					}

					unset($setting);
					$setting = null;
				}
				
				// add themeletDetails.xml to the database
				$themelet = $themelet_dir . DS . $c_themelet;
				if(is_file($themelet.DS.'themeletDetails.xml')){
					$xml_param_loader = new morphXMLLoader($themelet.DS.'themeletDetails.xml');
					$themelet_xml_params = $xml_param_loader->getParamDefaults();

					foreach($themelet_xml_params as $param_name => $param_value){
						$setting = JTable::getInstance('ConfiguratorTemplateSettings','Table');
						$setting->template_name = 'morph';
						$setting->published = '1';
						$setting->param_name = $param_name;
						$setting->loadByKey();
						$setting->param_value = $param_value;
						$setting->source = 'themelet';

						if (!$setting->store(TRUE)) {
							echo '{ error: "' . $setting->getError() . '", success: "" }';
							die();
						}

						unset($setting);
						$setting = null;
					}
				}
				
				// re-insert themelet
				$query = "update #__configurator set param_value = '".$c_themelet."', source = 'reset' where param_name = 'themelet';";
				$db->setQuery($query);
				$db->query();
				
				echo '{ type: "cfg", success: "Configurator settings reset successfully", error: ""}';
				return true;
			break;
		}
		return;
	}
	
	function unpackThemelet($p_filename='', $b){

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
			$success = 'success: "Themelet Successfully Installed", themelet: "'.$_themeletdir.'", backuploc: "'.$b.'", error: "", msg: "Themelet Successfully Installed", themelet: "'.$_themeletdir.'"';
			return $success;
		}
		
	}
	
	function cleanupThemeletInstall($package='', $resultdir=''){
		$config = JFactory::getConfig();
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
		$allowed_types = array('image/pjpeg','image/jpeg','image/png', 'image/jpg', 'image/gif');
	
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
		$allowed_types = array('image/png', 'image/gif', 'image/ico', 'image/x-icon', 'application/octet-stream');
	
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
	function handle_recycle(){
		$action = $_GET['action'];
		if(isset($_GET['file'])) $file = $_GET['file'];
		if(isset($_GET['type'])) $type = $_GET['type'];
		$rb_root = JPATH_SITE.DS.'morph_recycle_bin';
		
		if($action){
			switch($action){
				case 'delete':
					if($type !== 'themelet'){
						JFile::delete($rb_root.DS.$file);
						return true;
					}else{				
						JFolder::delete($rb_root.DS.$file);
						return true;
					}
				break;
				case 'restore':
					$recycle_dir = $rb_root = JPATH_SITE.DS.'morph_recycle_bin';
					$restore_dir = $rb_root = JPATH_SITE.DS.'morph_assets';
					
					function move_asset($f, $t, $r, $rc){
						if(is_dir($rc.DS.$f)){
							if(JFolder::move($rc.DS.$f, $r.DS.$f)){
								JFolder::delete($rc.DS.$f);
								return true;
							}
						}else{
							echo $f;
							if($t == 'file' || $t == 'db'){
								$mf = $r.DS.$f;
							}else{
								$mf = $r.DS.str_replace($t.'_', '', $f);
							}
							if(JFile::move($rc.DS.$f, $mf)){
								JFile::delete($rc.DS.$f);
								return true;
							}
						}
					}
					
					switch($type){
						case 'bg': 
						$restore_dir .= DS.'backgrounds'; 
						move_asset($file, $type, $restore_dir, $recycle_dir);
						break;
						case 'iphone': 
						$restore_dir .= DS.'iphone'; 
						move_asset($file, $type, $restore_dir, $recycle_dir); 
						break;
						case 'logo': 
						$restore_dir .= DS.'logos'; 
						move_asset($file, $type, $restore_dir, $recycle_dir);
						break;
						case 'themelet': 
						$restore_dir .= DS.'themelets'; 
						move_asset($file, $type, $restore_dir, $recycle_dir);
						break;
						case 'file': 
						$restore_dir .= DS.'backups'; 
						move_asset($file, $type, $restore_dir, $recycle_dir);
						break;
						case 'db': 
						$restore_dir .= DS.'backups'.DS.'db'; 
						move_asset($file, $type, $restore_dir, $recycle_dir);
						break;
					}
					return true;
				break;
				case 'empty':
					$files = JFolder::files($rb_root, '', true, true, array('.git', '.idx', '.DS_Store'));
					$folders = JFolder::folders($rb_root, '', true, true, array('.git'));
					
					if(!empty($files)){				
						foreach($files as $file){
							JPath::setPermissions($file, '0777');
							JFile::delete($file);
						}
					}
					if(!empty($folders)){
						foreach($folders as $folder){
							JPath::setPermissions($folder, '', '0777' );
							JFolder::delete($folder);
						}
					}
					return true;
				break;
			}
		}
	}
	function deleteAsset(){
		$type = $_GET['deltype'];
		$asset = $_GET['asset'];
		$assetsdir = JPATH_SITE . DS . 'morph_assets';
		$recyclebin = JPATH_SITE . DS . 'morph_recycle_bin';
		
		switch($type){
		
			case 'themelet':
			$assetsdir .= DS.'themelets';
			$assetsfile = $assetsdir . DS . $asset;
			if (is_dir($assetsdir)) {
				if(JFolder::copy($assetsfile, $recyclebin . DS . $asset)){
					foreach(JFolder::files($assetsfile, '', true, true, array('.git', '.idx', '.DS_Store')) as $file){
						JPath::setPermissions($file, '0777');
						JFile::delete($file);
					}
					foreach(JFolder::folders($assetsfile, '', true, true) as $folder){
						JPath::setPermissions($folder, '', '0777' );
						JFolder::delete($folder);
					}
					JFolder::delete($assetsfile);
					return true;
				} else {
					echo 'fail';
					return false;
				}
			} else {
				return false;
			}
			break;
			case 'logo':
			$assetsdir .= DS.'logos';
			$assetsfile = $assetsdir . DS . $asset;			
			if (is_dir($assetsdir)) {
				if(JFile::move($assetsfile,$recyclebin . DS . 'logo_'.$asset)){
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
			break;
			case 'iphone':
			$assetsdir .= DS.'iphone';
			$assetsfile = $assetsdir . DS . $asset;			
			if (is_dir($assetsdir)) {
				if(JFile::move($assetsfile,$recyclebin . DS . 'iphone_'.$asset)){
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
			break;
			case 'background':
			$assetsdir .= DS.'backgrounds';
			$assetsfile = $assetsdir . DS . $asset;
			echo $assetsdir;		
			if (is_dir($assetsdir)) {
				if(JFile::move($assetsfile,$recyclebin . DS . 'bg_'.$asset)){
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
		
		$mem_limit = ini_get('memory_limit');
		if(str_replace('M', '', $mem_limit) < 64){ ini_set('memory_limit', '64M'); }
		
		$newthemeletfile = JRequest::getVar( 'insfile', null, 'files', 'array' );
		$activation = $_REQUEST['act_themelet'];
		$return = $this->themelet_upload($newthemeletfile);
		setcookie('installed_themelet', 'true');
		$themelet = explode(',', $return);
		$themelet = str_replace(array('"', ':', 'themelet', ' '), '', $themelet[1]);
		$themelet_name = str_replace('-',  ' ', $themelet);
		setcookie('ins_themelet_name', $themelet_name);
		$db = JFactory::getDBO();
		
		if(isset($activation) && $activation == 'true'){
		
			if(isset($_COOKIE['upgrade-type']) && $_COOKIE['upgrade-type'] === 'fresh-install' || !isset($_COOKIE['upgrade-type']))	{ $this->themelet_activate($themelet); }
			setcookie('installed_actthemelet', 'true');
			$query = $db->setQuery("select * from #__configurator where param_name = 'themelet'");
			$query = $db->query($query);
			$themelet_num = $db->getNumRows($query);
			if($themelet_num == '0'){
				$new_query = "INSERT INTO #__configurator VALUES ('' , 'morph', 'themelet', '".mysql_real_escape_string($themelet)."', '1', 'themelet');";
			}else{
				$new_query = "UPDATE #__configurator SET param_value = '".mysql_real_escape_string($themelet)."' where param_name = 'themelet';";
			}
			$query = $db->setQuery( $new_query );
			$db->query($query) or die($db->getErrorMsg());
		}
		
		// temporary step to remove GZIP from CFG if the browser doesnt allow it.
		if(isset($_COOKIE['installed_no_gzip'])){
			$gzip_query = "UPDATE #__configurator SET param_value = '0' where param_name = 'gzip_compression';";
			$query = $db->setQuery($gzip_query);
			$db->query($query);
		}
		
		$ret = '{'.$return.'}';
		echo $ret;
	}
	
	function assets_create(){
	
		JPath::setPermissions(JPATH_SITE);
	
		$backupdir = JPATH_SITE . DS . 'morph_assets' . DS . 'backups';
		$dbdir = JPATH_SITE . DS . 'morph_assets' . DS . 'backups' . DS . 'db';
		$logosdir = JPATH_SITE . DS . 'morph_assets' . DS . 'logos';
		$backgroundsdir = JPATH_SITE . DS . 'morph_assets' . DS . 'backgrounds';
		$themeletsdir = JPATH_SITE . DS . 'morph_assets' . DS . 'themelets';
		$iphonedir = JPATH_SITE . DS . 'morph_assets' . DS . 'iphone';
		
		// create assets folders
		if(!is_dir(JPATH_SITE . DS . 'morph_assets')) : 
		(!@mkdir(JPATH_SITE . DS . 'morph_assets')) ? $error = 'error: "There was an error creating the assets folder. Please check your permissions."' : JPath::setPermissions(JPATH_SITE . DS . 'morph_assets'); 
		endif;
		
		if(!is_dir(JPATH_SITE . DS . 'morph_recycle_bin')) : 
		(!@mkdir(JPATH_SITE . DS . 'morph_recycle_bin')) ? $error = 'error: "There was an error creating the Morph Recycle Bin folder. Please check your permissions."' : JPath::setPermissions(JPATH_SITE . DS . 'morph_recycle_bin'); 
		endif;
		
		if(!is_dir($backupdir)) :
		(!@mkdir($backupdir)) ? $error = 'error: "There was an error creating the backup folder. Please check your permissions on the assets folder"' : JPath::setPermissions($backupdir);
		endif;
		
		if(!is_dir($dbdir)) :
		(!@mkdir($dbdir)) ? $error = 'error: "There was an error creating the database backup folder. Please check your permissions on the assets folder"' : JPath::setPermissions($dbdir);
		endif;
		
		if(!is_dir($logosdir)) :
		(!@mkdir($logosdir)) ? $error = 'error: "There was an error creating the logos folder. Please check your permissions on the assets folder"' : JPath::setPermissions($logosdir);
		endif;
			
		if(!is_dir($backgroundsdir)) :
		(!@mkdir($backgroundsdir)) ? $error = 'error: "There was an error creating the backgrounds folder. Please check your permissions on the assets folder"' : JPath::setPermissions($backgroundsdir);
		endif;
		
		if(!is_dir($themeletsdir)) :
		(!@mkdir($themeletsdir)) ? $error = 'error: "There was an error creating the themelets folder. Please check your permissions on the assets folder"' : JPath::setPermissions($themeletsdir);
		endif;
		
		if(!is_dir($iphonedir)) :
		(!@mkdir($iphonedir)) ? $error = 'error: "There was an error creating the iphone folder. Please check your permissions on the assets folder"' : JPath::setPermissions($iphonedir);
		endif;
				
		if(isset($error)){
			$ret = '{'.$error.'}';
			echo $ret;
		}else{
			echo '{ error: "", success: "Assets folder structure successfully created. You may continue with the installation." }';
		}
	}
	
	function install_template(){
	
		$db = JFactory::getDBO();
	
		if(isset($_COOKIE['upgrade-type']) && $_COOKIE['upgrade-type'] === 'fresh-install'){
			$query = $db->setQuery('DROP TABLE #__configurator');
			$db->query($query);
			$query = $db->setQuery('DROP TABLE #__configurator_preferences');
			$db->query($query);
			$this->parse_mysql_dump(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_configurator'.DS.'install.sql');
		}
		
		function db_update(){
			if(isset($_COOKIE['upgrade-type']) && $_COOKIE['upgrade-type'] === 'fresh-install'){
				$templatesdir = JPATH_SITE . DS . 'templates';
				$xml_param_loader = new morphXMLLoader($templatesdir.DS.'morph'.DS.'core'.DS.'morphDetails.xml');
				$main_xml_params = $xml_param_loader->getParamDefaults();
				
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
				foreach($removeParams as $r){
					unset($main_xml_params[$r]);
				}
				
				JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_configurator'.DS.'tables');
				
				foreach($main_xml_params as $param_name => $param_value){
					$setting = JTable::getInstance('ConfiguratorTemplateSettings','Table');
					$setting->source = 'template';
					$setting->template_name = 'morph';
					$setting->published = '1';
					$setting->param_name = $param_name;
					$setting->loadByKey();
					$setting->param_value = $param_value;
					
					if (!$setting->store(TRUE)) {
						echo $setting->getError();
						die();
					}
		
					unset($setting);
					$setting = null;
				}
			}else{
				return true;
			}
		}
		
		$newtemplatefile = @JRequest::getVar( 'template-file', null, 'files', 'array' );
		$templatesdir = JPATH_SITE . DS . 'templates';
		$backupdir = JPATH_SITE . DS . 'morph_assets' . DS . 'backups';
		$logosdir = JPATH_SITE . DS . 'morph_assets' . DS . 'logos';
		$backgroundsdir = JPATH_SITE . DS . 'morph_assets' . DS . 'backgrounds';
		$themeletsdir = JPATH_SITE . DS . 'morph_assets' . DS . 'themelets';
		$ret = '';
				
		
		if(is_dir($templatesdir . DS . 'morph')){
			setcookie('upgrade_morph', 'true');
			// template folder
			if($_REQUEST['backup'] == 'true'){
				setcookie('installed_bkpmorph', 'true');
				// backup existing
				$backupfile = $backupdir . DS . 'file_template_morph_' . time();
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
						
						db_update();
						
						setcookie('installed_morph', 'true');
						$ret = '{'.$msg.'}';
						echo $ret;
					}
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
			db_update();
			setcookie('installed_morph', 'true');
			$ret = '{'.$msg.'}';
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
			
			$success = 'msg: "Morph Upgraded Successfully", success: "Morph upgraded successfully", error: ""';
			return $success;
		}
		
	}
	
	function clean($array) {
		return array_map('addslashes', $array);
	}
	
	function get_structure($table='', $where='', $structure='', $delete='') {
		
        $sql = null;
		$sql_structure = null;
		$sql_data = null;
		$i = 0;
		if($table == '') $table = array();
		
		if(isset($_GET['url'])){
			if(isset($_GET['table'])) $table = $_GET['table'];
			if(isset($_GET['where'])) $where = stripslashes($_GET['where']);
			if(isset($_GET['structure'])) {
				if($_GET['structure'] == 'true'){
					$structure = true;
				}else{
					$structure = false;
				}
			}
		}
		
		$db = JFactory::getDBO();
		if($table == '' || empty($table)) { $td = $db->getTableList(); } else { $td = $table; }
		$r = $db->getTableCreate($td);
		
		if($r){
			foreach($r as $k => $v){
				$sql_structure .= 'DROP TABLE IF EXISTS `'. $k . "`;\n" . $v . ";\n\n";
				if(is_array($table)) $table[] = $k;
			}
		}
		
		if($structure == false) $sql_structure = null;
		
		if(is_array($table)){
			foreach($table as $t){
				if($where !== '') { 
					$db->setQuery("SELECT * FROM `$t` where " . $where . ";"); }else{ $db->setQuery("SELECT * FROM `$t`"); 
				}
				
				$data = $db->loadAssocList();
				if(!empty($data)){
					foreach ($data as $v){
						if($where !== '') $v['id'] = '';
						$v = $this->clean($v);
						$sql_data .= "INSERT INTO `$t` VALUES(";
					    $sql_data .= "'".implode("','",$v)."'";
						$sql_data .= ");\n";	
					}
					if ($i++>0) $sql_data .="\n";
				}
			}
		}else{
			if($where !== '') { 
				$db->setQuery("SELECT * FROM `$table` WHERE " . $where . ";"); }else{ $db->setQuery("SELECT * FROM `$table`"); 
			}
			$data = $db->loadAssocList();
			
			if($delete){
				$sql_data .= "DELETE FROM `$table` WHERE source = 'themelet';" . "\n\n";
			}
			
			if(!empty($data)){
				foreach ($data as $v){
					if($where !== '') $v['id'] = '';
					$v = $this->clean($v);
					$sql_data .= "INSERT INTO `$table` VALUES(";
				    $sql_data .= "'".implode("','",$v)."'";
					$sql_data .= ");\n";	
				}
				if ($i++>0) $sql_data .="\n";
			}
		}
		
		if($sql_structure !== null) { $sql = '#--- Create Database Structure' . "\n\n" . $sql_structure  . "\n"; };
		$sql .= '#--- Create Inserts' . "\n\n" . $sql_data;
		
		if(isset($_GET['echo'])) echo $sql;
		return $sql; 
	}
	
	function create_sql_file($filename, $str){
		$h = fopen($filename, 'w'); 
    	$gzdata = gzencode($str, 9); 
   		fwrite($h, $gzdata);
		fclose($h);
		
		return true;
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
	
	function load_editor_file(){
		$filename = $_GET['file'];
		$type = $_GET['type'];
		$parent = $_GET['parent'];
		
		$db = JFactory::getDBO();
		$db->setQuery("select contents from #__configurator_customfiles where type='".$type."' and parent_name='".$parent."' and filename='".$filename."'");
		
		$res = $db->loadResult();
		echo stripslashes($res);
		return;
	}
	
	function save_editor_file(){
		$filename = $_GET['file'];
		$type = $_GET['type'];
		$parent = $_GET['parent'];
		$contents = $_POST['contents'];
		$contents = addslashes($contents);		
		
		$db = JFactory::getDBO();
		$db->setQuery("update #__configurator_customfiles set contents='".$contents."', last_edited=FROM_UNIXTIME(".time().") where type='".$type."' and parent_name='".$parent."' and filename='".$filename."'");
		$db->query() or die('Unable to save');

		return true;
	}
	
	function check_admin_session(){
		// Register the needed session variables
	    $session = JFactory::getSession();
		if($session->_state == 'active'){
			echo "active";
			return true;
		}else{
			echo "expired";
			return false;
		}
		
	}
	
	function get_modules_by_position(){
		$ret = '';
		$position = $_GET['position'];
		if($position == ''){ return false; }
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT `id`, `title`, `module` FROM `#__modules` WHERE `position`='".$position."';");
		$res = $db->loadAssocList();
		$count = 0;
		
		foreach($res as $title){
			$count++;
			$module = $title['module'];
			$id = $title['id'];
			$title = str_replace(' | ', ' ', $title['title']);
			$split = ',';
			if($count == count($res)) {
				$split = '';
			}
			if($title !== ''){
				$ret .= $title.':'.$module.'#'.$id.$split;
			}
		}
		echo $ret;
	}
	
	function migrate_modules(){
		$position = $_REQUEST['position'];
		$old_position = $_REQUEST['old_pos'];
		$modules = $_REQUEST['modules'];
		$modid = $_REQUEST['id'];
		
		$db = JFactory::getDBO();
		
		if($modules == ''){ 
			echo "There were no modules migrated to ".$position.".";
			return false;
		}
		
		if($position == ''){ 
			echo "You never selected a new module position.";
			return false;
		}
		
		if(preg_match('/,/i', $modules)){
			$modules = explode(',', $modules);
			$mod_id = explode(',', $modid);
			$count = count($modules);
			
			for($i=0;$i<$count;$i++){
				$query = "UPDATE `#__modules` SET `position` = '".$position."' WHERE `id` = '".$mod_id[$i]."' AND `position` = '".$old_position."' AND `module` = '".$modules[$i]."';";
				$db->setQuery($query);
				$db->query() or die('There was an error migrating the modules.');
			}
			echo 'Successfully migrated <strong>'.$count.'</strong> modules to the <strong>'.$position.'</strong> position.';
			return true;
		}else{
			$query = "UPDATE `#__modules` SET `position` = '".$position."' WHERE `id` = '".$modid."' AND `position` = '".$old_position."' AND `module` = '".$modules."';";
			$db->setQuery($query);
			$db->query() or die('There was an error migrating the modules.');
			echo 'Successfully migrated <strong>1</strong> module to the <strong>'.$position.'</strong> position.';
			return true;
		}
		return false;
	}
	
	function reset_modules(){
		$db = JFactory::getDBO();
		$position = $_GET['position'];
		if($position == ''){ return false; }
		if($position == 'left'){
			$db->setQuery("UPDATE `#__modules` SET `position` = 'left' WHERE `position` = 'outer1' OR `position` = 'outer2' OR `position` = 'outer3' OR `position` = 'outer4' OR `position` = 'outer5'; ");
			$db->query();
		}
		if($position == 'right'){
			$db->setQuery("UPDATE `#__modules` SET `position` = 'right' WHERE `position` = 'inner1' OR `position` = 'inner2' OR `position` = 'inner3' OR `position` = 'inner4' OR `position` = 'inner5'; ");
			$db->query() or die($db->mysqlError());
		}
		return true;
	}
	
}
?>