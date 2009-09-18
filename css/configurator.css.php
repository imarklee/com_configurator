<?php
header("content-type: text/css; charset: UTF-8");
if(extension_loaded('zlib') && !ini_get('zlib.output_compression')){
if(!ob_start("ob_gzhandler")) ob_start();
}else{
ob_start();
}
header("cache-control: must-revalidate");$offset = 60 * 10000;$expire = "expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";header($expire);

// browser specific
include_once('../../../../templates/morph/core/browser.php');
$browser 	= new Browser();
$thebrowser	= str_replace(' ', '-', strtolower(ereg_replace("[^A-Za-z]", "", $browser->getBrowser())));

// global
include('reset.css');
include('960.css');
include('ui.css');
include('text.css');
include('overlay.css');
include('sprite.css');
include('manage.css');

// browser stylesheets
switch($thebrowser){
	case 'safari': include('safari.css'); break;
	case 'chrome': include('chrome.css'); break;
	case 'internet-explorer': include('ie.css'); break;
	case 'opera': include('opera.css'); break;
	case 'firefox': include('firefox.css'); break;
}

if(!isset($_COOKIE['am_logged_in']) && !isset($_COOKIE['am_logged_in_user'])){
// login
include('login.css');
} else {
// manage
include('welcome.css');
include('toplinks.css');
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
include('feedback.css');
include('docs.css');
include('fullscreen.css');
include('tips.css');
}
ob_end_flush();
?>