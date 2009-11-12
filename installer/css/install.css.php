<?php
define('DS', DIRECTORY_SEPARATOR);
header("content-type: text/css; charset: UTF-8");
ob_start("ob_gzhandler");
header("cache-control: must-revalidate");
$offset = 60 * 60;
$expire = "expires: " . gmdate ("D, d M Y H:i:s", time() + $offset) . " GMT";
header($expire);
include 'install.configurator.css';
include '..'.DS.'..'.DS.'css'.DS.'ui.css';
include '..'.DS.'..'.DS.'css'.DS.'overlay.css';
ob_end_flush(); ?>