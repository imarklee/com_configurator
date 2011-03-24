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
 * ComConfiguratorControllerBackground
 *
 * Assets controller that deals with background images
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorControllerBackground extends ComConfiguratorControllerAsset
{
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
}