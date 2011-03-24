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
		$config->append(array(
			'request' => array(
				'template' => 'morph'
			)
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
		
		//This is should also be in its own file
		if(JFolder::exists(JPATH_ROOT.'/templates/morph'))
		{
			$version 	= new JVersion;
			$target		= JPATH_ROOT.'/templates/morph/html';
			$source		= JPATH_ROOT.'/templates/morph/html_j'.str_replace('.', '', $version->RELEASE);
			if(JFolder::exists($source))
			{
				foreach(JFolder::folders($source) as $folder)
				{
					$destination = $target.'/'.$folder;
					if(!JFolder::exists($destination)) JFolder::copy($source.'/'.$folder, $destination);
				}

				foreach(JFolder::files($source) as $file)
				{
					$destination = $target.'/'.$file;
					if(!JFile::exists($destination)) JFile::copy($source.'/'.$file, $destination);
				}
			}
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
			//'articlepositions',
			'blogenhancements',
			'customfonts'
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

		$this->_redirect = 'index.php?option=com_configurator&view='.$this->_identifier->name;
		return $rowset;
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

	function clean($array) {
		return array_map('addslashes', $array);
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