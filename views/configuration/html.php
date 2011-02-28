<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

/**
 * ComConfiguratorViewConfiguration
 *
 * Shows the main Configurator view
 *
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorViewConfigurationHtml extends ComDefaultViewHtml
{
	/**
	 * Constructor
	 *
	 * @param 	object 	An optional KConfig object with configuration options
	 */
	public function __construct(KConfig $config)
	{
		parent::__construct($config);
		
		//Add paths
		$this->getTemplate()
							->addPath(JPATH_COMPONENT.'/includes/blocks')
							->addPath(JPATH_COMPONENT.'/includes/customize')
							->addPath(JPATH_COMPONENT.'/includes/general')
							->addPath(JPATH_COMPONENT.'/includes/help')
							->addPath(JPATH_COMPONENT.'/includes/layout')
							->addPath(JPATH_COMPONENT.'/includes/plugins')
							->addPath(JPATH_COMPONENT.'/includes/tools');
		
		$this->setLayout('manage');
		
	    //Add alias filter for @params helper
		KFactory::get($this->getTemplate())->getFilter('alias')->append(array(
			'@params(array(' => '$this->loadHelper(\'admin::com.configurator.helper.html.params\', array(\'params\' => $params, ',
			'@tabs(' => '$this->getView()->createTabs('
		), KTemplateFilter::MODE_READ);
	}

	public function display()
	{
		$buttons = array(
			array('apply', 'Save'),
			array('fullscreen', 'Fullscreen'),
			array('preferences', 'Preferences&nbsp;'),
			array('report-bug-link', 'Feedback'),
			array('credits-link', 'Credits'),
			array('help-link', 'Help', JRoute::_('?option=com_configurator&view=help'))
		);
		
		$toolbar =	KFactory::get($this->getToolbar())
						->reset()
						->setTitle('Configurator > <span>Manage</span>')
						->setIcon('configurator');
		foreach($buttons as $button)
		{
			$toolbar->append(KFactory::get('admin::com.configurator.toolbar.button.'.$button[0], array(
				'text' => $button[1],
				'link' => isset($button[2]) ? $button[2] : false
			)));
		}

		$database = JFactory::getDBO();
		$template = 'morph';

		$morph_installed = JFolder::exists(JPATH_ROOT.'/templates/'.$template);
		if ($morph_installed)
		{
			$configuration = $this->getModel()->getList();
			$template_settings = array();
			
			// themelet
			$themelet_xml_params = array();
			$themelet_path	= JPATH_ROOT.'/morph_assets/themelets/'.$configuration->themelet.'/themeletDetails.xml';
			if(file_exists($themelet_path)) $xml_param_loader = new ComConfiguratorHelperParamLoader($themelet_path);
			if(!empty($xml_param_loader))
			{
				$themelet_xml_params = $xml_param_loader->getParamDefaults();	
				foreach($themelet_xml_params as $param_name => $param_value)
				{
					if(!isset($configuration->$param_name)) $template_settings[$param_name] = $param_value;
				}
			} 
			
			foreach($configuration as $param)
			{
				$template_settings[$param->name] = $param->value;
			}
	
			// Create the morph params
			$templateBaseDir = JPath::clean( JPATH_ROOT.'/templates' ).'/'.$template;
			$params = new JParameter(null, $templateBaseDir.'/core/morphDetails.xml'); 
			if($template_settings) $params->bind($template_settings);      
			$params->name = $template;
			//$params->merge($themelet_params);
			
			//@TODO look into if we really need to do this.
			//We used to call an entire xml parser just to get this value, which is for some reason used
			//to set use_favicons to true
			$params->use_favicons = true;
		}
		// preferences variables
		$cfg_pref='';
		$pref_xml='';
		$query="SELECT * FROM #__configurator_preferences;";
		$database->setQuery( $query );
		$pref_params = $database->loadObjectList();
					
		$pref_list = KFactory::get('admin::com.configurator.helper.utilities')->getTemplateParamList( JPATH_COMPONENT_ADMINISTRATOR . '/includes/layout/preferences.xml', TRUE );
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
		
		$document 	= JFactory::getDocument();
        			
		$conf = JFactory::getConfig();
		$lifetime = $conf->getValue('lifetime');

        $csspath 	= JURI::root() . 'administrator/components/com_configurator/css/';
		$jspath 	= JURI::root() . 'administrator/components/com_configurator/js/';
		$browser 	= new MBrowser();
		//@TODO see if we can use the inflector here
		$browser	= (object) array(
			'name'		=> str_replace(' ','-', strtolower($browser->getBrowser())),
			'version'	=> str_replace('.', '', substr($browser->getVersion(),0, 3))
		);
		$this->assign('browser', $browser);
		
		// google chromeframe support to CFG.
		if($this->browser->name == 'internet-explorer') $document->setMetaData('X-UA-Compatible', 'chrome=1', true);


		// Check if the user have authenticated
		$this->checkuser = (bool) KFactory::get('admin::com.configurator.model.users')->getTotal();
		if(!isset($_COOKIE['unpack'])){
			//$js = '&option='.JRequest::getCmd('option').'&render=js&getul='.(int)$this->checkuser.'&eh='.$cfg_pref->syntax_highlighting.'&sk='.$cfg_pref->session_keepalive.'&slt='.$lifetime.'&version='.KFactory::get('admin::com.configurator.defines')->getVersion();
			//$js = JRoute::_($js);
			//$document->addScript($js);
			//$css = JRoute::_('&option='.JRequest::getCmd('option').'&render=css');
			$document->addScript($jspath . 'configurator.js.php?eh='.$cfg_pref->syntax_highlighting.'&sk='.$cfg_pref->session_keepalive.'&slt='.$lifetime.'&version='.KFactory::get('admin::com.configurator.defines')->getVersion().'&r='.rand());
			$document->addStyleSheet($csspath . 'configurator.css.php');
		} else {
			/* unpacked js
			*****************************************/
			$scripts = array(
				'jquery.js',
				'ui.js',
				'cookie.js',
				'preload.js',
				'browser.js',
				'showpassword.js',
				'accordion.js',
				'colorpicker.js',
				'form.js',
				'fileupload.js',
				'autoresize.js',
				'qtip.js',
				'getparams.js',
				'jsoncookie.js',
				'itoggle.js',
				'functions.js.php?getul='.(int)$this->checkuser.'&eh='.$cfg_pref->syntax_highlighting.'&sk='.$cfg_pref->session_keepalive.'&slt='.$lifetime
			);
			foreach($scripts as $script)
			{
				$document->addScript($jspath.$script);
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
			$document->addStyleSheet($csspath . 'manage.css');
			$document->addStyleSheet($csspath . 'toplinks.css');
			$document->addStyleSheet($csspath . 'feedback.css');
					
			$document->addStyleSheet($csspath . 'login.css');
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
			switch($browser->name){
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
		
		
		$descriptions	= array(
			'site'	=> array(
				'title'	=> 'About the general settings tab',
				'text'	=> 'The options in the general settings tab are those which are specific to your site 
				and will not change when you assign a new themelet. We have tried to make the options as easy to understand 
				as possible, but if there is anything that you think could be improved, please be sure to let us know.'
			),
			'themelet'	=> array(
				'title'	=> 'About the themelet settings tab',
				'text'	=> 'Themelets (otherwise known as "child themes" take care of the visual aspect of your 
				website and run off Morphs core template framework. These settings will change depending on which 
				themelet is currently published.'
			),
			'blocks'	=> array(
				'title'	=> 'About the block settings tab',
				'text'	=> 'Think of blocks as the lego pieces that make up your website. Each one of the different blocks can be configured 
				to work in a multitude of ways. These settings will change depending on which themelet is currently published.'
			),
			'plugins'	=> array(
				'title'	=> 'About the plugins tab',
				'text'	=> 'The plugins tab will provide you with an interface to manage the various jQuery plugins that we have integrated with Morph.'
			),
			'tools'	=> array(
				'title'	=> 'About the tools tab',
				'text'	=> 'These tools are aimed at making your life easier. Whether its installing a new themelet, upgrading
				your version of Morph, uploading media, managing your database backups - we have you covered. If you have any suggestions
				for any other tools or just ways we can improve the existing ones, please <a href="#" class="report-bug" title="click here to open the 
				feedback form!">let us know</a>!'
			),
			'assets'	=> array(
				'title'	=> 'About the assets tab',
				'text'	=> 'Assets are the digital media files that are specific to your website and 
				are stored in a folder called "<strong>morph_assets</strong>", which is stored 
				in your Joomla! site root. Having your assets located outside of your template means you can 
				upgrade Morph without losing your custom backgrounds, logos, themelets and backups.'
			)
		);
		
		$overlays = new KObject;
		foreach($descriptions as $name => $parts)
		{
			$overlays->$name = $cfg_pref->show_intros && !KRequest::has('cookie.'.$name.'-desc')
				? $this->getTemplate()->loadIdentifier('admin::com.configurator.view.configuration.default_desc', array(
					'name'	=> $name,
					'title' => $parts['title'],
					'text'	=> $parts['text']
				))->render(true)
				: false;
		}
		
		$this->assign(array(
			'cfg_pref'	=> $cfg_pref,
			'params'	=> $params,
			'pref_xml'	=> $pref_xml,
			'overlays'	=> $overlays
		));
		
        if (!$morph_installed){
	        $this->setLayout('default_nomorph');

	        return parent::display();
	        //if found morph	
        } else {
        	$this->setLayout('manage');

	        return parent::display();
	 	}
	}

	public function createTabs($name, $template_path, array $tabs, $overlay = null)
	{
		$data = array_merge($this->_data, array(
			'name'	=> $name,
			'template_path' => $template_path,
			'tabs'	=> $tabs,
			'overlay' => $overlay !== null ? $overlay : $this->overlays->$name
		)); 
	
		return $this->getTemplate()->loadIdentifier('admin::com.configurator.view.configuration.default_tabs', $data)->render(true);
	}
}