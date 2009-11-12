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
$document->addScript(JURI::root() . 'administrator'.DS.'components'.DS.'com_configurator'.DS.'installer'.DS.'js'.DS.'install.js.php');
$document->addStyleSheet(JURI::root() . 'administrator'.DS.'components'.DS.'com_configurator'.DS.'installer'.DS.'css'.DS.'install.css.php');
$db = JFactory::getDBO();

// count number of param values stored in the db for upgrade purposes
$query = $db->setQuery("select count(*) from #__configurator where template_name = 'morph';");
$count_rows = $db->loadResult($query);

// remove cookies from previous installs
$cookies = array('cfg', 'nomorph', 'bkpmorph', 'morph', 'pubmorph', 'themelet', 'actthemelet', 'bkpdb', 'gzip', 'no_gzip');
foreach ($cookies as $cookie){
	if(isset($_COOKIE['installed_'.$cookie])) setcookie('installed_'.$cookie, '', time()-3600);
}
if(isset($_COOKIE['asset_exist'])) setcookie('asset_exist', '', time()-3600);
if(isset($_COOKIE['ins_themelet_name'])) setcookie('ins_themelet_name', '', time()-3600);
if(isset($_COOKIE['is_themelet_installed'])) setcookie('is_themelet_installed', '', time()-3600);
if(isset($_COOKIE['upgrade-type'])) setcookie('upgrade-type', '', time()-3600);
if(isset($_COOKIE['upgrade_cfg'])) setcookie('upgrade_cfg', '', time()-3600);
if(isset($_COOKIE['upgrade_morph'])) setcookie('upgrade_morph', '', time()-3600);
if(isset($_COOKIE['upgrade_themelet'])) setcookie('upgrade_themelet', '', time()-3600);

// check if a themelet is installed and if not set a cookie to hide the activation checkbox
$query = $db->setQuery("select param_value from #__configurator where param_name = 'themelet';");
$themelet_installed = $db->loadResult($query);
if($themelet_installed == null) setcookie('is_themelet_installed', 'no');

// create a full system backup
include 'controller.php';
$classname  = 'ConfiguratorController';
$controller = new $classname( );
$controller->create_db_backup('full-database');

// set cookie for configurator installer
setcookie('installed_cfg', 'true');

// set permissions on templates, assets and components folder.
JPath::setPermissions(JPATH_ROOT.DS.'templates');
JPath::setPermissions(JPATH_ROOT.DS.'administrator'.DS.'components');

// set gzip on/off based on browser
$conf = JFactory::getConfig();
if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')){
	if($conf->getValue('config.gzip') !== '1'){
		$path = JPATH_CONFIGURATION.DS.'configuration.php';
		JPath::setPermissions($path, '0777');
		if(file_exists($path) && is_writable($path)){			
			$str = file_get_contents($path);
			$line = str_replace('var $gzip = \'0\';', 'var $gzip = \'1\';', $str);
			file_put_contents($path, $line);
		}		
		JPath::setPermissions($path, '0644');
		setcookie('installed_gzip', 'true');
	}
}else{
	setcookie('installed_no_gzip', 'true');
}
?>
<div id="install-wrap">
	<div id="installer">
	<?php
	if(!isset($_REQUEST['install'])){
		if($count_rows > 0) :
			setcookie('upgrade_cfg', 'true');
			include 'installer'.DS.'step1_upgrade.php';
		else :
			include 'installer'.DS.'step1.php';
		endif;
	}else{
		if($_REQUEST['install'] == 'step2'){
			include 'installer'.DS.'step2.php';
		}
		elseif($_REQUEST['install'] == 'completed'){
			include 'installer'.DS.'complete.php';
		}
	}
	?>
	</div>
</div>
<div id="dialog" style="display:none;"></div>
<div id="help-dialog" style="display:none;"></div>
<?php if(isset($error) && $error){ include 'installer'.DS.'error.php'; } ?>
<?php ob_end_flush(); ?>