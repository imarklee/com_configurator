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
 * ComConfiguratorControllerIphone
 *
 * Assets controller that deals with iphone logos
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorControllerThemelet extends ComConfiguratorControllerAsset
{
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
}