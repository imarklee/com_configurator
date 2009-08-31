<?php
ob_start();
header('content-type: text/css; charset: UTF-8');

	// global
	include('global/reset.css');
	include('global/960.css');
	include('global/ui.css');
	//include('global/text.css');
	include('global/overlay.css');
	include('global/sprite.css');

	// dashboard
	// include('dashboard/dashboard.css');

if(!isset($_COOKIE['am_logged_in']) && !isset($_COOKIE['am_logged_in_user'])){
	// login
	include('login/login.css');
} else {
	// manage
	include('manage/assets.css');
	include('manage/colorpicker.css');
	include('manage/docs.css');
	include('manage/feedback.css');
	include('manage/footer.css');
	include('manage/forms.css');
	include('manage/fullscreen.css');
	include('manage/help.css');
	include('manage/keyboard.css');
	include('manage/manage.css');
	include('manage/preferences.css');
	include('manage/shelf.css');
	include('manage/tabs.css');
	include('manage/tips.css');
	include('manage/tooltips.css');
	include('manage/toplinks.css');
	include('manage/uploader.css');
	include('manage/welcome.css');
}
ob_end_flush();
?>