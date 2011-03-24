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
 * ComConfiguratorControllerBackup
 *
 * Deals with taking backups, restoring them and managing them
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
 class ComConfiguratorControllerBackup extends ComConfiguratorControllerDefault
 {
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
 }