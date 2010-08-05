<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="debugging-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="debugging-options" class="options-panel">
		<h3>Debugging Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('debugging', 'debuggingdata')); ?>
		</ol>
	</div>
	<div id="debugging-info" class="info-panel">
		<h3>Debugging overview</h3>
		<p class="teaser">These options are useful when developing your site and can be used 
		to help you debug any issues you may encounter.</p>
		
		<p>The <strong>Debug Modules</strong> option will globabally change all modules to use 
		the "outline" module chrome, giving you a visual breakdown of all the module 
		positions that are being used.</p>
	</div>
</div>