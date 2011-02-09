<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined('_JEXEC') or die('Restricted access');

/**
 * ComConfiguratorControllerAbstract
 *
 * Abstract base controller for Configurator
 *
 * @TODO desparatly needs a cleanup
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorControllerAbstract extends ComDefaultControllerDefault
{
	public function __construct(KConfig $config)
	{
		$config->request->append(array(
			'template' => 'morph'
		));

		parent::__construct($config);

		$uri = clone JFactory::getURI();		
		$shortcuts = array('unpack' => 'pack', 'noshortkey' => 'shortkey', 'noupdates' => 'updates');
		foreach($shortcuts as $cookie => $shortcut)
		{
			$isset = array('cookie' => isset($_GET[$cookie]), 'shortcut' => isset($_GET[$shortcut]));

			if($isset['cookie'])		setcookie($cookie, 'true', 0, '/');
			elseif($isset['shortcut'])	setcookie($cookie, 'true', time()-3600, '/');

			$uri->delVar($shortcut);
			$uri->delVar($cookie);
			$redirect = array(
				'url' => $uri->toString(),
				'msg' => JText::_($shortcut . ' is ' . ( $isset['shortcut'] ? 'on' : 'off' ) )
			);
			if($isset['cookie'] || $isset['shortcut']) JFactory::getApplication()->redirect($redirect['url'], $redirect['msg']);
		}
		
		$cache = JPATH_ROOT . '/cache/com_configurator/install_cleanup.txt';

		if(JFile::exists($cache)) return;

		//This should be moved to its own file
		$db = JFactory::getDBO();
		$fields = $db->getTableFields(array('#__configurator'), true);
		if($fields['#__configurator']['param_value'] == 'varchar')
		{
			$db->setQuery("ALTER TABLE #__configurator CHANGE COLUMN `param_value` `param_value` TEXT DEFAULT NULL");
			$db->query();
		}
		
		
		
		KFactory::get('admin::com.configurator.helper.utilities')->installCleanup();
		$content = 'Cleanup executed: ' . gmdate('Y-m-d h:m:s');
		JFile::write($cache, $content);
	}
	
	protected function _initialize(KConfig $config)
	{
		$config->append(array(
			'request' => array('layout' => 'default')
		));

		parent::_initialize($config);
	}

	function assets_backup(){
		$assets = JPATH_ROOT.'/morph_assets';
		
		if(isset($_GET['type'])){ 
			$type = $_GET['type'];
		}else{
			$type = 'gzip';
		}
		
		switch($type){
			case 'gzip':
			JArchive::create(JPATH_ROOT.'/morph_assets',$assets, 'gz', '', JPATH_ROOT, true);
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
			$zip->create(JPATH_ROOT.'/morph_assets',$zip_array);
			$filename = 'morph_assets.zip';
			header('Content-Type: application/zip');
			break;
		}
		
		
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private',false);
		header('Content-Disposition: attachment; filename="'.basename(JPATH_ROOT.'/'.$filename).'"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.filesize(JPATH_ROOT.'/'.$filename)); 
		readfile(JPATH_ROOT.'/'.$filename);
		JFile::delete(JPATH_ROOT.'/'.$filename);
		exit();
	}
	
	protected function _actionHandle_backup(){
		$action = $context->data->do;
		$filename = $context->data->filename;
		$type = $context->data->type;
		$fp = '';
		switch($type){
			case 'db':
			$fp ='/db';
			break;
			case 'file':
			$fp = '';
			break;
		}
		$db_folder = JPATH_ROOT.'/morph_assets/backups'.$fp;
		$recyclebin = JPATH_ROOT.'/morph_recycle_bin';
		
		if(file_exists($db_folder.'/'.$filename)){
			switch($action){
				case 'delete':
					JFile::move($db_folder.'/'.$filename, $recyclebin.'/'.$filename);
					echo '<strong>'.$filename.'</strong> deleted successfully</div>';
				break;
				case 'download':
				header('Content-Type: application/x-gzip');
				header('Pragma: public');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Cache-Control: private',false);
				header('Content-Disposition: attachment; filename="'.basename($db_folder.'/'.$filename).'"');
				header('Content-Transfer-Encoding: binary');
				header('Content-Length: '.filesize($db_folder.'/'.$filename)); 
				readfile($db_folder.'/'.$filename);
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

	/**
	 * @TODO move this into a separate controller
	 */
	protected function _actionSaveprefs(KCommandContext $context)
	{
		$table	= KFactory::get('admin::com.configurator.database.table.preferences');
		$data	= $context->data->cfg;

		foreach($data as $key => $value)
		{
			$table->select(array('pref_name' => $key))->setData(array('pref_value' => $value))->save();
		}

		$this->_redirect = KRequest::url();
	}
	
	/*
	 * Generic apply action
	 *
	 *	@param	mixed 	Either a scalar, an associative array, an object
	 * 					or a KDatabaseRow
	 * @return 	KDatabaseRow 	A row object containing the saved data
	 */
	protected function _actionApply(KCommandContext $context)
	{
		$data		= $context->data;
		$filtered	= array();
		$groups		= array(
			'general',
			'logo',
			'tagline',
			'htmlbackgrounds',
			'bodybackgrounds',
			'color',
			'progressive',
			'menu',
			'iphone',
			'performance',
			'debugging',
			'toolbar',
			'masthead',
			'subhead',
			'topnav',
			'topshelf',
			'bottomshelf',
			'bottomshelf2',
			'bottomshelf3',
			'user1',
			'user2',
			'inset1',
			'inset2',
			'inset3',
			'inset4',
			'main',
			'innersidebar',
			'inner1',
			'inner2',
			'inner3',
			'inner4',
			'inner5',	
			'outersidebar',
			'outer1',
			'outer2',
			'outer3',
			'outer4',
			'outer5',
			'footer',
			'components_inner',
			'components_outer',
			'mootoolscompat',
			'captify',
			'lightbox',
			'preloader',
			'jomsocial',
			'jomsocialboxes',
			'articleenhancements',
			'blogenhancements',
			'googlefonts'
		);
		foreach($groups as $group)
		{
			if(!isset($data->$group)) continue;
			foreach($data->$group as $key => $value)
			{
				$filtered[$key] = $value;
			}
		}
	
		$rowset = $this->execute('edit', $filtered);

		$this->_redirect = 'view='.$this->_identifier->name;
		return $rowset;
	}

	function setMenuItem()
	{
		// Set the current active menu item
		$app         = JFactory::getApplication();
		$menu_item   = JRequest::getInt('menuitem', $app->getUserState('configurator'));
		$app->setUserState('configurator', $menu_item);
		if(!$this->isAjax()) $app->redirect('index.php?option=com_configurator&view=configuration', JText::_('Current menu item changed'));
		return true;
	}
	
	function resetMenuItems()
	{
		// Set the current active menu item
		$app         = JFactory::getApplication();
		$menu_item   = JRequest::getInt('menuitem', $app->getUserState('configurator'));
		$app->setUserState('configurator', 0);
		$table = JTable::getInstance('ConfiguratorTemplateSettings', 'Table');
		$reset = $table->resetMenuItems();
		$msg   = !$reset ? JText::_('There were no menu item settings to reset.') : sprintf(JText::_('%s menu items settings reset'), $reset);
		if(!$this->isAjax()) $app->redirect('?option=com_configurator&view=configuration', $msg);
		return true;
	}
	
	function isAjax() {
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
	}

	function findLine($filename, $str){
		$file = file($filename);
		$file = array_map('trim', $file);
		$find = array_search($str, $file);
		return $find === false ? false:$find + 1;
	}

	protected function _actionUni_installer()
	{
		$mem_limit = ini_get('memory_limit');
		if(str_replace('M', '', $mem_limit) < 128){ ini_set('memory_limit', '128M'); }
		
			$return = array();		
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
						$return['error'] = "No file has been selected. Please select a file in <strong>Step 2</strong> and try again.";
					}
				}else{
					$return['error'] = "No install type has been selected. Please make a selection in <strong>Step 1</strong> and try again.";
				}
			}else{
				$return['error'] = "Upload failed: No post data!";
			}
			
			echo json_encode($return);
			die();
	}
	
	function assets_upload(){
		$assetsdir 	= JPATH_SITE.'/morph_assets';
		$logos 		= $assetsdir.'/logos';
		$bg			= $assetsdir.'/backgrounds';
		$iphone		= $assetsdir.'/iphone';
		$tempassets = $assetsdir.'/temp_assets';
		$message 	= array();
		
		$file 		= JRequest::getVar( 'insfile', '', 'files', 'array' );
		
		if(!is_dir($tempassets)){JFolder::create($tempassets);}
		JPath::setPermissions($tempassets);
		
		if(!JFile::upload($file['tmp_name'], $tempassets.'/'.strtolower(basename($file['name']))) ){
			return array('error' => "Could not move file to required location!");
		}
		 		
		$result = JArchive::extract( $tempassets.'/'.strtolower(basename($file['name'])), $tempassets);
		
		if ($h = opendir($tempassets)) {
		    while (false !== ($f = readdir($h))) {
		        if ($f !== "." && $f !== ".." && $f !== '.DS_Store' && $f !== '__MACOSX') {
		            if(is_dir($tempassets.'/'.$f)){
						if ($h2 = opendir($tempassets.'/'.$f)){
							 while (false !== ($f2 = readdir($h2))) {
								if ($f2 !== "." && $f2 !== ".." && $f2 !== '.DS_Store') {
									if(!file_exists($assetsdir.'/'.$f.'/'.$f2)){
										JFile::move($tempassets.'/'.$f.'/'.$f2, $assetsdir.'/'.$f.'/'.$f2);
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
		$this->clear_cache();
		return array('success' => "Assets uploaded successfully.", 'error' => '');
	}
	
	function demo_upload(){
	
		$backupdir 	= JPATH_SITE.'/morph_assets/backups/db';
		$tempdir 	= JPATH_SITE.'/morph_assets/backups/db/temp';
		$message 	= array();
		$file 		= JRequest::getVar( 'insfile', '', 'files', 'array' );

		if(!is_dir($tempdir)){JFolder::create($tempdir);}
		JPath::setPermissions($tempdir);
		
		$conf = JFactory::getConfig();
		$database = $conf->getValue('config.db');
		
		$this->create_db_backup('full-database');
		
		if( !JFile::upload($file['tmp_name'], $tempdir.'/'.strtolower(basename($file['name']))) ){
			return array('error' => "Could not move file to required location!");
		}
		
		$result = JArchive::extract( $tempdir.'/'.strtolower(basename($file['name'])), $tempdir);
		$this->parse_mysql_dump($tempdir.'/'.str_replace('.zip', '', strtolower(basename($file['name']))) );
		
		$this->cleanupThemeletInstall(strtolower(basename($file['name'])), $tempdir);
		
		return array('error' => "", 'success' => 'Sample content successfully installed.');

	}
	
	function restore_db_backup(){
	
		$filename = $_REQUEST['filename'];
		$backupdir 	= JPATH_SITE.'/morph_assets/backups/db';
		$tempdir 	= JPATH_SITE.'/morph_assets/backups/db/temp';

		if(!is_dir($tempdir)){JFolder::create($tempdir);}
		JPath::setPermissions($tempdir);
		
		$this->parse_mysql_dump($backupdir . '/' .$filename );
		
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
			
			$iphone_dir = JPATH_ROOT.'/morph_assets/iphone';
			// errors
			if( $file['error'] ){
				return array('error' => 'Upload error ('.$file['error'].')');
			}
			if( !is_uploaded_file($file['tmp_name']) ){
				return array('error' => 'Not an uploaded file! Hack attempt?');
			}
			if( file_exists($iphone_dir.'/'.strtolower(basename($file['name']))) ) {
				return array('error' => 'A file with that name already exists!');
			}
			if( !is_dir($iphone_dir) ) {
				// Directory doesnt exist, try to create it.
				if( !mkdir($iphone_dir) ){
					return array('error' => 'Could not save file, directory does not exist!');
				}else{
					JPath::setPermissions($iphone_dir);
				}
			}else{ 
				JPath::setPermissions($iphone_dir); 
			}
			if( !is_writable($iphone_dir) ){
				return array('error' => 'Could not save file, permission error!');
			}
			if( !JFile::upload($file['tmp_name'], $iphone_dir.'/'.strtolower(basename($file['name']))) ){
				return array('error' => 'Could not move file to required location!');
			}
		
			JPath::setPermissions($iphone_dir.'/'.strtolower(basename($file['name'])));
			return array('error' => '', 'success' => 'File successfully uploaded.');
		}
		return array('error' => 'There was an error uploading the file. Please try again.');
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
			@JPath::setPermissions($templatesdir.'/morph');
			if(!$this->deleteDirectory($templatesdir.'/morph')){
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

	protected function _actionExport_db(){
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
		$backupdir 	= JPATH_SITE.'/morph_assets/backups/db';
		$tempdir 	= JPATH_SITE.'/morph_assets/backups/db/temp';
		$file 		= JRequest::getVar( 'import_file', '', 'files', 'array' );
		
		if(!is_dir($tempdir)){JFolder::create($tempdir);}
		JPath::setPermissions($tempdir);
		
		if( !JFile::upload($file['tmp_name'], $tempdir.'/'.strtolower(basename($file['name']))) ){
			return array('error' => 'Could not move file to required location!');
		}
		
		$result = JArchive::extract( $tempdir.'/'.strtolower(basename($file['name'])), $tempdir);
		$this->parse_mysql_dump($tempdir.'/'.str_replace('.gz', '', strtolower(basename($file['name']))) );
		
		$this->cleanupThemeletInstall(strtolower(basename($file['name'])), $tempdir);
		
		echo json_encode(array('success' => 'SQL file imported successfully.'));
		return true;
	}
	
	//@TODO clean this up and move it all into a proper action or method
	//or better yet just leave backups to Akeeba
	function create_db_backup($type='', $name='', $download=''){
	
		$db = JFactory::getDBO();
		$pref = $db->getPrefix();
		$n = '';
		
		if(isset($_REQUEST['url'])){
			if(isset($_REQUEST['type'])) $type = $_REQUEST['type'];
			if(isset($_REQUEST['name'])) $name = $_REQUEST['name'];
			if(isset($_REQUEST['download'])) $download = $_REQUEST['download'];
		}
		
		$backupdir = JPATH_SITE.'/morph_assets/backups/db';
		if(!is_dir($backupdir)) mkdir($backupdir);
		JPath::setPermissions($backupdir);
		if($name !== '') $n = $name.'_';
		$backupfile = 'db_'.$type.'_'.$n.time().'.sql.gz';
		
		switch($type){
			case 'themelet-settings':
				$files = JFolder::files($backupdir);
				foreach($files as $f){
					if(preg_match('/'.$name.'/i', $f)){
						$backup = $backupdir.'/'.$f;
						if(file_exists($backup)) JFile::delete($backup);
					}	
				}
				$this->create_sql_file($backupdir.'/'.$backupfile, $this->get_structure($pref . 'configurator', "source='themelet'", false, true));
			break;
			case 'full-database':
				if(isset($download) && $download == 'true'){
					header('Content-disposition: attachment; filename='.$backupfile);
					header('Content-type: application/x-gzip');
					echo gzencode($this->get_structure('','',true, false), 9);
				}else{
					$this->create_sql_file($backupdir.'/'.$backupfile, $this->get_structure('','',true, false));
				}
			break;
			case 'configurator-settings':
				$this->create_sql_file($backupdir.'/'.$backupfile, $this->get_structure($pref . 'configurator', '', true, false));	
			break;
			case 'configurator-preferences':
				$this->create_sql_file($backupdir.'/'.$backupfile, $this->get_structure($pref . 'configurator_preferences', '', true, false));
			break;
		}
		
		return $backupdir.'/'.$backupfile;
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
	
	function show_error($err, $type, $cookie){
		if(isset($_COOKIE['notice']) && $_COOKIE['notice'] !== $cookie || !isset($_COOKIE['notice'])) {
			return '<div class="cfg-message"><p class="'.$type.'">'.$err.'<a href="#" class="close-msg">close</a></p></div>';
		}
	}
	
	protected function _actionReset_database(KCommandContext $context)
	{
		$db = JFactory::getDBO();
		$table	= $this->getModel()->getTable();
		$template_dir = JPATH_ROOT.'/templates/morph';
		$themelet_dir = JPATH_ROOT.'/morph_assets/themelets';
		
		if(!isset($_GET['reset_type']) or $_GET['reset_type'] == '') {
			echo json_encode(array('error' => 'No reset type detected. Reset failed.', 'success' => ''));
			return false;
		}
		
		switch($_GET['reset_type']){
			case 'prefs':
				$this->create_db_backup('configurator-preferences');
				$query = 'truncate table #__configurator_preferences';
				$db->setQuery($query);
				$db->query();
				echo json_encode(array('type' => 'prefs', 'success' => 'Configurator preferences reset successfully', 'error' => ''));
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
				$template_xml = $template_dir.'/core/morphDetails.xml';
				$xml_param_loader = new ComConfiguratorHelperParamLoader($template_xml);
				$template_xml_params = $xml_param_loader->getParamDefaults();

				// remove the elements grouping from being added to the database
				$removeParams = array('Color Picker Param','Filelist Param','Folderlist Param','Heading Param','Imagelist Param','List Param','Radio Param','Spacer Param','Text Param','Textarea Param','Themelet Param');
				foreach($template_xml_params as $key => $val){
					if(in_array($key, $removeParams)) unset($template_xml_params[$key]);
				}
				
				// add morphDetails.xml defaults to the CFG table
				foreach($template_xml_params as $param_name => $param_value)
				{
					$query	= KFactory::tmp('lib.koowa.database.query')
																		->where('template_name', '=', 'morph')
																		->where('published',	 '=', 1)
																		->where('source',		 '=', 'templatexml')
																		->where('param_name',	 '=', $param_name);
					$row			= $table->select($query, KDatabase::FETCH_ROW);
	
					$row->template	= 'morph';
					$row->source	= 'templatexml';
					$row->name		= $param_name;
					$row->value		= $param_value;
	
					$row->save();
				}
				
				// add themeletDetails.xml to the database
				$themelet = $themelet_dir.'/'.$c_themelet;
				if(is_file($themelet.'/themeletDetails.xml')){
					$xml_param_loader = new ComConfiguratorHelperParamLoader($themelet.'/themeletDetails.xml');
					$themelet_xml_params = $xml_param_loader->getParamDefaults();

					foreach($themelet_xml_params as $param_name => $param_value)
					{
						$query	= KFactory::tmp('lib.koowa.database.query')
																			->where('template_name', '=', 'morph')
																			->where('published',	 '=', 1)
																			->where('source',		 '=', 'themelet')
																			->where('param_name',	 '=', $param_name);
						$row			= $table->select($query, KDatabase::FETCH_ROW);
		
						$row->template	= 'morph';
						$row->source	= 'themelet';
						$row->name		= $param_name;
						$row->value		= $param_value;
		
						$row->save();
					}
				}
				
				// re-insert themelet
				$query = "update #__configurator set param_value = '".$c_themelet."', source = 'reset' where param_name = 'themelet';";
				$db->setQuery($query);
				$db->query();
				
				echo json_encode(array('type' => 'cfg', 'success' => 'Configurator settings reset successfully', 'error' => ''));
				return true;
			break;
		}
		return;
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
	
	function logo_upload() {
		$msg = '';
		$error = '';
		$template = 'morph';
		$logo_details = JRequest::getVar( 'insfile', null, 'files', 'array' );
		$image_type = $logo_details['type'];
		$allowed_types = array('image/jpeg','image/png', 'image/jpg', 'image/gif');
	
		if(!in_array($image_type, $allowed_types)){
			return array('error' => "This is not a valid logo file.<br />Please try again with a valid logo (png/gif/jpg)");
		}else{
			// if there is no file error then continue
			if($logo_details['error'] != 4) {
				$logo_dir = JPATH_SITE.'/morph_assets/logos';
				
				// errors
				if( $logo_details['error'] ){
					return array('error' => 'Upload error ('.$logo_details['error'].')');
				}
				if( !is_uploaded_file($logo_details['tmp_name']) ){ 
					return array('error' => "Not an uploaded file! Hack attempt?");
				}
				if( file_exists($logo_dir.'/'.strtolower(basename($logo_details['name']))) ) {
					return array('error' => "A file with that name already exists!");
				}
				if( !is_dir($logo_dir) ) {
					// Directory doesnt exist, try to create it.
					if( !mkdir($logo_dir) ){
						return array('error' => "Could not save file, directory does not exist!");
					}else{
						JPath::setPermissions($logo_dir);
					}
				}
				if( !is_writable($logo_dir) ){
					return array('error' => "Could not save file, permission error!");
				}
				if( !JFile::upload($logo_details['tmp_name'], $logo_dir.'/'.strtolower(basename($logo_details['name']))) ){
					return array('error' => "Could not move file to required location!");
				}
			
				JPath::setPermissions($logo_dir.'/'.strtolower( basename( $logo_details['name'] ) ) );
				$query	= KFactory::tmp('lib.koowa.database.query')
																	->where('template_name', '=', 'morph')
																	->where('published',	 '=', 1)
																	->where('source',		 '=', 'themelet')
																	->where('param_name',	 '=', 'templatelogo');
				$row			= $this->getModel()->getTable()->select($query, KDatabase::FETCH_ROW);

				$row->template	= 'morph';
				$row->source	= 'themelet';
				$row->name		= 'templatelogo';
				$row->value		= strtolower( basename( $logo_details['name'] ) );

				$row->save();
				return array('success' => 'Logo uploaded successfully!', 'error' => '', 'logo' => $logo_details['name']);
			}
			
			return array('error' => "There was an error uploading the file. Please try again.");
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
			return array('error' => 'This is not a valid background file.<br />Please try again with a valid background (png/gif/jpg)');
		}else{
			// if there is no file error then continue
			if($background_details['error'] != 4) {
				$background_dir = JPATH_SITE.'/morph_assets/backgrounds';
				
				// errors
				if( $background_details['error'] ){
					return array('error' => 'Upload error ('.$background_details['error'].')');
				}
				if( !is_uploaded_file($background_details['tmp_name']) ){ 
					return array('error' => 'Not an uploaded file! Hack attempt?');
				}
				if( file_exists($background_dir.'/'.strtolower(basename($background_details['name']))) ) {
					return array('error' => 'A file with that name already exists!');
				}
				if( !is_dir($background_dir) ) {
					// Directory doesnt exist, try to create it.
					if( !mkdir($background_dir) ){
						return array('error' => 'Could not save file, directory does not exist!');
					}else{
						JPath::setPermissions($background_dir);
					}
				}
				if( !is_writable($background_dir) ){
					return array('error' => 'Could not save file, permission error!');
				}
				if( !JFile::upload($background_details['tmp_name'], $background_dir.'/'.strtolower(basename($background_details['name']))) ){
					return array('error' => 'Could not move file to required location!');
				}
			
				JPath::setPermissions($background_dir.'/'.strtolower( basename( $background_details['name'] ) ) );
				$query	= KFactory::tmp('lib.koowa.database.query')
																	->where('template_name', '=', 'morph')
																	->where('published',	 '=', 1)
																	->where('source',		 '=', 'themelet')
																	->where('param_name',	 '=', 'templatebackground');
				$row			= $this->getModel()->getTable()->select($query, KDatabase::FETCH_ROW);

				$row->template	= 'morph';
				$row->source	= 'themelet';
				$row->name		= 'templatebackground';
				$row->value		= strtolower( basename( $background_details['name'] ) );

				$row->save();
				return array('error' => '', 'success' => 'Background Uploaded Successfully', 'background' => $background_details['name']);
			}
			
			return array('error' => 'There was an error uploading the file. Please try again.');
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
			return array('error' => 'This is not a valid favicon file.<br />Please try again with a valid favicon (ico/gif/png)');
		}else{
			// if there is no file error then continue
			if($favicon_details['error'] != 4) {
				$favicon_dir = JPATH_ROOT.'/templates/'.$template;
				
				// errors
				if( $favicon_details['error'] ){
					return array('error' => 'Upload error ('.$favicon_details['error'].')');
				}
				if( !is_uploaded_file($favicon_details['tmp_name']) ){ 
					return array('error' => 'Not an uploaded file! Hack attempt?');
				}
				if( file_exists($favicon_dir.'/'.strtolower(basename('favicon.ico'))) ) {
					return array('overwrite' => 'A favicon file already exists.<br />Overwrite?');
				}
				if( !is_dir($favicon_dir) ) {
					// Directory doesnt exist, try to create it.
					if( !mkdir($favicon_dir) ){
						return array('error' => 'Could not save file, directory does not exist!');
					}else{
						JPath::setPermissions($favicon_dir);
					}
				}
				if( !is_writable($favicon_dir) ){
					return array('error' => 'Could not save file, permission error!');
				}
				if( !JFile::upload($favicon_details['tmp_name'], $favicon_dir.'/'.strtolower(basename('favicon.ico'))) ){
					return array('error' => 'Could not move file to required location!');
				}
			
				JPath::setPermissions($favicon_dir.'/'.strtolower( basename( $favicon_details['name'] ) ) );
				return array('error' => '', 'success' => 'Favicon Uploaded Successfully');
			}
			
			return array('error' => 'There was an error uploading the file. Please try again.');
		}
	}

	protected function _actionHandle_recycle(KCommandContext $context)
	{
		$action = $context->data->do;
		if(isset($context->data->file)) $file = $context->data->file;
		if(isset($context->data->type)) $type = $context->data->type;
		$rb_root = JPATH_SITE.'/morph_recycle_bin';
		
		if($action){
			switch($action){
				case 'delete':
					if($type !== 'themelet') {
						JFile::delete($rb_root.'/'.$file);
						return true;
					} else {				
						JFolder::delete($rb_root.'/'.$file);
						return true;
					}
				break;
				case 'restore':
					$recycle_dir = $rb_root = JPATH_SITE.'/morph_recycle_bin';
					$restore_dir = $rb_root = JPATH_SITE.'/morph_assets';
					
					function move_asset($f, $t, $r, $rc){
						if(is_dir($rc.'/'.$f)){
							if(JFolder::move($rc.'/'.$f, $r.'/'.$f)){
								JFolder::delete($rc.'/'.$f);
								return true;
							}
						}else{
							echo $f;
							if($t == 'file' || $t == 'db'){
								$mf = $r.'/'.$f;
							}else{
								$mf = $r.'/'.str_replace($t.'_', '', $f);
							}
							if(JFile::move($rc.'/'.$f, $mf)){
								JFile::delete($rc.'/'.$f);
								return true;
							}
						}
					}
					
					switch($type){
						case 'bg': 
						$restore_dir .='/backgrounds'; 
						move_asset($file, $type, $restore_dir, $recycle_dir);
						break;
						case 'iphone': 
						$restore_dir .='/iphone'; 
						move_asset($file, $type, $restore_dir, $recycle_dir); 
						break;
						case 'logo': 
						$restore_dir .='/logos'; 
						move_asset($file, $type, $restore_dir, $recycle_dir);
						break;
						case 'themelet': 
						$restore_dir .='/themelets'; 
						move_asset($file, $type, $restore_dir, $recycle_dir);
						break;
						case 'file': 
						$restore_dir .='/backups'; 
						move_asset($file, $type, $restore_dir, $recycle_dir);
						break;
						case 'db': 
						$restore_dir .='/backups/db'; 
						move_asset($file, $type, $restore_dir, $recycle_dir);
						break;
					}
					return true;
				break;
				case 'empty':
					$files = JFolder::files($rb_root, '', true, true, array('.git', '.idx', '.DS_Store'));
					$folders = JFolder::folders($rb_root, '', true, true, array('.git'));
					
					if(!empty($files)) JFile::delete($files);			
					if(!empty($folders)) JFolder::delete($folders);
					return true;
				break;
			}
		}
	}

	protected function _actionDelete_asset(KCommandContext $context)
	{
		$type = $context->data->deltype;
		$asset = $context->data->asset;
		$assetsdir = JPATH_SITE.'/morph_assets';
		$recyclebin = JPATH_SITE.'/morph_recycle_bin';
		
		switch($type){
		
			case 'themelet':
			$assetsdir .='/themelets';
			$assetsfile = $assetsdir.'/'.$asset;
			if (is_dir($assetsdir)) {
				if(JFolder::copy($assetsfile, $recyclebin.'/'.$asset)){
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
			$assetsdir .='/logos';
			$assetsfile = $assetsdir.'/'.$asset;			
			if (is_dir($assetsdir)) {
				if(JFile::move($assetsfile,$recyclebin.'/logo_'.$asset)){
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
			break;
			case 'iphone':
			$assetsdir .='/iphone';
			$assetsfile = $assetsdir.'/'.$asset;			
			if (is_dir($assetsdir)) {
				if(JFile::move($assetsfile,$recyclebin.'/iphone_'.$asset)){
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
			break;
			case 'background':
			$assetsdir .='/backgrounds';
			$assetsfile = $assetsdir.'/'.$asset;
			echo $assetsdir;		
			if (is_dir($assetsdir)) {
				if(JFile::move($assetsfile,$recyclebin.'/bg_'.$asset)){
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
	
	public function install_themelet()
	{
		$mem_limit = ini_get('memory_limit');
		if(str_replace('M', '', $mem_limit) < 64){ ini_set('memory_limit', '64M'); }
		
		$newthemeletfile = JRequest::getVar( 'insfile', null, 'files', 'array' );
		$activation = $_REQUEST['act_themelet'];
		$return = $this->themelet_upload($newthemeletfile);
		KFactory::get('admin::com.configurator.helper.utilities')->setInstallState('installed_themelet', true);
		$themelet = $return['themelet'];
		$themelet_name = str_replace('-',  ' ', $themelet);
		KFactory::get('admin::com.configurator.helper.utilities')->setInstallState('ins_themelet_name', $themelet_name);
		$db = JFactory::getDBO();
		
		if(isset($activation) && $activation == 'true'){
		
			if(isset($_COOKIE['upgrade-type']) && $_COOKIE['upgrade-type'] === 'fresh-install' || !isset($_COOKIE['upgrade-type']))
			{
				$this->themelet_activate(array('themelet' => $themelet));
			}
			KFactory::get('admin::com.configurator.helper.utilities')->setInstallState('installed_actthemelet', true);
			$query = $db->setQuery("select * from #__configurator where param_name = 'themelet'");
			$query = $db->query($query);
			$themelet_num = $db->getNumRows($query);
			if($themelet_num == '0'){
				$new_query = "INSERT INTO #__configurator VALUES ('' , 'morph', 'themelet', '".$db->getEscaped($themelet)."', '1', 'themelet');";
			}else{
				$new_query = "UPDATE #__configurator SET param_value = '".$db->getEscaped($themelet)."' where param_name = 'themelet';";
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
		
		echo json_encode($return);
	}
	
	protected function _actionAssets_create()
	{
		$recycle = JPATH_ROOT . '/morph_recycle_bin';
		if(!JFolder::exists($recycle)) JFolder::create($recycle);
		foreach(array('backups/db', 'logos', 'backgrounds', 'themelets', 'iphone') as $folder)
		{
			$dir = JPATH_ROOT . '/morph_assets/' . $folder;
			if(!JFolder::exists($dir)) JFolder::create($dir);
		}
		
		if(self::isAjax()) echo json_encode(array(
			'error'   => '',
			'success' => JText::_('Assets folder structure successfully created. You may continue with the installation.')
		));
	}
	
	private function _dbUpdate(){
		if(isset($_COOKIE['upgrade-type']) && $_COOKIE['upgrade-type'] === 'fresh-install'){
			$templatesdir = JPATH_SITE.'/templates';
			$xml_param_loader = new ComConfiguratorHelperParamLoader($templatesdir.'/morph/core/morphDetails.xml');
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
			
			$table = $this->getModel()->getTable();
			foreach($main_xml_params as $param_name => $param_value)
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
		}else{
			return true;
		}
	}
	
	public function install_template()
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
					@JPath::setPermissions($templatesdir.'/morph');
					if(!$this->deleteDirectory($templatesdir.'/morph')){
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
	}
	
	function deleteDirectory($dir) {
        if (!file_exists($dir)) return true;
        if (!is_dir($dir)) return unlink($dir);
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') continue;
            if (!$this->deleteDirectory($dir.'/'.$item)) return false;
        }
        return rmdir($dir);
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
		$r = str_replace('CREATE TABLE `', 'CREATE TABLE IF NOT EXISTS `', $db->getTableCreate($td));
		$r = array_filter($r, array($this, 'filter_table_views'));

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
						$sql_data .= "INSERT IGNORE INTO `$t` VALUES(";
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
					$sql_data .= "INSERT IGNORE INTO `$table` VALUES(";
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
	
	protected function filter_table_views($create_table_syntax)
	{
		return strstr($create_table_syntax, 'CREATE TABLE');
	}
	
	function create_sql_file($filename, $str){
		JFile::write($filename, gzcompress($str, 9));
		return true;
	}
	
	function parse_mysql_dump($url, $json = false)
	{
        jimport('joomla.installer.helper');
        $db = JFactory::getDBO();
        $raw = JFile::read($url);
        if(JFile::getExt($url) == 'gz') $raw = gzuncompress($raw);
        $queries = JInstallerHelper::splitSql($raw);
        foreach ($queries as $query)
        {
        	$query = trim($query);
        	if ($query != '' && $query{0} != '#')
        	{
        		$db->setQuery($query);
				$result = $db->query() or die($json ? json_encode(array('error' => 'MySQL error!<br />Line: <small>'.$sql_line.'</small><br />File: '.$url.'<br />Error: '.$db->getErrorMsg())) : $db->getErrorMsg());
			}
		}
	}
	
	protected function _actionGet_modules_by_position(){
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
	
	//@TODO clean this up
	protected function _actionMigrate_modules()
	{
		$position = KRequest::get('post.position', 'cmd');
		$old_position = KRequest::get('post.old_post', 'cmd');
		$modules = KRequest::get('post.modules', 'string');
		$modid = KRequest::get('post.id', 'string');
		
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
	
	protected function _actionReset_modules()
	{
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
	
	public function clear_cache()
	{
		$path = JPATH_ROOT.'/cache/morph';
		if(JFolder::exists($path)) JFolder::delete($path);
		
		$path = JPATH_ROOT.'/cache/morph-sessions';
		if(JFolder::exists($path)) JFolder::delete($path);
	}
 }