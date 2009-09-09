<div id="iphone-tab" class="ui-tabs-hide">
	<div id="iphone-options" class="options-panel">
		<h3>iPhone Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('iphone', 'iphonedata')); ?>
		</ol>
	</div>
	<div id="iphone-info" class="info-panel">
		<h3>About iPhone compatibility</h3>
		<p class="teaser">These options let you customize how your site looks when it is viewed on an iPhone.</p>

		<p>We will be adding an option to let you upload your iPhone graphics from the installer, but until then you will need to upload them manually to your "morph_assets/iphone" folder. More options coming soon :)</p>
	</div>
</div>