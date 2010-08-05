<?php defined('_JEXEC') or die('Restricted access');
//@TODO this doesn't work on 1.6, so only run on 1.5 and previous
$version = new JVersion;
if(version_compare('1.6', $version->RELEASE, '>'))
{
	require_once JPATH_ADMINISTRATOR . '/components/com_configurator/depencies.php';
} else {
	require_once 'defines.php';
	require_once 'helpers/utilities.php';
	require_once 'toolbar.configurator.html.php';
	
	
	require_once 'controllers/abstract.php';
	require_once 'controllers/dispatch.php';
	require_once 'controllers/default.php';
}
ob_start();
(strpos($_SERVER['SCRIPT_NAME'], 'install.configurator.php') === false) ? $base = './components/com_configurator' : $base = '.';
$mem_limit = ini_get('memory_limit');
if(str_replace('M', '', $mem_limit) < 128){ ini_set('memory_limit', '128M'); }
define('JINDEXURL', $base);

// Reset instal state from previous installs
ComConfiguratorHelperUtilities::resetInstallState();

// remove cookies from previous installs
// @TODO get rid of the cookies
$cookies = array('nomorph', 'bkpdb', 'no_gzip');
foreach ($cookies as $cookie){
	if(isset($_COOKIE['installed_'.$cookie])) setcookie('installed_'.$cookie, '', time()-3600);
}
if(isset($_COOKIE['asset_exist'])) setcookie('asset_exist', '', time()-3600);
if(isset($_COOKIE['upgrade-type'])) setcookie('upgrade-type', '', time()-3600);
if(isset($_COOKIE['updates'])) setcookie('updates', '', time()-3600);

//@TODO this doesn't work on 1.6, so only run on 1.5 and previous
$version = new JVersion;
if(version_compare('1.6', $version->RELEASE, '>'))
{
	// The following is to avoid configurator from showing up in the frontend menu manager
	$com = JTable::getInstance('component');
	if($com->loadByOption('com_configurator'))
	{
		$com->link = '';
		$com->store(true);
	}

	
	// Move the search plugin
	$admin_path = 'administrator/components/com_configurator/morphcache';
	$plugins_path = 'plugins/system';
	if(JFolder::exists(JPATH_ROOT.'/'.$admin_path))
	{
		$plugin_exists = JFile::exists(JPATH_ROOT.'/'.$plugins_path.'/morphcache.xml');
		if($plugin_exists)
		{
			ComConfiguratorHelperUtilities::setInstallState('upgrade_morphcache', true);
			JFile::delete(JPATH_ROOT.'/'.$plugins_path.'/morphcache.xml');
			JFile::delete(JPATH_ROOT.'/'.$plugins_path.'/morphcache.php');
		}
		
		JFile::move($admin_path.'/morphcache.xml',  $plugins_path.'/morphcache.xml', JPATH_ROOT);
		JFile::move($admin_path.'/morphcache.php',  $plugins_path.'/morphcache.php', JPATH_ROOT);
		
		$status = new JObject();
		
		$db = JFactory::getDBO();
		// Check to see if a plugin by the same name is already installed
		$query = "DELETE FROM `#__plugins` WHERE element = 'morphcache'";
		$db->setQuery($query);
		$db->Query();
		// Insert in database
		$row = JTable::getInstance('plugin');
		$row->name = 'System - Morph Cache';
		$row->folder = 'system';
		$row->element = 'morphcache';
		$row->published = 1;
		if (!$row->store()) {
			// Install failed, roll back changes
			$this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.$db->stderr(true));
			return false;
		}
		
		ComConfiguratorHelperUtilities::setInstallState('installed_morphcache', true);
	}
}

// create assets folders
ComConfiguratorControllerAbstract::assets_create();


$document = JFactory::getDocument();
$document->addScript(JURI::root() . 'administrator/components/com_configurator/installer/js/install.js.php?v='.time());
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/installer/css/install.css.php');
$db = JFactory::getDBO();

// count number of param values stored in the db for upgrade purposes
$query = $db->setQuery("select count(*) from #__configurator where template_name = 'morph';");
$count_rows = $db->loadResult($query);

// check if a themelet is installed and if not set a cookie to hide the activation checkbox
$query = $db->setQuery("select param_value from #__configurator where param_name = 'themelet';");
$themelet_installed = $db->loadResult($query);
if(!$themelet_installed)
{
	ComConfiguratorHelperUtilities::setInstallState('themelet_installed', false);
}


//@TODO upgrade to the Model asap
// create a full system backup
$classname  = 'ComConfiguratorControllerDefault';
$controller = new $classname( );
$controller->create_db_backup('full-database');

// set cookie for configurator installer
ComConfiguratorHelperUtilities::setInstallState('installed_cfg', true);

// set permissions on templates, assets and components folder.
JPath::setPermissions(JPATH_ROOT.'/templates');
JPath::setPermissions(JPATH_ROOT.'/administrator/components');

// set gzip on/off based on browser
$conf = JFactory::getConfig();
if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')){
	if($conf->getValue('config.gzip') !== '1'){
		$path = JPATH_CONFIGURATION.'/configuration.php';
		JPath::setPermissions($path, '0777');
		if(file_exists($path) && is_writable($path)){			
			$str = file_get_contents($path);
			$line = str_replace('var $gzip = \'0\';', 'var $gzip = \'1\';', $str);
			file_put_contents($path, $line);
		}		
		JPath::setPermissions($path, '0644');
		ComConfiguratorHelperUtilities::setInstallState('installed_gzip', true);
	}
}else{
	setcookie('installed_no_gzip', 'true');
	ComConfiguratorHelperUtilities::setInstallState('installed_no_gzip', true);
}
?>
<div id="install-wrap">
	<div id="installer">
	<?php
	if(!isset($_REQUEST['install'])){
		if($count_rows > 0) :
			ComConfiguratorHelperUtilities::setInstallState('upgrade_cfg', true);
			include 'installer/step1_upgrade.php';
		else :
			include 'installer/step1.php';
		endif;
	}else{
		if($_REQUEST['install'] == 'step2'){
			include 'installer/step2.php';
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
<?php if(isset($error) && $error) include 'installer/error.php' ?>
<?php ob_end_flush(); ?>