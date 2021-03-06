<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="logos-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="logo-options" class="options-panel">
	    <h3>Logo Settings</h3>
		<ol class="forms" id="logo-panel">
			<?php echo renderParams($params->renderToArray('logo', 'logodata')); ?>
		</ol>
	    <h3>Tagline Settings</h3>
		<ol class="forms" id="tagline-panel">
			<?php echo renderParams($params->renderToArray('tagline', 'taglinedata')); ?>
		</ol>
	</div>
	
	<div id="logo-info" class="info-panel">
		<h3>Customize your sites logo</h3>
		<p class="teaser">We realize that everyone has different opinions about how your logo 
		should be outputted, so with Morph we have gone ahead and given you option to choose for 
		yourself.</p>
		<h4>Understanding the logo options</h4>
		<p>We highly recommended that you click on the help icon next to the "<strong>Logo type</strong>" 
		option and take a minute to read over the different the different ways you can output your sites 
		logo. </p>		
		<p><a href="#" class="upload-logo btn-link">Upload a new logo</a>&nbsp;&nbsp;<a href="#" 
		class="masthead-tab btn-link">Configure your main header tab</a></p>
	</div>
</div>