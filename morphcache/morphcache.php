<?php
/**
* @package   Morph Template
* @category  Morph Cache
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );
JLoader::register('JFile', JPATH_LIBRARIES.'/joomla/filesystem/file.php');
JLoader::register('MBrowser', JPATH_ROOT.'/templates/morph/core/browser.php');
JLoader::register('Morph', JPATH_ROOT.'/templates/morph/core/morphLoader.php');
JLoader::register('MorphLoaderAdapterMorph', JPATH_ROOT.'/templates/morph/core/loader/adapter/morph.php');

/**
 * plgSystemMorphCache
 *
 * This plugin is responsible for taking care of the css and js output of Morph, as well as Configurator.
 * This plugin also autoloads the Morph class, allowing Morph APIs to be used externally
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
class plgSystemMorphCache extends JPlugin
{
	
	/**
	 * The view format, false if no valid format is defined
	 *
	 * @var string|boolean
	 */
	private $format = false;
	
	/**
	 * The render method to call, false if no valid format is defined
	 *
	 * @var string|boolean
	 */
	private $_format = false;

	/**
	 * Catch the routed functions for 
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);

		//Checks if we can run Morph, and if we can, then prepare some adapters
		if(!defined('KOOWA') || JFactory::getApplication()->getCfg('dbtype') != 'mysqli')
		{
			jimport('joomla.filesystem.file');
			$file_exists	= JFile::exists(JPATH_PLUGINS.'/system/koowa.php');
			$mysqli_exists	= class_exists('mysqli');
			$min_php		= version_compare(phpversion(), '5.2', '>=');
			if($file_exists && $mysqli_exists && $min_php)
			{
				$plugin = (object)array('type' => 'system', 'name' => 'koowa');
				JPluginHelper::_import($plugin, 1, 1);
				
				if(!defined('KOOWA')) return;

				if(class_exists('MorphLoaderAdapterMorph'))
				{
					KLoader::addAdapter(new MorphLoaderAdapterMorph());
				}
				//KFactory::addAdapter(new KFactoryAdapterMorph());
			}
		}

		//Checks if we're rendering Configurator css or js
		$this->option = JRequest::getCmd('option');
		$isConfigurator = $this->option  == 'com_configurator' && $render = JRequest::getCmd('render', false);
		if($isConfigurator) return $this->configurator($render);
		
		//Initializing variables
		$this->format = $format	= JRequest::getCmd('render', false);
		$gzip					= JRequest::getBool('gzip', false);
		$cache					= JRequest::getInt('cache', false);
		$view					= 'render'.ucfirst($format);
		
		
		if(!method_exists($this, $view)) return;

		//To prevent parser errors
		@ini_set('display_errors', 0);

		if ($this->_can_gzip()) {
			if(!ob_start(array($this, "ob_gzhandler"))) ob_start();
			//if(!ob_start("ob_gzhandler")) ob_start();
			header("cache-control: must-revalidate");
			$offset = 60 * 10000;
			$expire = "expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
			header($expire);
		}else{
			ob_start();
		}
		
		//Content type headers are necessary for the browser to detect the correct MIME type
		if($format == 'css')	 header('Content-Type: text/css; charset=UTF-8');
		else if($format == 'js') header('Content-Type: text/javascript; charset=UTF-8');
		
		
		//Starts the caching part
		if ($cache)
		{
			//header('X-Morph-Cache: Yes');
			$uri = clone JFactory::getURI();
			$itemid = (int)JRequest::getInt('Itemid', 0);
			$user   = JFactory::getUser();
			$option	= JRequest::getCmd('option', false);
			$request_view	= JRequest::getCmd('view', false);
			$path  = JPATH_CACHE.'/morph/'.$uri->getHost().implode('.', explode('/', $uri->getPath()));
			
			$sniffer = new MBrowser();
			$browser = strtolower(preg_replace("/[^A-Za-z]/i", "", $sniffer->getBrowser()));
			$version = $browser.$sniffer->getVersion();

			$parts = array($path, $option, $request_view, $itemid, $user->gid, $version, $format);
			
			$path  = implode('.', array_filter($parts));

			if(file_exists($path))
			{
				//header('X-Morph-Cache-File-Exists: Yes');
				$created	= time()-date('U', filemtime($path));
				$expire		= $cache * 60;
				if($created > $expire)
				{
					//header('X-Morph-Cache-Expired: Yes');
					$this->$format = $this->setConfigurations();
					$this->$view();
					$this->debug();
					$content = ob_get_flush();
					if(isset($this->content)) $content = $this->content;
					JFile::write($path, $content);
					if(extension_loaded('zlib') && !ini_get('zlib.output_compression')) JFile::write($path.'.gz', gzcompress($content, 9));
					return $this->close();
				}
				else
				{
					//header('X-Morph-Cache-Expired: No');
					$gzip		  = $path.'.gz';
					$gzip_exists  = file_exists($gzip);
					if($this->_can_gzip() && $gzip_exists)
					{
						//header('X-Morph-Cache-Gzip: Yes');
						$contents = file_get_contents($gzip);
						$this->contents = file_get_contents($path);
						echo substr($contents, 0, strlen($contents) - 4);
					}
					else
					{
						//header('X-Morph-Cache-Gzip: No');
						echo file_get_contents($path);
					}
					
					return $this->close();	
				}
			}
			else
			{
				//header('X-Morph-Cache-File-Exists: No');
				$this->$format = $this->setConfigurations();
				$this->$view();
				$this->debug();
				$content = ob_get_contents();
				if(isset($this->content)) $content = $this->content;
				JFile::write($path, $content);
				if(extension_loaded('zlib') && !ini_get('zlib.output_compression')) JFile::write($path.'.gz', gzcompress($content, 9));
				return $this->close();
			}
		} else {
			//header('X-Morph-Cache: No');
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
	
	/**
	 * Checks if the browser can handle gzip
	 */
	private function _can_gzip()
	{
		$notOpera	= strpos(@$_SERVER['HTTP_USER_AGENT'], 'Presto') === false;
		$gzip		= strpos(@$_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false;
		$compress	= extension_loaded('zlib') && !ini_get('zlib.output_compression');
		$enabled	= JRequest::getBool('gzip', false);
	
		return $notOpera && $gzip && $compress && $enabled;
	}
	
	public function ob_gzhandler($buffer)
	{
		//Do not send gzip headers if the client don't support gzip
		if(!$this->_can_gzip()) return false;
		
		ob_implicit_flush(0);
		header('Content-Encoding: gzip');
		header('Vary: Accept-Encoding');
		header('Transfer-Encoding: Identity');
		
		//if(!isset($this->i)) $this->i = 0;
		//header('X-Morph-Gzip: '.++$this->i);
		
		if(empty($this->contents))
		{
			//header('X-Morph-Gzip-Contents: No');
			$this->contents = $buffer;
			$contents		= gzcompress($buffer, 5);
			
			//To prevent a bug where the ob handler is called twice for some reason, causing the output to be uncompressed
			$this->compressed = $contents;
		}
		else
		{
			//header('X-Morph-Gzip-Contents: Yes');
			//Precaution for when the handler is called twice
			$contents = isset($this->compressed) ? $this->compressed : $buffer;
		}
		
		$contents = "\x1f\x8b\x08\x00\x00\x00\x00\x00".$contents;
		header('Content-Length: '.strlen($contents));
		return $contents;

		$crc = crc32($this->contents);
		$size = strlen($this->contents);

		//@TODO we probably don't need this
		return	"\x1f\x8b\x08\x00\x00\x00\x00\x00".
				$contents.
				pack('V', $crc).
				pack('V', $size);
	}
	
	public function onAfterInitialise()
	{	
		$this->morph();
	}
	
	public function morph()
	{
		$app 	= JFactory::getApplication();
		$ready	= array_filter(array($app->isSite(), JRequest::getCmd('option') == 'com_configurator'));
		
		if(!$ready) return;

		//Allowing other extensions to check if morph is loading jquery
		define('MORPH_JQUERY', 1);

		//This is purely because we love CB so much
		define( 'J_JQUERY_LOADED', 1 );
		//And of course, JomSocial as well
		define( 'C_ASSETS_JQUERY', 1 );
		
		//Follow the conventions for loading jquery as most other 3rd parties
		JFactory::getApplication()->set('jquery', true);

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

				if(JFile::getExt($css) == 'php')
				{
					ob_start();
					include JPATH_ROOT.$css;
					$contents = ob_get_clean();
				}
				else
				{
					$contents = file_get_contents(JPATH_ROOT.$css);
				}

				echo str_replace(array('../../../../', '../'), array(JURI::root(1).'/', JURI::root(1).'/templates/morph/core/'), $contents);
				echo PHP_EOL.' /* @end */ '.PHP_EOL;
			}
		}

		ob_start();
		include JPATH_THEMES.'/morph/core/css/template.css.php';
		$contents = ob_get_clean();
		echo str_replace(array('../../../../', '../images/'), array(JURI::root(1).'/', JURI::root(1).'/templates/morph/core/images/'), $contents);

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
				
				if(JFile::getExt($css) == 'php')
				{
					ob_start();
					include JPATH_ROOT.$css;
					$contents = ob_get_clean();
				}
				else
				{
					$contents = file_get_contents(JPATH_ROOT.$css);
				}
				
				echo str_replace(array('../../../../', '../'), array(JURI::root(1).'/', JURI::root(1).'/templates/morph/core/'), $contents);
				echo PHP_EOL.' /* @end */ '.PHP_EOL;
			}
		}

		if($minify) {
			$contents = ob_get_contents();
			ob_clean();
			
			echo $this->minifyCss($contents);
		}

		//Use data uris if possible
		if(JRequest::getBool('data_uris', false) && !preg_match('/MSIE [0-7]/i', @$_SERVER['HTTP_USER_AGENT'])) {
			$buffer = ob_get_contents();
			ob_clean();
			
			//If caching is enabled then read from the dataURI cache
			//if(JRequest::getBool('cache'))
			//{
				$json				= JPATH_CACHE.'/morph/data_uris.json';
				$data_uris_cache	= file_exists($json) ? json_decode(file_get_contents($json), true) : array();
				
				$this->data_uris_cache = $data_uris_cache;
			//}
			
			$buffer = preg_replace_callback('/url\(\s*([\S]*)\s*\)/i', array($this, 'encodeURLs'), $buffer);
			
			//If caching is enabled and changed then wride to the cache
			if(/*JRequest::getBool('cache') && */count($this->data_uris_cache) !== count($data_uris_cache))
			{
				JFile::write(JPATH_CACHE.'/morph/data_uris.json', json_encode($this->data_uris_cache));
			}
			
			echo $buffer;
		}
	}
	
	public function encodeURLs($parts)
	{
		$path = trim($parts[1], "'".'"');
		$url = realpath(JPATH_ROOT.substr($path, strlen(JURI::root(1))));
		if(!$url) $url = realpath(JPATH_ROOT.$path);
		$fail = sprintf('url(%s)', $path);
		//@TODO debug echo below
		//$fail = sprintf('realpath(%s) url(%s) old(%s) juri(%s) strlen(%s) test(%s) testlen(%s)', realpath($url), $url, $path, JURI::root(1), strlen(JURI::root(1)), substr($path, strlen(JURI::root(1))), strlen($path));

		///*$image = realpath(rtrim($_filepath, '/').'/'.$matches[1]);
		//$url = realpath(str_replace(rtrim(JURI::root(1), '/'), JPATH_ROOT, $path));

		//If the file extension don't match, then return
		if(!preg_match('/\.(gif|jpg|png)$/i', $path, $type)) return $fail.'/*pm*/';
		$type = str_replace('jpg', 'jpeg', strtolower($type[1]));

		//If image don't exist, just return the string
		if(!file_exists($url)) return $fail.'/*fe*/';

		 //IE8 don't support more than 32kB for data URIs
		 //@TODO make ie8 specific data uri cache so other browsers don't have to suffer
		if(/*preg_match('/MSIE 8/i', @$_SERVER['HTTP_USER_AGENT']) && */filesize($url) > 409) return $fail.'/*fs*/';

		//If caching is enabled then read from the dataURI cache
		if(isset($this->data_uris_cache))
		{
			if(!isset($this->data_uris_cache[$url]))
			{
				$this->data_uris_cache[$url] = base64_encode(file_get_contents($url));
			}
			$image = $this->data_uris_cache[$url];
		}
		else
		{
			$image = base64_encode(file_get_contents($url));
		}

		return sprintf('url(data:image/%s;base64,%s)', $type, $image);
	}
	
	protected function minifyCss($css)
	{
		include_once JPATH_THEMES.'/morph/core/Compressor.php';
		return Minify_CSS_Compressor::process($css);
	}
	
	public function setConfigurations()
	{
		jimport('joomla.application.module.helper');
		
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
		$counts = array('tabscount', 'accordionscount', 'topdrop', 'topfish', 'subtext', 'sidefish', 'sidenav_count', 'topnav_count', 'simpleticker', 'simpletweet', 'simplecontact', 'simplesocial');
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
		$data->js_cookie = array((bool)$data->tabscount, (bool)$data->accordionscount, $data->toolbar_slider, $data->topshelf1_slider, $data->topshelf2_slider, $data->topshelf3_slider, $data->bottomshelf1_slider, $data->bottomshelf2_slider, $data->bottomshelf3_slider, $data->developer_toolbar);
		$data->js_slider = array($data->toolbar_slider, $data->topshelf1_slider, $data->topshelf2_slider, $data->topshelf3_slider, $data->bottomshelf1_slider, $data->bottomshelf2_slider, $data->bottomshelf3_slider);
		$data->js_equalize = array($data->toolbar_equalize, $data->masthead_equalize, $data->subhead_equalize, $data->topnav_equalize, $data->topshelf1_equalize, $data->topshelf2_equalize, $data->topshelf3_equalize, $data->bottomshelf1_equalize, $data->bottomshelf2_equalize, $data->bottomshelf3_equalize, $data->user1_equalize, $data->user2_equalize, $data->inset1_equalize, $data->inset2_equalize, $data->inset3_equalize, $data->inset4_equalize, $data->outer1_equalize, $data->outer2_equalize, $data->outer3_equalize, $data->outer4_equalize, $data->outer5_equalize, $data->inner1_equalize, $data->inner2_equalize, $data->inner3_equalize, $data->inner4_equalize, $data->inner5_equalize, $data->footer_equalize);
		
		return $data;
	}
	
	public function loadMorph()
	{
		//Generate name for the morph json formatted params that are passed to the css and js views
		$uri	= clone JFactory::getURI();
		//Remove parts of the url that morph adds
		foreach(array('render', 'cache', 'gzip', 'data_uris') as $remove) $uri->delVar($remove);
		$base	= JPATH_CACHE.'/morph-sessions/'.session_id().'/';
		$parts	= array_filter(explode('/', $uri->getPath()));
		//Sometimes index.php are added even if not present in main url. So remove it just in case
		if(end($parts) == 'index.php') array_pop($parts);
		$parts[]= $uri->getHost();
		$pre	= implode('.', $parts);
		$path	= $base.$pre;
		$data	= array();
		$query	= array_flip($uri->getQuery(1));
		asort($query);
		foreach($query as $value => $key)
		{
			$data[] = $key.'='.$value;
		}
		$path = $path.'&'.implode('&', $data).'.json';

		if(file_exists($path)) {
			return json_decode(file_get_contents($path));
		} else {
			//@todo merge morphFunctions with morphLoader
			return array();
		
			//This is very slow, but is more useful than broken css
			$this->morph();
			require_once JPATH_ROOT.'/templates/morph/core/morphFunctions.php';
			return Morph::getInstance();
		}
		return array();
	}
	
	public function set($data)
	{
		$this->{$this->format} = array_merge($this->{$this->format}, (array)$data);
	}
}