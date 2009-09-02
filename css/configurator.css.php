<?php
ob_start();
header('content-type: text/css; charset: UTF-8');

	// global
	include('reset.css');
	include('960.css');
	include('ui.css');
	include('overlay.css');
	include('sprite.css');
if(!isset($_COOKIE['am_logged_in']) && !isset($_COOKIE['am_logged_in_user'])){
	// login
	include('login.css');
} else {
	// manage
	include('assets.css');
	include('colorpicker.css');
	include('docs.css');
	include('feedback.css');
	include('footer.css');
	include('forms.css');
	include('fullscreen.css');
	include('help.css');
	include('keyboard.css');
	include('manage.css');
	include('preferences.css');
	include('shelf.css');
	include('tabs.css');
	include('tips.css');
	include('tooltips.css');
	include('toplinks.css');
	include('uploader.css');
	include('welcome.css');
}
ob_end_flush();
?>