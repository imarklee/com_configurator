<script src="components/com_configurator/js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="components/com_configurator/js/jquery.corners.min.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery.noConflict();
(function($){
	$(document).ready(function(){
		
		$('#sample-data').corners('10px');
		$('#sd-header').corners('5px top');
		$('.steps').corners('5px top');
		$('#sd-footer').corners('5px bottom');
		
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
<style type="text/css" media="screen">
#sample-data{width:800px;margin:2em auto;border:2px solid #000;font:normal 76%/160% arial;background:#fff;position:relative;}
#sd-header,
#sd-footer{background:#111;}
#sd-header{height:95px;overflow:hidden;}
#sd-header .logo{background:#111 url(components/com_configurator/images/logo.png) no-repeat;display:block;margin:15px 0 0 15px;width:233px;height:64px;text-indent:-7998px;float:left;}
#sd-header .steps strong{font:bold 35px arial;color:#ccc;display:block;}
#sd-header .steps{background:#111 url(components/com_configurator/images/step2.png) no-repeat 90% 9%;font:bold 25px arial;color:#eee;width:265px;float:right;margin:0;padding:100px;overflow:hidden;}
#sd-body{padding:1em 2em;font:normal 18px/27px arial;height:320px;}
#sd-image{position:absolute;top:48%;left:48%;display:none;}
#sd-footer{height:25px}
#sd-body h3{font:bold 30px arial;color:#444;margin-top:.5em;}
#sd-body .alert{font:bold 15px arial;background:#FFFF99 url(components/com_configurator/images/alert.png) no-repeat 8px 6px;padding:5px 5px 5px 28px;margin-bottom:2em;color:#990000;border:1px solid #FFCC00;}
#sd-body .action{overflow:hidden;}
#sd-body .btn-install{background:#fff url(components/com_configurator/images/btn-install-sample.png) no-repeat;display:block;width:260px;height:60px;text-indent:-7998px;float:left;}
#sd-body .btn-skip{float:left;font:bold 25px/50px arial;text-decoration:underline;color:#3A8BD0;margin-left:1em;}
#sd-body .btn-cont{display:block;font:bold 25px/50px arial;text-decoration:underline;color:#3A8BD0;margin-left:1em;}
#sd-body .success{text-align:center;color:green;font:bold 35px/70px arial;display:block;padding-top:2.5em;}
#sd-body .error{text-align:center;color:red;font:bold 35px/70px arial;display:block;padding-top:2.5em;}
.btn-skip:hover{color:#2D6EA4;}
</style>

<div id="sample-data">
	<div id="sd-header">
		<a href="http://www.prothemer.com" class="logo">ProThemer</a>
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
	<div id="sd-footer"></div>
	<div id="sd-image">
		<img src="components/com_configurator/images/ajax-loader.gif" height="31" width="31" alt="Loading" />
	</div>
</div>