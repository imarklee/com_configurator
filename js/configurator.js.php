<?php
ob_start();
header('content-type: text/javascript; charset: UTF-8');
include('jquery-1.3.2.min.js');
include('jquery-ui-1.7.2.custom.min.js');
include('cookie.js');
include('colorpicker.js');
include('jqbrowser.js');
include('jquery.corners.min.js');
include('jquery.filestyle.min.js');
include('jquery.qtip-1.0.0-rc3.min.js');
include('jquery.fileupload.js');
include('jquery.autoresize.min.js');
include('configurator.functions.js.php');
ob_end_flush();
?>