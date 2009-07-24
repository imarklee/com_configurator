<?php 
function com_install(){
	(strpos($_SERVER['SCRIPT_NAME'], 'install.configurator.php') === false) ? $base = './components/com_configurator' : $base = '.';
	ini_set('memory_limit', '32M');
	define('JINDEXURL', $base);
	$config = JFactory::getConfig();
	$gzipval = $config->getValue( 'config.gzip' ); ?>
	
	<script src="<?php echo JINDEXURL; ?>/installer/js/install.js.php" type="text/javascript"></script>
	<link href="<?php echo JINDEXURL; ?>/installer/css/install.css.php" media="screen" rel="stylesheet" type="text/css" />
	
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
<?php } ?>