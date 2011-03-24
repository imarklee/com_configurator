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
 * ComConfiguratorControllerInstaller
 *
 * Installs Configurator, and only Configurator. Themelet, Morph and assets are done in their own controllers
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
 class ComConfiguratorControllerInstaller extends ComConfiguratorControllerDefault
 {
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

 	protected function _actionAssets_create()
 	{
 		$recycle = JPATH_ROOT . '/morph_recycle_bin';
 		if(!JFolder::exists($recycle)) JFolder::create($recycle);
 		foreach(array('backups/db', 'logos', 'backgrounds', 'themelets', 'iphone') as $folder)
 		{
 			$dir = JPATH_ROOT . '/morph_assets/' . $folder;
 			if(!JFolder::exists($dir)) JFolder::create($dir);
 		}
 		
 		if(KRequest::type() == 'AJAX') echo json_encode(array(
 			'error'   => '',
 			'success' => JText::_('Assets folder structure successfully created. You may continue with the installation.')
 		));
 	}
 }