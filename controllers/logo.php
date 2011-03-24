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
 * ComConfiguratorControllerLogo
 *
 * Assets controller that deals with logo graphics
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorControllerLogo extends ComConfiguratorControllerAsset
{
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
}