<?php
header("content-type: text/css; charset: UTF-8");
ob_start("ob_gzhandler");
header("cache-control: must-revalidate");
$offset = 60 * 60;
$expire = "expires: " . gmdate ("D, d M Y H:i:s", time() + $offset) . " GMT";
header($expire);
include 'install.configurator.css';
include '../../css/ui.css';
include '../../css/overlay.css';
ob_end_flush(); ?>