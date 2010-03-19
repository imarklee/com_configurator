<?php
/**
* @package   Morph Template
* @category  Morph Cache
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2009 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');

/**
 */
class plgSystemMorphCache extends JPlugin
{
	/**
	 * Catch the routed functions for 
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);

		$this->option = JRequest::getCmd('option');
		$isConfigurator = $this->option  == 'com_configurator' && $render = JRequest::getCmd('render', false);
		if($isConfigurator) return $this->configurator($render);
		
		$this->format = $format = JRequest::getCmd('render', false);
		$gzip   = JRequest::getBool('gzip', false);
					
		$view = 'render'.ucfirst($format);
		if(!method_exists($this, $view)) return;
		
		
		
		if ($gzip) {
			if(extension_loaded('zlib') && !ini_get('zlib.output_compression')){
				if(!ob_start("ob_gzhandler")) ob_start();
			}else{
				ob_start();
			}
			header("cache-control: must-revalidate");
			$offset = 60 * 10000;
			$expire = "expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
			header($expire);
		}else{
			ob_start();
		}
		if($format == 'css')	 header('Content-Type: text/css; charset=UTF-8');
		else if($format == 'js') header('Content-Type: text/javascript; charset=UTF-8');
		
		
		$cache = JRequest::getInt('cache', false);
		if ($cache)
		{	

			jimport('joomla.filesystem.file');
			
			$uri = JFactory::getURI();
			$itemid = isset($_SESSION['menuid']) ? $_SESSION['menuid'] : 0;
			$user   = JFactory::getUser();
			$path = JPATH_CACHE.'/morph/'.$uri->getHost().implode('.', explode('/', $uri->getPath())).'.'.(int)$itemid.'.'.$user->gid.'.'.$format;
			if(file_exists($path))
			{
				$created	= time()-date('U', filemtime($path));
				$expire		= $cache * 60;
				if($created > $expire)
				{
					$this->$format = $this->setConfigurations();
					$this->$view();
					$this->debug();
					$content = ob_get_flush();
					JFile::write($path, $content);
					return $this->close();
				}
				else
				{
					if(file_exists($path)) echo file_get_contents($path);
					
					ob_end_flush();
					return $this->close();	
				}
			}
			else
			{
				$this->$format = $this->setConfigurations();
				$this->$view();
				$this->debug();
				$content = ob_get_flush();
				JFile::write($path, $content);
				return $this->close();
			}
		} else {
			$this->$format = $this->setConfigurations();
			$this->$view();
			$this->debug();
			
			//ob_end_flush();
			return $this->close();	
			
		}
		
		///ob_get_length add way to serious overhead, we can't use it before we got clever caching
		//header("Content-Length: ".ob_get_length());
		
		
		return $this;
	}
	
	public function onAfterInitialise()
	{
		$app = JFactory::getApplication();
		if($app->getTemplate() == 'morph') define('MORPH_JQUERY', 1);
	
		// Prepare Morph if needed
		$this->morph();
	}
	
	public function morph()
	{
		$app = JFactory::getApplication();
		if($app->getTemplate() != 'morph' && $app->isSite()) return;
		
		$document			= JFactory::getDocument();
		$document->template	= $app->getTemplate();
		$document->baseurl	= JURI::base(1);
		
		$loader = JPATH_ROOT . '/templates/morph/core/morphLoader.php';
		if(file_exists($loader)) require_once $loader;
		else return;
		// If we are in configurator, make sure to update the overrides.
		// @TODO we might not want to run this on every pageload in configurator.
		if(!class_exists('Morph')) return;
		if(JRequest::getCmd('option') == 'com_configurator' || JRequest::getBool('create_overrides')) Morph::createOverrides();
	}
	
	protected function configurator($render)
	{
		$file = JPATH_ADMINISTRATOR.'/components/'.$this->option.'/'.$render.'/configurator.'.$render.'.php';
		if(file_exists($file)) include $file;
		$this->close();
	}
	
	protected function close()
	{
		$app = JFactory::getApplication();
		$app->close();
		
		return;
	}
	
	public function debug()
	{
		$html = array();
		$conf = JFactory::getConfig();
		if($conf->getValue('config.debug'))
		{
			global $_PROFILER;
			$profiler	= $_PROFILER;
			$html[] = PHP_EOL.'/* @group '.JText::_( $this->format.' Profile Information' ).PHP_EOL;
			foreach ( $profiler->getBuffer() as $mark ) {
				$html[] = PHP_EOL.$mark.PHP_EOL;
			}
			$html[] = PHP_EOL.' @end */'.PHP_EOL;
	
