<?php 
if(strpos($_SERVER['SCRIPT_NAME'], 'install.configurator.php') === false){
$base = './components/com_configurator';
}else{
$base = '.';
}
ini_set('memory_limit', '32M');
define('JINDEXURL', $base);
?>
<script src="<?php echo JINDEXURL; ?>/js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="<?php echo JINDEXURL; ?>/js/jquery-ui-1.7.2.custom.min.js" type="text/javascript"></script>
<script src="<?php echo JINDEXURL; ?>/js/jquery.corners.min.js" type="text/javascript"></script>
<script src="<?php echo JINDEXURL; ?>/js/jquery.fileupload.js" type="text/javascript"></script>
<script src="<?php echo JINDEXURL; ?>/js/cookie.js" type="text/javascript"></script>
<script src="<?php echo JINDEXURL; ?>/installer/js/install.configurator.js" type="text/javascript"></script>

<link href="<?php echo JINDEXURL; ?>/installer/css/install.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo JINDEXURL; ?>/css/jquery-ui-1.7.2.custom.css" media="screen" rel="stylesheet" type="text/css" />

<script type="text/javascript"></script>
<div id="install-wrap">
	<div id="installer">
	<?php
	if(!isset($_REQUEST['install'])){
		include 'installer/step1.php';
	}else{
		if($_REQUEST['install'] == 'step2'){
			include 'installer/step2.php';
		}
		elseif($_REQUEST['install'] == 'step3'){
			include 'installer/step3.php';
		}
		elseif($_REQUEST['install'] == 'completed'){
			include 'installer/complete.php';
		}
	}
	?>
	</div>
</div>
<div id="dialog" style="display:none;"></div>