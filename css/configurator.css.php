<?php
header("content-type: text/css; charset: UTF-8");
if(extension_loaded('zlib') && !ini_get('zlib.output_compression')){
if(!ob_start("ob_gzhandler")) ob_start();
}else{
ob_start();
}
header("cache-control: must-revalidate");$offset = 60 * 10000;$expire = "expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";header($expire);
// global
include('reset.css');
include('960.css');
include('ui.css');
include('text.css');
include('overlay.css');
include('sprite.css');
include('manage.css');
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