<?php
header("content-type: text/css; charset: UTF-8");
if(extension_loaded('zlib') && !ini_get('zlib.output_compression')){
if(!ob_start("ob_gzhandler")) ob_start();
}else{
ob_start();
}
header("cache-control: must-revalidate");
$offset = 60 * 10000;
$expire = "expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
header($expire);

// browser specific
$browser = '../includes/browser.php';
if(file_exists($browser)) {

	//This is only to make it possible to include the browser class
	define('_JEXEC', true);

	include_once($browser);
}

$browser 	= new MBrowser();
$thebrowser	= str_replace(' ','-', strtolower($browser->getBrowser()));

//Create an additional buffer, so we can search replace paths later.
ob_start();

// global
include('reset.css');
include('960.css');
include('ui.css');
include('text.css');
include('overlay.css');
include('sprite.css');
include('manage.css');
include('toplinks.css');
include('feedback.css');
include('welcome.css');
include('assets.css');
include('tabs.css');
include('accordion.css');
include('shelf.css');
include('forms.css');
include('footer.css');
include('help.css');
include('keyboard.css');
include('preferences.css');
include('tooltips.css');
include('tools.css');
include('colorpicker.css');
include('docs.css');
include('fullscreen.css');
include('tips.css');
include('editor.css');
include('itoggle.css');
//}

// browser stylesheets
switch($thebrowser){
	case 'safari': include('safari.css'); break;
	case 'chrome': include('chrome.css'); break;
	case 'internet-explorer': include('ie.css'); break;
	case 'opera': include('opera.css'); break;
	case 'firefox': include('firefox.css'); break;
}
$buffer = ob_get_clean();
if (strpos(php_sapi_name(), 'cgi') !== false && !empty($_SERVER['REQUEST_URI'])) {
	//Apache CGI
	$path =  rtrim(dirname(str_replace(array('"', '<', '>', "'"), '', $_SERVER["PHP_SELF"])), '/\\');
} else {
	//Others
	$path =  rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
}
//Dirname removes the /css part
$path = dirname($path).'/';
$search = array('<,', '../');
$replace = array('', $path);

echo str_replace($search, $replace, $buffer);

ob_end_flush();