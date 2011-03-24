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
 * ComConfiguratorControllerFavicon
 *
 * Assets controller that deals with favicons
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorControllerFavicon extends ComConfiguratorControllerAsset
{
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
}