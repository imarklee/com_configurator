<?php 
ob_start();
(strpos($_SERVER['SCRIPT_NAME'], 'install.configurator.php') === false) ? $base = './components/com_configurator' : $base = '.';
ini_set('memory_limit', '32M');
define('JINDEXURL', $base);

define('ROOT', str_replace(array('/administrator/components/com_configurator','\administrator\components\com_configurator'), '', dirname(__FILE__)));

$backupdir = ROOT . DS . 'morph_assets' . DS . 'backups';
$dbdir = ROOT . DS . 'morph_assets' . DS . 'backups' . DS . 'db';
$logosdir = ROOT . DS . 'morph_assets' . DS . 'logos';
$backgroundsdir = ROOT . DS . 'morph_assets' . DS . 'backgrounds';
$themeletsdir = ROOT . DS . 'morph_assets' . DS . 'themelets';
$iphonedir = ROOT . DS . 'morph_assets' . DS . 'iphone';

// create assets folders
if(!is_dir(ROOT . DS . 'morph_assets')) 
(!@mkdir(ROOT . DS . 'morph_assets')) ? $error = true : JPath::setPermissions(ROOT . DS . 'morph_assets'); 

if(!is_dir($backupdir))
(!@mkdir($backupdir)) ? $error = true : JPath::setPermissions($backupdir);

if(!is_dir($dbdir))
(!@mkdir($dbdir)) ? $error = true : JPath::setPermissions($dbdir);

if(!is_dir($logosdir))
(!@mkdir($logosdir)) ? $error = true : JPath::setPermissions($logosdir);
	
if(!is_dir($backgroundsdir))
(!@mkdir($backgroundsdir)) ? $error = true : JPath::setPermissions($backgroundsdir);

if(!is_dir($themeletsdir))
(!@mkdir($themeletsdir)) ? $error = true : JPath::setPermissions($themeletsdir);

if(!is_dir($iphonedir))
(!@mkdir($iphonedir)) ? $error = true : JPath::setPermissions($iphonedir);


$document = JFactory::getDocument();
$document->addScript(JURI::root() . 'administrator/components/com_configurator/installer/js/install.js.php');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/installer/css/install.css.php');
$db = JFactory::getDBO();

// count number of param values stored in the db for upgrade purposes
$query = $db->setQuery("select count(*) from #__configurator where template_name = 'morph';");
$count_rows = $db->loadResult($query);

// remove cookies from previous installs
$cookies = array('cfg', 'nomorph', 'bkpmorph', 'morph', 'pubmorph', 'themelet', 'actthemelet', 'bkpdb', 'gzip', 'samplecont', 'samplemods');
foreach ($cookies as $cookie){
	if(isset($_COOKIE['installed_'.$cookie])) setcookie('installed_'.$cookie, '', time()-3600);
}
if(isset($_COOKIE['asset_exist'])) setcookie('asset_exist', '', time()-3600);
if(isset($_COOKIE['ins_themelet_name'])) setcookie('ins_themelet_name', '', time()-3600);
if(isset($_COOKIE['asset_exist'])) setcookie('is_themelet_installed', '', time()-3600);

// check if a themelet is installed and if not set a cookie to hide the activation checkbox
$query = $db->setQuery("select param_value from #__configurator where param_name = 'themelet';");
$themelet_installed = $db->loadResult($query);
if($themelet_installed == null) setcookie('is_themelet_installed', 'no');

// set cookie for configurator installer
setcookie('installed_cfg', 'true');

// set permissions on templates, assets and components folder.
JPath::setPermissions(JPATH_ROOT.DS.'templates');
JPath::setPermissions(JPATH_ROOT.DS.'administrator'.DS.'components');

?>
<div id="install-wrap">
	<div id="installer">
	<?php
	if(!isset($_REQUEST['install'])){
		if($count_rows > 0) :
			include 'installer/step1_upgrade.php';
		else :
			include 'installer/step1.php';
		endif;
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