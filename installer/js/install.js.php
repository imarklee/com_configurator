<?php
header("content-type: text/javascript; charset: UTF-8");
ob_start("ob_gzhandler");
header("cache-control: must-revalidate");
$offset = 60 * 60;
$expire = "expires: " . gmdate ("D, d M Y H:i:s", time() + $offset) . " GMT";
header($expire);
include '..'.DS.'..'.DS.'js'.DS.'jquery.js';
include '..'.DS.'..'.DS.'js'.DS.'ui.js';
include '..'.DS.'..'.DS.'js'.DS.'fileupload.js';
include '..'.DS.'..'.DS.'js'.DS.'cookie.js';
?>
jQuery.noConflict();
(function($){
	$(document).ready(function(){
	<?php
	include '..'.DS.'..'.DS.'js'.DS.'functions'.DS.'common.js';
	include 'install.configurator.js';
	?>
	})
})(jQuery);
<?php ob_end_flush(); ?>