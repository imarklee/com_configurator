<!-- <script src="components/com_configurator/js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="components/com_configurator/js/jquery.corners.min.js" type="text/javascript"></script> -->
<script src="../com_configurator/js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="../com_configurator/js/jquery.corners.min.js" type="text/javascript"></script>
<!--<link href="components/com_configurator/css/install.css" media="screen" rel="stylesheet" type="text/css" />-->
<link href="../com_configurator/css/install.css" media="screen" rel="stylesheet" type="text/css" />

<script type="text/javascript">
jQuery.noConflict();
(function($){
	$(document).ready(function(){
		
		$('#sd-body').corners('10px');		
		$('.btn-install').click(function(){
			$.ajax({
				url: '../administrator/index.php?option=com_configurator&task=install_sample&do=install&formsat=raw',
				beforeSend: function(){
					$('#sd-image').css('display','block');
					$('#sd-body').fadeTo("fast", 0.1);
				},
				complete: function(data,text){
					$('#sd-image').css('display','none');
					$('#sd-body').fadeTo("fast", 1);
					$('#sd-text').css('display', 'none');
					$('.btn-install').hide();
					$('.btn-skip').hide();
					$('.action').before('<span class="success">Sample data installed successfully! <a href="index.php?option=com_configurator&task=manage" class="btn-cont">Continue</a></span>');

				},
				error: function(data, text){
					$('#sd-image').css('display','none');
					$('#sd-body').fadeTo("fast", 1);
					$('.btn-install').hide();
					$('.action').before('<span class="error">There was an error installing the Sample Data.</span>');
					$('.btn-skip').text('Continue');
				}
			});
		return false;
		});
	
	})
})(jQuery);
</script>
<div id="install-wrap">
<div id="sample-data">
	<?php
	if(!isset($_GET['action'])){
		include 'includes/installer/step2.php';
	}else{
		if($_GET['action'] == 'step3'){
			include 'includes/installer/step3.php';
		}
		elseif($_GET['action'] == 'step4'){
			include 'includes/installer/step4.php';
		}
		elseif($_GET['action'] == 'completed'){
			include 'includes/installer/complete.php';
		}
	}
	?>
</div>
</div>