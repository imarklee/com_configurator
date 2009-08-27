<?php
defined('_JEXEC') or die('Restricted access');
include_once(JPATH_COMPONENT_ADMINISTRATOR . DS . 'includes' . DS .'HTML_configuratorhelper_admin.php');
include_once(JPATH_COMPONENT_ADMINISTRATOR . DS . 'includes' . DS . 'configurator.functions.php');

$document 	=& JFactory::getDocument();
$option 	= JRequest::getVar('option','com_configurator');
$task 		= JRequest::getCmd('task');

if(!isset($_COOKIE['unpack'])){
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/configurator.js.php');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/configurator.css.php');
}else{
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery-1.3.2.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery-ui-1.7.2.custom.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/cookie.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/preloadCssImages.jQuery_v5.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/colorpicker.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jqbrowser.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.corners.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.filestyle.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.qtip-1.0.0-rc3.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.fileupload.js');$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.autoresize.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.form.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.showpassword.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.getparams.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/configurator.functions.js.php');

$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/jquery.ui.css');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/colorpicker.css');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/reset.css');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/text.css');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/960.css');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/manage.css');
}

?>
<?php
class HTML_configurator_admin {

function manage( &$params, &$lists, $morph_installed, $pref_xml, $cfg_pref ) {
        global $mainframe;
        include_once (JPATH_COMPONENT_ADMINISTRATOR . DS . "configuration.php");
        $option = JRequest::getVar('option');
        
        JToolBarHelper::title( 'Configurator', 'configurator' );
        
        // preference cookies
        // auto updates
        if($cfg_pref->check_updates == 0 && !isset($_COOKIE['noupdates'])){
        	setcookie('noupdates', 'true');
        }else{
        	setcookie('noupdates', '', time()-3600);
        }
        // keyboard shortcuts
        if($cfg_pref->short_keys == 0 && !isset($_COOKIE['noshortkeys'])){
        	setcookie('noshortkey', 'true');
        }else{
        	setcookie('noshortkey', '', time()-3600);
        }
        
        if (!$morph_installed){
	        echo '<center>';
	        echo '<h1>Morph needs to be installed in order to work.</h1>';	
	        echo '<h3>Please, <a href="index.php?option=com_installer">Morph</a> before continue...</h3>';	
	        echo '</center>';	
	        //if found morph	
        } else {	
	        $template_dir = JPATH_SITE . DS . 'templates' . DS . 'morph';
	        $jVer 		= new JVersion();
			$jVer_curr  = $jVer->RELEASE.'.'.$jVer->DEV_LEVEL;
	        
	        // Show a specific template in editable mode.
	        if(isset($lists['err_messages'])) echo count($lists['err_messages'])?'<span style="color:#fff;background-color:#FF0000;font-weight:bold;">'.implode(',', $lists['err_messages']).'</span>':''; ?>
			
			<?php if(!isset($_COOKIE['am_logged_in']) && !isset($_COOKIE['am_logged_in_user'])){
				include 'includes/layout/login.php';
	        } else {
				include 'includes/layout/manage.php';
			}
			?>
			<?php include 'includes/layout/report-bug.php';
	 	}      
    }
    function dashboard() {
        HTML_configuratorhelper_admin::showDash();
    }
}
?>