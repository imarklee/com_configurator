<?php defined('_JEXEC') or die('Restricted access');
if(extension_loaded('zlib') && !ini_get('zlib.output_compression')){
	if(!ob_start("ob_gzhandler")) ob_start();
}else{
	ob_start();
}
header("cache-control: must-revalidate");
$offset = 60 * 10000;
$expire = "expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
header($expire);
header("content-type: text/javascript; charset: UTF-8");
// global
include('jquery.js');
include('ui.js');
include('cookie.js');
include('preload.js');
include('browser.js');
include('colorpicker.js');
include('form.js');
include('fileupload.js');
include('autoresize.js');
include('qtip.js');
include('getparams.js');
include('jsoncookie.js');
include('codemirror/codemirror.js');
include('textarearesizer.js');
include('itoggle.js');
//}
include('functions.js.php');
ob_end_flush();
?>