<div id="debugging-tab" class="ui-tabs-hide">
	<div id="debugging-options" class="options-panel">
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('debugging', 'debuggingdata')); ?>
		</ol>
	</div>
	<div id="debugging-info" class="info-panel">
		<h3>Debugging overview</h3>
		<p class="teaser">These options are useful when developing your site and can be used to help you debug any issues you may encounter.</p>
		
		<p>The <strong>Debug Modules</strong> option will globabally change all modules to use the "outline" module chrome, thus giving you a visual breakdown of all the module positions that are being used.</p>
	</div>
</div>