<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="fonts-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="fonts-options" class="options-panel">
		<h3>Custom Fonts</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('googlefonts', 'googlefontsdata')); ?>
		</ol>
	</div>
	<div id="fonts-info" class="info-panel">
		<h3>Using Google Fonts</h3>
		<p class="teaser">If enabled, this will replace your standard H1 and H2 fonts with the custom font you select. These fonts are hosted on the Google Fonts Directory.</p>
		<p><a href="http://code.google.com/webfonts" class="btn-link">Browse Fonts</a>&nbsp;&nbsp;
		<a href="http://code.google.com/apis/webfonts/" class="btn-link">Learn More</a></p>		
	</div>
</div>