<?php
ob_start();
header('content-type: text/css; charset: UTF-8');
include('reset.css');
include('960.css');
include('jquery-ui-1.7.2.custom.css');
include('manage.css');
include('colorpicker.css');
include('text.css');
ob_end_flush();
?>