			$html[] = PHP_EOL.'/* @group '.JText::_( $this->format.' Memory Usage' ).PHP_EOL;
			$html[] = $profiler->getMemory();
			$html[] = PHP_EOL.' @end */'.PHP_EOL;
		}
		return implode($html);
	}
	
	public function renderJs()
	{
		if($minify = $this->js->pack_js && $this->js->minify_js) ob_start();
		
		if($this->js->pack_js)
		{
			foreach($this->js->scripts as $js => $type)
			{
				if(!file_exists(JPATH_ROOT.$js)) continue;
				echo file_get_contents(JPATH_ROOT.$js);
			}
		}
		
		include JPATH_THEMES.'/morph/core/js/template.js.php';

		if($minify) echo $this->minifyJs(ob_get_clean());
	}
	
	protected function minifyJs($js)
	{
		include_once JPATH_THEMES.'/morph/core/JSMin.php';
		return JSMin::minify($js);
	}
	
	public function renderCss()
	{
		if($minify = $this->css->pack_css && $this->css->minify_css) ob_start();
		if($this->css->pack_css)
		{
			foreach($this->css->styleSheets as $css => $type)
			{
				if(!file_exists(JPATH_ROOT.$css)) continue;
				echo PHP_EOL.' /* @group '.basename($css).' */ '.PHP_EOL;
				echo str_replace(array('../../../../', '../images/'), array(JURI::root(1).'/', JURI::root(1).'/templates/morph/core/images/'), file_get_contents(JPATH_ROOT.$css));
				echo PHP_EOL.' /* @end */ '.PHP_EOL;
			}
		}
		include JPATH_THEMES.'/morph/core/css/template.css.php';

		if($this->css->custom_css)
		{
			echo PHP_EOL.'/* @group Custom Themelet CSS */'.PHP_EOL;
			echo $this->css->custom_css;
			echo PHP_EOL.' /* @end */ '.PHP_EOL;
		}
		if($this->css->pack_css)
		{
			foreach($this->css->styleSheetsAfter as $css => $type)
			{
				if(!file_exists(JPATH_ROOT.$css)) continue;
				echo PHP_EOL.' /* @group '.basename($css).' */ '.PHP_EOL;
				echo str_replace(array('../../../../', '../images/'), array(JURI::root(1).'/', JURI::root(1).'/templates/morph/core/images/'), file_get_contents(JPATH_ROOT.$css));
				echo PHP_EOL.' /* @end */ '.PHP_EOL;
			}
		}
		if($minify) echo $this->minifyCss(ob_get_clean());
	}
	
	protected function minifyCss($css)
	{
		include_once JPATH_THEMES.'/morph/core/Compressor.php';
		return Minify_CSS_Compressor::process($css);
	}
	
	public function setConfigurations()
	{
		jimport('joomla.application.module.helper');
		JLoader::import('templates.morph.core.browser', JPATH_ROOT);
		
		$data = (object) $this->loadMorph();

		$browser 					= new MBrowser();
		$data->browser 				= strtolower(preg_replace("/[^A-Za-z]/i", "", $browser->getBrowser()));
		
		$document = JFactory::getDocument();
		$data->direction = $document->direction;
		
		$data->count_left = count(JModuleHelper::getModules('left'));
	
		$rootpath		= JPATH_THEMES.'/morph/core';
		$assetspath		= JURI::root(1).'/morph_assets';
		$assetsroot		= JPATH_ROOT.'/morph_assets';
		$data->csspath		= $rootpath.'/css';
		$data->jspath			= $rootpath.'/js';
		$data->path = JPATH_ROOT.'/morph_assets/themelets/'.$data->themelet;
	
		if ( $data->logo_type == 1 or $data->logo_type == 2 ) {
			if( preg_match('/MSIE 6/i', $_SERVER['HTTP_USER_AGENT']) && $data->logo_image_ie !== ''){ 
				$data->logo = $assetspath.'/logos/'.$data->logo_image_ie; 
				if($data->logo_autodimensions == 1) {
					$data->logo_size = getimagesize($assetsroot.'/logos/'.$data->logo_image_ie);
				}else{
					$data->logo_size[0] = $data->logo_width;
					$data->logo_size[1] = $data->logo_height;
				}	
			} else{ 
				$data->logo = $assetspath.'/logos/'.$data->logo_image; 
				if($data->logo_autodimensions == 1) {
					$data->logo_size = getimagesize($assetsroot.'/logos/'.$data->logo_image);
				}else{
					$data->logo_size[0] = $data->logo_width;
					$data->logo_size[1] = $data->logo_height;
				}
			}
		} else {
			$data->logo_size[0] = 'null';
			$data->logo_size[1] = 'null';
			$data->logo = 'null';
		}
		
		$db=& JFactory::getDBO();
		
		
		//Let's try and use session variables instead of repeated db queries
		$counts = array('tabscount', 'accordionscount', 'roundedcount', 'topdrop', 'topfish', 'subtext', 'animate_top', 'sidefish', 'sidenav_count', 'topnav_count', 'simpleticker', 'simpletweet', 'simplecontact', 'simplesocial');
		foreach($counts as $count)
		{
			$data->$count = $_SESSION[$count];
		}
		
		$query = "SELECT contents FROM `#__configurator_customfiles` WHERE `type` = 'themelet' AND `parent_name` = '".$data->themelet."' AND `filename` = 'custom.js.php'";
		$db->setQuery( $query ); $data->custom_js = stripslashes($db->loadResult());
		
		$query = "SELECT contents FROM `#__configurator_customfiles` WHERE `type` = 'themelet' AND `parent_name` = '".$data->themelet."' AND `filename` = 'custom.css.php'";
		$db->setQuery( $query ); $data->custom_css = stripslashes($db->loadResult());

	

		$data->js_jquery = array($data->jquery_core, (bool)$data->tabscount, (bool)$data->accordionscount, $data->lazyload_enabled, $data->captions_enabled, $data->lightbox_enabled, $data->fontsizer_enabled, $data->shareit_enabled);
		$data->js_jqueryui = array((bool)$data->tabscount, (bool)$data->accordionscount);
		$data->js_cookie = array((bool)$data->tabscount, (bool)$data->accordionscount, $data->toolbar_slider, $data->topshelf_slider, $data->bottomshelf_slider, $data->bottomshelf2_slider, $data->bottomshelf3_slider, $data->developer_toolbar);
		$data->js_slider = array($data->toolbar_slider, $data->topshelf_slider, $data->bottomshelf_slider, $data->bottomshelf2_slider, $data->bottomshelf3_slider);
		$data->js_equalize = array($data->toolbar_equalize, $data->masthead_equalize, $data->subhead_equalize, $data->topnav_equalize, $data->topshelf_equalize, $data->bottomshelf_equalize, $data->bottomshelf2_equalize, $data->bottomshelf3_equalize, $data->user1_equalize, $data->user2_equalize, $data->inset1_equalize, $data->inset2_equalize, $data->inset3_equalize, $data->inset4_equalize, $data->outer1_equalize, $data->outer2_equalize, $data->outer3_equalize, $data->outer4_equalize, $data->outer5_equalize, $data->inner1_equalize, $data->inner2_equalize, $data->inner3_equalize, $data->inner4_equalize, $data->inner5_equalize, $data->footer_equalize);
		
		/*if( $data->pack_css ){
			$before = array();
			$before['yui'] = $data->csspath.'/yui.css';
			$cssfiles = array(
				'topnav-default',
				'topnav-topfish',
				'topnav-topdrop',
				'sidenav-default',
				'sidenav-sidefish',
				'tabs',
				'accordions',
				'typo',
				'joomla',
				'modules',
				'modfx',
				'themelet',
				'simpleticker',
				'simpletweet',
				'simplecontact',
				'simplesocial',
				'custom'
			);
			foreach($cssfiles as $css)
			{
				$before[$css] = $data->path.'/css/'.$css.'.css';
			}

		    if( $data->lightbox_enabled == 1 ) $before['colorbox'] = $data->csspath.'/colorbox.css';
		    if( $data->topnav_count < 1 )	unset($before['topnav-default']);
		    if( $data->topfish < 1 )		unset($before['topnav-topfish']);
		    if( $data->topdrop < 1 )		unset($before['topnav-topdrop']);
		    if( $data->sidenav_count < 1 )	unset($before['sidenav-default']);
		    if( $data->sidefish < 1 )		unset($before['sidenav-sidefish']);
		    if( $data->tabscount < 1 )		unset($before['tabs']);
		    if( $data->accordionscount < 1 )unset($before['accordions']);
		    
		    if( !$data->simpleticker )		unset($before['simpleticker']);
		    if( !$data->simpletweet )		unset($before['simpletweet']);
		    if( !$data->simplecontact )		unset($before['simplecontact']);
		    if( !$data->simplesocial )		unset($before['simplesocial']);
		    
		    // add CSS to Morph for WP for Joomla
		    // first if there is no wordpress component loading we still need the supporting files if the module is being used
		    if(JRequest::getVar('option') != 'com_wordpress') {
		    //Check 1 : must add check IF module "mod_wordpress_utility" is active on the page
		    $before[] = 'images/wordpress/themes/morph/css/images.css'; // load if module or wordpress component
		    $before[] = 'images/wordpress/themes/morph/css/modules.css'; // load if module
		    //Check 2 : must add check IF module "mod_wordpress_widgetmod" is active on the page
		    $before[] = 'images/wordpress/themes/morph/css/widgets.css';// load if widget module is used
		    // now if WP is loading, then make sure the theme.css is also loaded as well as the above css files
		    } else if(JRequest::getVar('option') == 'com_wordpress'){ 
		    $before[] = 'images/wordpress/themes/morph/css/theme.css'; // only load if its the wordpress component/wptheme
		    $before[] = 'images/wordpress/themes/morph/css/images.css'; // load if module or wordpress component
		    $before[] = 'images/wordpress/themes/morph/css/modules.css'; // load if module is loaded
		    }
		    
		    foreach($before as $css)
		    {
		    	if(file_exists($css)) $data->stylesheets->before[] = $css;
		    }
		} else {
			$data->stylesheets->before = array();
		}*/


		/*if($data->pack_js)
		{	
			$after	= array();
			$after[] = $data->path.'/js/themelet.js';
			$after[] = $data->path.'/js/custom.js';
			
			foreach($after as $js)
			{
				if(file_exists($js)) $data->scripts->after[] = $js;
			}
		} else {
			 $data->scripts->after = array();
		}*/
		
		/*$cssfiles = array('rtl','browsers','safari','opera','firefox','chrome','webkit','ie','ie8','ie7','ie6');
		foreach($cssfiles as $css)
		{
			$data->{'css_'.$css} = $data->path.'/css/'.$css.'.css';
		}

		
		if($data->pack_css)
		{	
			// Uncomment for testing RTL
			// $data->direction = 'rtl';
			
			$after	= array();
			if($data->developer_toolbar == 1) $after[] = $data->csspath.'/devbar.css';
			if($data->direction == 'rtl' && file_exists($data->css_rtl)) $after[] = $data->css_rtl;
			elseif ($data->direction == 'rtl') $after[] = $data->csspath.'/rtl.css';
			$after[] = $data->csspath.'/browsers.css';

			if(preg_match('/MSIE 6/i', $_SERVER['HTTP_USER_AGENT'])) $after[] = $data->csspath.'/ie6.css';
			
			// browser specific
			$after[] = $data->css_browsers;
			if($data->browser == 'firefox')	$after[] = $data->css_firefox;
			if($data->browser == 'safari')	$after[] = $data->css_safari;
			if($data->browser == 'opera')	$after[] = $data->css_opera;
			if($data->browser == 'chrome')	$after[] = $data->css_chrome;
			if(($data->browser == 'chrome' || $data->browser == 'safari')) $after[] = $data->css_webkit;
			if($data->browser == 'internetexplorer') $after[] = $data->css_ie;
			if(preg_match('/MSIE 8/i', $_SERVER['HTTP_USER_AGENT'])) $after[] = $data->css_ie8;
			if(preg_match('/MSIE 7/i', $_SERVER['HTTP_USER_AGENT'])) $after[] = $data->css_ie7;
			if(preg_match('/MSIE 6/i', $_SERVER['HTTP_USER_AGENT'])) $after[] = $data->css_ie6;
			
			foreach($after as $css)
			{
				if(file_exists($css)) $data->stylesheets->after[] = $css;
			}
		} else {
			 $data->stylesheets->after = array();
		}*/
		
		return $data;
	}
	
	public function loadMorph()
	{
		$path = JPATH_CACHE.'/morph/data.json';
		if(file_exists($path)) {
			return json_decode(file_get_contents($path));
		}
		return array();
	}
	
	public function set($data)
	{
		$this->{$this->format} = array_merge($this->{$this->format}, (array)$data);
	}
}