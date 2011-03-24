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