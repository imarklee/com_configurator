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
 * ComConfiguratorControllerAsset
 *
 * Base controller for assets, have to be extended
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
abstract class ComConfiguratorControllerAsset extends ComConfiguratorControllerDefault
{
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
}