<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2009 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined('_JEXEC') or die('Restricted access');
include_once(JPATH_COMPONENT_ADMINISTRATOR .DS. 'includes' .DS.'HTML_configuratorhelper_admin.php');
include_once(JPATH_COMPONENT_ADMINISTRATOR .DS. 'includes' .DS. 'configurator.functions.php');
if(file_exists(JPATH_ROOT .DS. 'templates'.DS.'morph'.DS.'core'.DS.'browser.php')){
include_once(JPATH_ROOT .DS. 'templates'.DS.'morph'.DS.'core'.DS.'browser.php');
}
$document 	= JFactory::getDocument();
$option 	= JRequest::getVar('option','com_configurator');
$task 		= JRequest::getCmd('task');

class HTML_configurator_admin {
	function manage( $params, $lists, $morph_installed, $pref_xml, $cfg_pref ) {
        global $mainframe, $browser, $thebrowser, $browserver;
        include_once (JPATH_COMPONENT_ADMINISTRATOR .DS. "configuration.php");
        
        $document 	= JFactory::getDocument();
        $option 	= JRequest::getVar('option');
		// google chromeframe support to CFG.
		if($thebrowser == 'internet-explorer') $document->setMetaData('X-UA-Compatible', 'chrome=1', true);
		
        $csspath 	= JURI::root() . 'administrator'.DS.'components'.DS.'com_configurator'.DS.'css'.DS;
		$jspath 	= JURI::root() . 'administrator'.DS.'components'.DS.'com_configurator'.DS.'js'.DS;
		$browser 	= new Browser();
		$thebrowser	= str_replace(' ','-', strtolower($browser->getBrowser()));
		$browserver	= str_replace('.', '', substr($browser->getVersion(),0, 3));
		
		($this->checkUser()) ? $uval = 1 : $uval = 0;
		
		if(!isset($_COOKIE['unpack'])){
			$document->addScript($jspath . 'configurator.js.php?getul='.$uval.'&eh='.$cfg_pref->syntax_highlighting);
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
			//if(!isset($_COOKIE['am_logged_in']) && !isset($_COOKIE['am_logged_in_user'])){
			// login
			$document->addScript($jspath . 'showpassword.js');
			//} else {
			// manage
			$document->addScript($jspath . 'accordion.js');
			$document->addScript($jspath . 'colorpicker.js');
			$document->addScript($jspath . 'form.js');
			$document->addScript($jspath . 'fileupload.js');
			$document->addScript($jspath . 'autoresize.js');
			$document->addScript($jspath . 'qtip.js');
			$document->addScript($jspath . 'getparams.js');
			$document->addScript($jspath . 'jsoncookie.js');
			//}
			$document->addScript($jspath . 'functions.js.php?getul='.$uval.'&eh='.$cfg_pref->syntax_highlighting);
			/* unpacked css
			*****************************************/
			// global
			$document->addStyleSheet($csspath . 'reset.css');
			$document->addStyleSheet($csspath . '960.css');
			$document->addStyleSheet($csspath . 'ui.css');
			$document->addStyleSheet($csspath . 'text.css');
			$document->addStyleSheet($csspath . 'overlay.css');
			$document->addStyleSheet($csspath . 'sprite.css');
			$document->addStyleSheet($csspath . 'manage.css');
			$document->addStyleSheet($csspath . 'toplinks.css');
			$document->addStyleSheet($csspath . 'feedback.css');
					
			// dashboard
			// $document->addStyleSheet($csspath . 'dashboard/dashboard.css');
			//if(!isset($_COOKIE['am_logged_in']) && !isset($_COOKIE['am_logged_in_user'])){
			// login
			$document->addStyleSheet($csspath . 'login.css');
			//} else {
			// manage
			$document->addStyleSheet($csspath . 'welcome.css');
			$document->addStyleSheet($csspath . 'assets.css');
			$document->addStyleSheet($csspath . 'tabs.css');
			$document->addStyleSheet($csspath . 'accordion.css');
			$document->addStyleSheet($csspath . 'tips.css');
			$document->addStyleSheet($csspath . 'shelf.css');
			$document->addStyleSheet($csspath . 'forms.css');
			$document->addStyleSheet($csspath . 'footer.css');
			$document->addStyleSheet($csspath . 'help.css');
			$document->addStyleSheet($csspath . 'keyboard.css');
			$document->addStyleSheet($csspath . 'preferences.css');
			$document->addStyleSheet($csspath . 'tooltips.css');
			$document->addStyleSheet($csspath . 'tools.css');
			$document->addStyleSheet($csspath . 'colorpicker.css');
			$document->addStyleSheet($csspath . 'docs.css');
			$document->addStyleSheet($csspath . 'fullscreen.css');
			$document->addStyleSheet($csspath . 'editor.css');
			//}
			
			// browser stylesheets
			switch($thebrowser){
				case 'safari': $document->addStyleSheet($csspath . 'safari.css'); break;
				case 'chrome': $document->addStyleSheet($csspath . 'chrome.css'); break;
				case 'internet-explorer': $document->addStyleSheet($csspath . 'ie.css');break;
				case 'opera': $document->addStyleSheet($csspath . 'opera.css'); break;
				case 'firefox': $document->addStyleSheet($csspath . 'firefox.css'); break;
			}
			
			// gcf and webkit support
			if(preg_match('/chromeframe/i', $_SERVER['HTTP_USER_AGENT'])) $document->addStyleSheet($csspath . 'safari.css');
		}
        
        // keyboard shortcuts
        if($cfg_pref->short_keys == 0){
        	setcookie('noshortkey', 'true');
        }else{
        	setcookie('noshortkey', '', time()-3600);
        }


		// toggle settings effect
        if($cfg_pref->settings_effect == 'toggle'){
        	setcookie('settings_effect', 'toggle');
        }elseif($cfg_pref->settings_effect == 'accordion'){
        	setcookie('settings_effect', 'accordion');
        }else{
			setcookie('settings_effect', 'all');
		}
		
        if (!$morph_installed){
	        echo '<div id="nomorph">';
	        echo '<h1>Morph needs to be installed in order to work.</h1>';	
	        echo '<p>Please <a href="index.php?option=com_installer">install Morph</a> then reload this page.</p>';	
	        echo '</div>';	
	        //if found morph	
        } else {	
	        $template_dir = JPATH_SITE .DS. 'templates' .DS. 'morph';
	        $jVer 		= new JVersion();
			$jVer_curr  = $jVer->RELEASE.'.'.$jVer->DEV_LEVEL;
	        ?>			
	        <div id="browser-wrap" class="<?php echo $thebrowser . ' ' . $thebrowser.$browserver; ?>">
			<?php
		  	
			// Show a specific template in editable mode.
	        if(isset($lists['err_messages'])) echo count($lists['err_messages'])?'<span style="color:#fff;background-color:#FF0000;font-weight:bold;">'.implode(',', $lists['err_messages']).'</span>':''; ?>			
			<?php if(!$this->checkUser()){
				include 'includes'.DS.'layout'.DS.'login.php';
	        } else {
				$user = $this->getuserdetails();
	        	// auto updates
		        if($cfg_pref->check_updates == 0){
		        	setcookie('noupdates', 'true', time()+60*60*24*365);
		        }else{
		        	setcookie('noupdates', 'true', time()+3600);
		        }
				
				if(function_exists('ini_set')){ ini_set('memory_limit', '32M'); 
				}else{
					$mem_limit = ini_get('memory_limit');
					if(str_replace('M', '', $mem_limit) < 32) echo $this->show_error('We are unable to adjust your memory limit.'.
					'Your current memory limit is '.$mem_limit.', which is less than what is required for optimal performance.'.
					'<a href="#" id="readmore-memory">click here</a> to find out more.', 'notice', 'memory');
				}
				
				include 'includes'.DS.'layout'.DS.'manage.php';
			} ?>
			</div>
			<?php include 'includes'.DS.'layout'.DS.'report-bug.php';
	 	}      
    }
    function dashboard() {
        HTML_configuratorhelper_admin::showDash();
    }
	function help() {
		include_once (JPATH_COMPONENT_ADMINISTRATOR .DS. "configuration.php");
        $document 	= JFactory::getDocument();
        $option 	= JRequest::getVar('option');
        $csspath 	= JURI::root() . 'administrator'.DS.'components'.DS.'com_configurator'.DS.'css'.DS;
		$jspath 	= JURI::root() . 'administrator'.DS.'components'.DS.'com_configurator'.DS.'js'.DS;
        //$document->addScript($jspath . 'jquery.js');
        //$document->addScript($jspath . 'livedocs.js');
		
		$document->addStyleSheet($csspath . 'toplinks.css');
		$document->addStyleSheet($csspath . 'help-docs.css');

		include 'includes'.DS.'layout'.DS.'livedocs.php';
    }
}
?>