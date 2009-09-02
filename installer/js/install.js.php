<?php
header("content-type: text/javascript; charset: UTF-8");
ob_start("ob_gzhandler");
header("cache-control: must-revalidate");
$offset = 60 * 60;
$expire = "expires: " . gmdate ("D, d M Y H:i:s", time() + $offset) . " GMT";
header($expire);
include '../../js/jquery.js';
include '../../js/ui.js';
include '../../js/corners.js';
include '../../js/fileupload.js';
include '../../js/cookie.js';
include 'install.configurator.js';
ob_end_flush();
?>