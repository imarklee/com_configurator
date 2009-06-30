<script src="components/com_configurator/js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="components/com_configurator/js/jquery.corners.min.js" type="text/javascript"></script>
<!--<script src="../com_configurator/js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="../com_configurator/js/jquery.corners.min.js" type="text/javascript"></script>-->
<link href="components/com_configurator/css/install.css" media="screen" rel="stylesheet" type="text/css" />

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
	<div id="sd-header">
		<img src="../com_configurator/images/morph-logo.png" alt="morph logo" width="173" height="60" border="0" />
		<p class="steps"><strong>Step Two: </strong>Choose your Setup</p>
	</div>
	<div id="sd-body">
		<div id="sd-text">
			<h3>Would you like to install sample data? (optional)</h3>
			<p>If this is a <strong><u>new Joomla! install</u></strong> &amp; you have not yet added any content or changed any settings this will be your quick option to getting setup. Installing sample data takes care of most of the required setup steps, as well as adding sample content, menu items, etc.</p>
			<p class="alert">Please note clicking the "Install Sample Data button will overwrite your entire Joomla! database!</p>
		</div>
		<p class="action"><a href="#" class="btn-install">Install sample data</a><a href="index.php?option=com_configurator&task=manage" class="btn-skip">Skip this step</a></p>
	</div>
	<div id="sd-image">
		<img src="components/com_configurator/images/loader3.gif" height="16" width="16" border="0" align="center" alt="Loading" />
	</div>
</div>
</div>