<?php
defined('_JEXEC') or die('Restricted access');
include_once(JPATH_COMPONENT_ADMINISTRATOR . DS . 'includes' . DS .'HTML_configuratorhelper_admin.php');
include_once(JPATH_COMPONENT_ADMINISTRATOR . DS . 'includes' . DS . 'configurator.functions.php');

$document 	=& JFactory::getDocument();
$option 	= JRequest::getVar('option','com_configurator');
$task 		= JRequest::getCmd('task');
$csspath 	= JURI::root() . 'administrator/components/com_configurator/css/';
$jspath 	= JURI::root() . 'administrator/components/com_configurator/js/';

if(!isset($_COOKIE['unpack'])){
	$document->addScript($jspath . 'configurator.js.php');
	$document->addStyleSheet($csspath . 'configurator.css.php');
} else {
	/* unpacked js
	*****************************************/
	// global
	$document->addScript($jspath . 'jquery.js');
	$document->addScript($jspath . 'ui.js');
	$document->addScript($jspath . 'cookie.js');
	$document->addScript($jspath . 'preload.js');
	$document->addScript($jspath . 'browser.js');
	$document->addScript($jspath . 'corners.js');
	$document->addScript($jspath . 'functions.js.php');
	if(!isset($_COOKIE['am_logged_in']) && !isset($_COOKIE['am_logged_in_user'])){
	// login
	$document->addScript($jspath . 'showpassword.js');
	} else {
	// manage
	$document->addScript($jspath . 'colorpicker.js');
	$document->addScript($jspath . 'form.js');
	$document->addScript($jspath . 'fileupload.js');
	$document->addScript($jspath . 'autoresize.js');
	$document->addScript($jspath . 'qtip.js');
	$document->addScript($jspath . 'getparams.js');
	}
	/* unpacked css
	*****************************************/
	// global
	$document->addStyleSheet($csspath . 'reset.css');
	$document->addStyleSheet($csspath . '960.css');
	$document->addStyleSheet($csspath . 'ui.css');
	$document->addStyleSheet($csspath . 'text.css');
	$document->addStyleSheet($csspath . 'overlay.css');
	$document->addStyleSheet($csspath . 'sprite.css');
	// dashboard
	// $document->addStyleSheet($csspath . 'dashboard/dashboard.css');
	if(!isset($_COOKIE['am_logged_in']) && !isset($_COOKIE['am_logged_in_user'])){
	// login
	$document->addStyleSheet($csspath . 'login.css');
	} else {
	// manage
	$document->addStyleSheet($csspath . 'assets.css');
	$document->addStyleSheet($csspath . 'colorpicker.css');
	$document->addStyleSheet($csspath . 'docs.css');
	$document->addStyleSheet($csspath . 'feedback.css');
	$document->addStyleSheet($csspath . 'footer.css');
	$document->addStyleSheet($csspath . 'forms.css');
	$document->addStyleSheet($csspath . 'fullscreen.css');
	$document->addStyleSheet($csspath . 'help.css');
	$document->addStyleSheet($csspath . 'keyboard.css');
	$document->addStyleSheet($csspath . 'manage.css');
	$document->addStyleSheet($csspath . 'preferences.css');
	$document->addStyleSheet($csspath . 'shelf.css');
	$document->addStyleSheet($csspath . 'tabs.css');
	$document->addStyleSheet($csspath . 'tips.css');
	$document->addStyleSheet($csspath . 'tooltips.css');
	$document->addStyleSheet($csspath . 'toplinks.css');
	$document->addStyleSheet($csspath . 'uploader.css');
	$document->addStyleSheet($csspath . 'welcome.css');
	}
}

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
	        echo '<div id="nomorph">';
	        echo '<h1>Morph needs to be installed in order to work.</h1>';	
	        echo '<p>Please <a href="index.php?option=com_installer">install Morph</a> then reload this page.</p>';	
	        echo '</div>';	
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
			include 'includes/layout/report-bug.php';
	 	}      
    }
    function dashboard() {
        HTML_configuratorhelper_admin::showDash();
    }
}
?>