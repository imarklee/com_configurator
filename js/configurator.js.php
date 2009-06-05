<?php
ob_start();
header('content-type: text/javascript; charset: UTF-8');
include('jquery-1.3.2.min.js');
include('jquery-ui-1.7.1.custom.min.js');
include('cookie.js');
include('colorpicker.js');
include('jquery.corners.min.js');
include('jquery.filestyle.min.js');
include('jquery.qtip-1.0.0-rc3.min.js');
include('jquery.fileupload.js');
include('morphFunctions.js.php');
ob_end_flush();
?>