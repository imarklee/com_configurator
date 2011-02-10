<?php
header("content-type: text/javascript; charset: UTF-8");
ob_start("ob_gzhandler");
header("cache-control: must-revalidate");
$offset = 60 * 60;
$expire = "expires: " . gmdate ("D, d M Y H:i:s", time() + $offset) . " GMT";
header($expire);
include '../../js/jquery.js';
include '../../js/ui.js';
include '../../js/fileupload.js';
include '../../js/cookie.js';
?>
jQuery.noConflict();
(function($){
	$(document).ready(function(){
	//Define the Nooku token for all ajax requests, by grabbing the value of the DOM for now
	$.ajaxSetup({beforeSend: function(xhr){
		xhr.setRequestHeader('X-Token', $('input[name=_token]').val());
	}});
	<?php
	include '../../js/functions/common.js';
	include 'install.configurator.js';
	?>
	})
})(jQuery);
<?php ob_end_flush(); ?>