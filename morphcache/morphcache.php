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
			$path = JPATH_CACHE.'/morph/'.$uri->getHost().str_replace(array('/', 'index.php', '.php'), array('-', '', ''), $uri->getPath()).'.'.$format;
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
			
			ob_end_flush();
			return $this->close();	
			
		}
		
		///ob_get_length add way to serious overhead, we can't use it before we got clever caching
		//header("Content-Length: ".ob_get_length());
		
		
		return $this;
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
			$html[] = PHP_EOL.'/* @group '.JText::_( $format.' Profile Information' ).PHP_EOL;
			foreach ( $profiler->getBuffer() as $mark ) {
				$html[] = PHP_EOL.$mark.PHP_EOL;
			}
			$html[] = PHP_EOL.' @end */'.PHP_EOL;
	
			$html[] = PHP_EOL.'/* @group '.JText::_( $format.' Memory Usage' ).PHP_EOL;
			$html[] = $profiler->getMemory();
			$html[] = PHP_EOL.' @end */'.PHP_EOL;
		}
		return implode($html);
	}
	
	public function renderJs()
	{
		foreach($this->js->scripts->before as $js)
		{
			//echo PHP_EOL.' /* @group '.basename($js).' */ '.PHP_EOL;
			echo file_get_contents($js);
			//echo PHP_EOL.' /* @end '.basename($js).' */ '.PHP_EOL;
		}
		include JPATH_THEMES.'/morph/core/js/template.js.php';
	}
	
	public function renderCss()
	{
		foreach($this->css->stylesheets->before as $css)
		{
			echo PHP_EOL.' /* @group '.basename($css).' */ '.PHP_EOL;
			echo str_replace('../../../../', JURI::root(1).'/', file_get_contents($css));
			echo PHP_EOL.' /* @end */ '.PHP_EOL;
		}
		include JPATH_THEMES.'/morph/core/css/template.css.php';

		if($this->css->custom_css)
		{
			echo PHP_EOL.'/* @group Custom Themelet CSS */'.PHP_EOL;
			echo $this->css->custom_css;
			echo PHP_EOL.' /* @end */ '.PHP_EOL;
		}
		foreach($this->css->stylesheets->after as $css)
		{
			echo PHP_EOL.' /* @group '.basename($css).' */ '.PHP_EOL;
			echo str_replace('../../../../', JURI::root(1).'/', file_get_contents($css));
			echo PHP_EOL.' /* @end */ '.PHP_EOL;
		}
	}
	
	public function setConfigurations()
	{
		jimport('joomla.application.module.helper');
		JLoader::import('templates.morph.core.browser', JPATH_ROOT);
		
		$data = (object) $this->loadMorph();
		
		
		$browser 					= new Browser();
		$data->browser 				= strtolower(preg_replace("/[^A-Za-z]/i", "", $browser->getBrowser()));
		
		$document = JFactory::getDocument();
		$data->direction = $document->direction;
		
		$data->count_left = count(JModuleHelper::getModules('left'));
	
		if ( $data->logo_type == 1 or $data->logo_type == 2 ) {
			if( isIE6() && $data->logo_image_ie !== ''){ 
				$data->logo = $assetspath.DS.'logos'.DS.$data->logo_image_ie; 
				if($data->logo_autodimensions == 1) {
					$data->logo_size = getimagesize($assetsroot.DS.'logos'.DS.$data->logo_image_ie);
				}else{
					$data->logo_size[0] = $data->logo_width;
					$data->logo_size[1] = $data->logo_height;
				}	
			} else{ 
				$data->logo = $assetspath.'/logos/'.$data->logo_image; 
				if($data->logo_autodimensions == 1) {
					$data->logo_size = getimagesize($assetsroot.DS.'logos'.DS.$data->logo_image);
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
		
		// css and js packing variables
		(isset($_COOKIE['unpackcss'])) ? $data->pack_css = 0 : $data->pack_css = $data->pack_css;
		
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

		$rootpath		= JPATH_THEMES.'/morph/core';
		$data->csspath		= $rootpath.'/css';
		$data->jspath			= $rootpath.'/js';
		$data->path = JPATH_ROOT.'/morph_assets/themelets/'.$data->themelet;

		$data->js_jquery = array($data->jquery_core, $data->tabscount, $data->accordionscount, $data->lazyload_enabled, $data->captions_enabled, $data->lightbox_enabled);
		$data->js_jqueryui = array($data->tabscount, $data->accordionscount);
		$data->js_cookie = array($data->tabscount, $data->accordionscount, $data->toolbar_slider, $data->topshelf_slider, $data->bottomshelf_slider, $data->developer_toolbar);
		$data->js_slider = array($data->toolbar_slider, $data->topshelf_slider, $data->bottomshelf_slider);
		$data->js_equalize = array($data->topshelf_equalize, $data->bottomshelf_equalize, $data->user1_equalize, $data->user2_equalize, $data->outer1_equalize, $data->outer2_equalize, $data->outer3_equalize, $data->outer4_equalize, $data->outer5_equalize, $data->inner1_equalize, $data->inner2_equalize, $data->inner3_equalize, $data->inner4_equalize, $data->inner5_equalize);
		
		if( $data->pack_js == 1 ){
			$before = array();
			if(in_array('1', $data->js_jquery)) $before[] = $data->jspath.'/jquery.js';
			if(in_array('1', $data->js_jqueryui)) $before[] = $data->jspath.'/ui.js';
			if(in_array('1', $data->js_cookie)) $before[] = $data->jspath.'/cookie.js';
			if(in_array('1', $data->js_equalize)) $before[] = $data->jspath.'/equalheights.js';
			if(in_array('1', $data->js_slider)) $before[] = $data->jspath.'/slider.js';
			if ( $data->tabscount >= 1 )  $before[] = $data->jspath.'/tabs.js';
			if ( $data->accordionscount >= 1 )  $before[] = $data->jspath.'/accordion.js';
			if ( $data->topfish >= 1 && $data->topnav_hoverintent == 1 )  $before[] = $data->jspath."/hoverintent.js";
			if ( $data->sidefish >= 1 or $data->topfish >= 1 or $data->topdrop >= 1  )  $before[] = $data->jspath.'/superfish.js';
			if ( $data->topfish >= 1 && $data->topnav_supersubs == 1 )  $before[] = $data->jspath."/supersubs.js";
			if ( $data->plugin_scrollto )  $before[] = $data->jspath.'/scrollto.js';
			if ( $data->simpleticker )  $before[] = $data->jspath.'/innerfade.js';
			if ( $data->simpletweet )  $before[] = JPATH_ROOT.'/modules/mod_simpletweet/js/simpletweet.js';
			if ( $data->google_analytics !== '' )  $before[] = $data->jspath.'/googleanalytics.js';
			if ( $data->lazyload_enabled )  $before[] = $data->jspath.'/lazyload.js';
			if ( $data->captions_enabled )  $before[] = $data->jspath.'/captify.js';
			if ( $data->lightbox_enabled )  $before[] = $data->jspath.'/colorbox.js';
			$before[] = $data->jspath.'/fontsizer.js';

			foreach($before as $js)
			{
				if(file_exists($js)) $data->scripts->before[] = $js;
			}
			
		} else {
			$data->scripts->before = array();
		}
		
		
		if( $data->pack_css ){
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
				'simplesocial'
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
		    
		    foreach($before as $css)
		    {
		    	if(file_exists($css)) $data->stylesheets->before[] = $css;
		    }
		} else {
			$data->stylesheets->before = array();
		}


		if($data->pack_js)
		{	
			$after	= array();
			$after[] = $data->path.DS.'js'.DS.'themelet.js';
			
			foreach($after as $js)
			{
				if(file_exists($js)) $data->scripts->after[] = $js;
			}
		}
		
		$cssfiles = array('rtl','browsers','safari','opera','firefox','chrome','webkit','ie','ie8','ie7','ie6');
		foreach($cssfiles as $css)
		{
			$data->{'css_'.$css} = $data->path.'/css/'.$css.'.css';
		}

		
		if($data->pack_css)
		{	
			$after	= array();
			if($data->developer_toolbar == 1) $after[] = $data->csspath.'/devbar.css';
			if($data->direction == 'rtl') $after[] = $data->css_rtl;
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
		}
		
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