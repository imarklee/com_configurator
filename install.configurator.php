<?php 
ob_start();
(strpos($_SERVER['SCRIPT_NAME'], 'install.configurator.php') === false) ? $base = './components/com_configurator' : $base = '.';
ini_set('memory_limit', '32M');
define('JINDEXURL', $base);
setcookie('installed_cfg', 'true');

define('ROOT', str_replace(array('/administrator/components/com_configurator','\administrator\components\com_configurator'), '', dirname(__FILE__)));
$backupdir = ROOT . DS . 'morph_assets' . DS . 'backups';
$logosdir = ROOT . DS . 'morph_assets' . DS . 'logos';
$backgroundsdir = ROOT . DS . 'morph_assets' . DS . 'backgrounds';
$themeletsdir = ROOT . DS . 'morph_assets' . DS . 'themelets';
$iphonedir = ROOT . DS . 'morph_assets' . DS . 'iphone';

// create assets folder
if(!is_dir(ROOT . DS . 'morph_assets')){
	if(!@mkdir(ROOT . DS . 'morph_assets')) { $error = true; }else{ JPath::setPermissions(ROOT . DS . 'morph_assets'); }

	if(!is_dir($backupdir)){
		(!@mkdir($backupdir)) ? $error = true : JPath::setPermissions($backupdir);
	}

	if(!is_dir($logosdir)){
		(!@mkdir($logosdir)) ? $error = true : JPath::setPermissions($logosdir);
	}
	
	if(!is_dir($backgroundsdir)){
		(!@mkdir($backgroundsdir)) ? $error = true : JPath::setPermissions($backgroundsdir);
	}
	
	if(!is_dir($themeletsdir)){
		(!@mkdir($themeletsdir)) ? $error = true : JPath::setPermissions($themeletsdir);
	}
	
	if(!is_dir($iphonedir)){
		(!@mkdir($iphonedir)) ? $error = true : JPath::setPermissions($iphonedir);
	}
}

$document = JFactory::getDocument();
$document->addScript(JURI::root() . 'administrator/components/com_configurator/installer/js/install.js.php');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/installer/css/install.css.php');
?>
<div id="install-wrap">
	<div id="installer">
	<?php
	if(!isset($_REQUEST['install'])){
		include 'installer/step1.php';
	}else{
		if($_REQUEST['install'] == 'step2'){
			include 'installer/step2.php';
		}
		elseif($_REQUEST['install'] == 'step3'){
			include 'installer/step3.php';
		}
		elseif($_REQUEST['install'] == 'completed'){
			include 'installer/complete.php';
		}
	}
	?>
	</div>
</div>
<div id="dialog" style="display:none;"></div>
<div id="help-dialog" style="display:none;"></div>
<?php if(isset($error) && $error){ include 'installer/error.php'; } ?>
<?php ob_end_flush(); ?>