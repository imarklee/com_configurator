<?php
ob_start();
header('content-type: text/javascript; charset: UTF-8');
// global
include('jquery.js');
include('ui.js');
include('cookie.js');
include('preload.js');
include('browser.js');
include('corners.js');
include('functions.js.php');
if(!isset($_COOKIE['am_logged_in']) && !isset($_COOKIE['am_logged_in_user'])){
// login
include('showpassword.js');
} else {
// manage
include('colorpicker.js');
include('form.js');
include('fileupload.js');
include('autoresize.js');
include('qtip.js');
include('getparams.js');
}
ob_end_flush();
?>