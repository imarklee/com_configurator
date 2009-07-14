<?php ini_set('memory_limit', '32M'); ?>
<!-- 
<script src="components/com_configurator/js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="components/com_configurator/js/jquery-ui-1.7.2.custom.min.js" type="text/javascript"></script>
<script src="components/com_configurator/js/jquery.corners.min.js" type="text/javascript"></script>
<script src="components/com_configurator/js/jquery.fileupload.js" type="text/javascript"></script>
<script src="components/com_configurator/js/cookie.js" type="text/javascript"></script>
<script src="components/com_configurator/js/install.configurator.js" type="text/javascript"></script> 
-->
<script src="../com_configurator/js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="../com_configurator/js/jquery-ui-1.7.2.custom.min.js" type="text/javascript"></script>
<script src="../com_configurator/js/jquery.corners.min.js" type="text/javascript"></script>
<script src="../com_configurator/js/jquery.fileupload.js" type="text/javascript"></script>
<script src="../com_configurator/js/cookie.js" type="text/javascript"></script>
<script src="../com_configurator/js/install.configurator.js" type="text/javascript"></script>

<!--
<link href="components/com_configurator/css/install.css" media="screen" rel="stylesheet" type="text/css" />
<link href="components/com_configurator/css/jquery-ui-1.7.2.custom.css" media="screen" rel="stylesheet" type="text/css" />
<link href="components/com_configurator/css/manage.css" media="screen" rel="stylesheet" type="text/css" />
-->
<link href="../com_configurator/css/install.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../com_configurator/css/jquery-ui-1.7.2.custom.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../com_configurator/css/manage.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript"></script>
<div id="install-wrap">
<div id="sample-data">
	<?php
	if(!isset($_REQUEST['install'])){
		include 'includes/installer/step2.php';
	}else{
		if($_REQUEST['install'] == 'step3'){
			include 'includes/installer/step3.php';
		}
		elseif($_REQUEST['install'] == 'step4'){
			include 'includes/installer/step4.php';
		}
		elseif($_REQUEST['install'] == 'completed'){
			include 'includes/installer/complete.php';
		}
	}
	?>
</div>
</div>
<div id="upload-message" style="display:none;"></div>