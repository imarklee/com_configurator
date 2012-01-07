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
 * ComConfiguratorViewConfiguration
 *
 * Shows the main Configurator view
 *
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorViewConfiguration extends JView
{
	public function display()
	{
		//@TODO start changed by manoj
		/* global $mainframe; */ 
		$mainframe=JFactory::getApplication();
		//@TODO end changed by manoj
		$database = JFactory::getDBO();
		$option = JRequest::getVar('option');
		$template = 'morph';
		$cid = JRequest::getVar('cid',null,'request','array');
		if(is_array($cid)) {
			$template = $cid[0];
		}

		$morph_installed = JFolder::exists(JPath::clean( JPATH_ROOT.'/templates' ).'/'.$template);
		if ($morph_installed)
		{
			require_once JPATH_COMPONENT_ADMINISTRATOR.'/configurator.common.php';
			$preset_choice = JRequest::getVar('preset',null);
			$preset_values = null;

			$templateBaseDir = JPath::clean( JPATH_ROOT.'/templates' ).'/'.$template;
	
			$paramList = ComConfiguratorHelperUtilities::getTemplateParamList( $templateBaseDir.'/core/morphDetails.xml' );
	
				if ( $template ) {
					// do stuff for existing records
					// load existing settings for this template.
					$template_params = JTable::getInstance('ConfiguratorTemplateSettings', 'Table')->template($template)->getParams();
					$template_settings = array();
					
					// themelet
					
					$themelet = isset($template_params['themelet']) ? $template_params['themelet']['param_value'] : false;
					$themelet_xml_params = array();
					$themelet_path	= JPATH_ROOT.'/morph_assets/themelets/'.$themelet.'/themeletDetails.xml';
					if(file_exists($themelet_path)) $xml_param_loader = new morphXMLLoader($themelet_path);
					if(!empty($xml_param_loader)) {
						$themelet_xml_params = $xml_param_loader->getParamDefaults();	
						foreach($themelet_xml_params as $param_name => $param_value){
							if(!array_key_exists($param_name,$template_params)) $template_params[$param_name] = array('param_name' => $param_name, 'param_value' => $param_value);
						}
					} 
				
					foreach ( (array) $template_params as $template_param ) {
						$template_settings[$template_param['param_name']] = $template_param['param_value'];
					}
				} else {
					// do stuff for new records
					$row->published     =1;
					$row->date_submitted=date('Y-m-d H:i:s');
					$row->id            =0;
					$pics               =null;
				}
				
				if( count( $template_settings ) && empty($preset_choice) ) {
					// Got settings from the DB.
					$current_params = $template_settings;
				
				//@TODO check if we can get rid of the $preset_values leftovers from possibly tatami
				//} elseif( isset($preset_values) ) {
					// Got settings from the preset.
				//	$current_params = implode( "\n", $preset_values );
				} else {
					// Default empty.
					$current_params = $paramList;
				}
		
				// Create the morph params
				$params = new JParameter(null, $templateBaseDir.'/core/morphDetails.xml');        
				$params->bind($current_params);
				$params->name = $template;
				//$params->merge($themelet_params);

				$lists = array();
				
				// Load presets from XML file.
				$xml_param_loader = new morphXMLLoader($templateBaseDir.'/core/morphDetails.xml');
				$main_xml_params = $xml_param_loader->getParamDefaults();
							
				$params->use_favicons = $xml_param_loader->use_favicons;

				// Load list of themelets (if they exist).
				$themelet_dir = JPATH_SITE.'/morph_assets/themelets';          
	
				if(is_dir($themelet_dir)) $lists['themelets'] = JFolder::folders( $themelet_dir );
				else $lists['themelets'] = null;
				foreach ($lists['themelets'] as $themelet){
					// Create the morph params
					$themelet_params = $this->parsexml_themelet_file($themelet_dir.'/'.$themelet);
					$lists[$themelet] = $themelet_params;
				}
	
				$lists['themelets_dir'] = $themelet_dir;
				
				// Load list of logos (if they exist).
				$logo_dir = JPATH_SITE.'/morph_assets/logos';
				if(is_dir($logo_dir)) $lists['logos'] = JFolder::files( $logo_dir, '.jpg|.png|.gif' );
				else $lists['logos'] = null;
				$lists['logo_dir'] = $logo_dir;
				
				// Load list of backgrounds (if they exist).
				$bg_dir = JPATH_SITE.'/morph_assets/backgrounds';
				if(is_dir($bg_dir)) $lists['backgrounds'] = JFolder::files( $bg_dir, '.jpg|.png|.gif' );
				else $lists['backgrounds'] = null;
				$lists['bg_dir'] = $bg_dir;
				
				unset($xmlDoc);
			}
		// preferences variables
			$cfg_pref='';
			$pref_xml='';
			$query="SELECT * FROM #__configurator_preferences;";
			$database->setQuery( $query );
			$pref_params = $database->loadObjectList();
						
			$pref_list = ComConfiguratorHelperUtilities::getTemplateParamList( JPATH_COMPONENT_ADMINISTRATOR . '/includes/layout/preferences.xml', TRUE );
			foreach ($pref_list as $pref => $val) {
				$defpref_params[$pref] = $val;
			}
			
			// Replace default settings with any settings found in the DB.
			if($pref_params !== null) {
				foreach( (array) $pref_params as $param ) {
					$defpref_params[$param->pref_name] = $param->pref_value;
				}
			}
			// Create class members dynamically to be used by template.
			foreach( $defpref_params as $key => $value ) {
				$cfg_pref->$key = $value;
			}
			
			// preferences form
			$query="SELECT * FROM #__configurator_preferences";
			$database->setQuery( $query );
			$prefs_params = $database->loadAssocList('pref_name');
			$prefs_settings = array();
			$current_prefs = ''; 
			
			foreach ( (array) $prefs_params as $prefs_param ) {
				$prefs_settings[] = $prefs_param['pref_name'] . '=' . $prefs_param['pref_value'] . "\n";
			}
			if( count( $prefs_settings ) ) {
				 //Got settings from the DB.
				$current_prefs = implode( "\n", $prefs_settings );
			}
			
			$pref_xml = new JParameter($current_prefs, JPATH_COMPONENT_ADMINISTRATOR.'/includes/layout/preferences.xml');
			
			include_once(JPATH_COMPONENT_ADMINISTRATOR.'/includes/configurator.functions.php');
			
			$document 	= JFactory::getDocument();
			$option 	= JRequest::getVar('option','com_configurator');
			$task 		= JRequest::getCmd('task');
			
			 global $mainframe, $browser, $thebrowser, $browserver;
	        
	        $document 	= JFactory::getDocument();
	        $option 	= JRequest::getVar('option');
			// google chromeframe support to CFG.
			if($thebrowser == 'internet-explorer') $document->setMetaData('X-UA-Compatible', 'chrome=1', true);
			
			$conf = JFactory::getConfig();
			$lifetime = $conf->getValue('lifetime');
	
	        $csspath 	= JURI::root() . 'administrator/components/com_configurator/css/';
			$jspath 	= JURI::root() . 'administrator/components/com_configurator/js/';
			$browser 	= new MBrowser();
			$thebrowser	= str_replace(' ','-', strtolower($browser->getBrowser()));
			$browserver	= str_replace('.', '', substr($browser->getVersion(),0, 3));
			//@TODO start added by manoj
			//this is important for joomla 1.7
			JHTML::_('behavior.mootools');
			//@TODO end added by manoj
			if(!isset($_COOKIE['unpack'])){
				//$document->addScript($jspath . 'configurator.js.php?getul='.$uval.'&eh='.$cfg_pref->syntax_highlighting.'&sk='.$cfg_pref->session_keepalive.'&slt='.$lifetime);
				//$js = '&option='.JRequest::getCmd('option').'&task=manage&render=js&eh='.$cfg_pref->syntax_highlighting.'&sk='.$cfg_pref->session_keepalive.'&slt='.$lifetime.'&version='.ComConfiguratorDefines::getVersion();
				//$js = JRoute::_($js);
				//$document->addScript($js);
				$document->addScript($jspath . 'configurator.js.php?eh='.$cfg_pref->syntax_highlighting.'&sk='.$cfg_pref->session_keepalive.'&slt='.$lifetime.'&version='.ComConfiguratorDefines::getVersion());
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
				$document->addScript($jspath . 'accordion.js');
				$document->addScript($jspath . 'colorpicker.js');
				$document->addScript($jspath . 'form.js');
				$document->addScript($jspath . 'fileupload.js');
				$document->addScript($jspath . 'autoresize.js');
				$document->addScript($jspath . 'qtip.js');
				$document->addScript($jspath . 'getparams.js');
				$document->addScript($jspath . 'jsoncookie.js');
				$document->addScript($jspath . 'itoggle.js');
				//}
				$document->addScript($jspath . 'functions.js.php?eh='.$cfg_pref->syntax_highlighting.'&sk='.$cfg_pref->session_keepalive.'&slt='.$lifetime);
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
				$document->addStyleSheet($csspath . 'itoggle.css');
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
	        	setcookie('noshortkey', 'true', 0, '/');
	        }else{
	        	setcookie('noshortkey', '', time()-3600, '/');
	        }
	
	
			// toggle settings effect
	        if($cfg_pref->settings_effect == 'toggle'){
	        	setcookie('settings_effect', 'toggle', 0, '/');
	        }elseif($cfg_pref->settings_effect == 'accordion'){
	        	setcookie('settings_effect', 'accordion', 0, '/');
	        }else{
				setcookie('settings_effect', 'all', 0, '/');
			}
			
	        if (!$morph_installed){
		        echo '<div id="nomorph">';
		        echo '<h1>Morph needs to be installed in order to work.</h1>';	
		        echo '<p>Please <a href="index.php?option=com_installer">install Morph</a> then reload this page.</p>';	
		        echo '</div>';	
		        //if found morph	
	        } else {	
		        $template_dir = JPATH_SITE.'/templates/morph';
		        $jVer 		= new JVersion();
				$jVer_curr  = $jVer->RELEASE.'.'.$jVer->DEV_LEVEL;
		        ?>			
		        <div id="browser-wrap" class="<?php echo $thebrowser . ' ' . $thebrowser.$browserver; ?>">
				<?php
			  	
				// Show a specific template in editable mode.
		        if(isset($lists['err_messages'])) echo count($lists['err_messages'])?'<span style="color:#fff;background-color:#FF0000;font-weight:bold;">'.implode(',', $lists['err_messages']).'</span>':'';
				
				// auto updates
		        if($cfg_pref->check_updates == 0){
		        	setcookie('noupdates', 'true', time()+60*60*24*365, '/');
		        }else{
		        	setcookie('noupdates', 'true', time()+3600, '/');
		        }
				
				if(function_exists('ini_set')){ ini_set('memory_limit', '32M'); 
				}else{
					$mem_limit = ini_get('memory_limit');
					if(str_replace('M', '', $mem_limit) < 32) echo $this->show_error('We are unable to adjust your memory limit.'.
					'Your current memory limit is '.$mem_limit.', which is less than what is required for optimal performance.'.
					'<a href="#" id="readmore-memory">click here</a> to find out more.', 'notice', 'memory');
				}
				
				include JPATH_COMPONENT_ADMINISTRATOR.'/includes/layout/manage.php';
				?>
				</div>
				<?php include JPATH_COMPONENT_ADMINISTRATOR.'/includes/layout/report-bug.php';
		 	}
	}
	
	/**
	 * Temporary solution for controller code
	 *
	 */
	public function __call($name, $arguments)
	{
		return call_user_func_array(array('ComConfiguratorControllerAbstract', $name), $arguments);
	}
}
