<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="fonts-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="fonts-options" class="options-panel">
		<h3><?= @text('Custom Fonts') ?></h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('customfonts', 'customfontsdata')); ?>
		</ol>
	</div>
	<div id="fonts-info" class="info-panel">
		<h3><?= @text('Using Google Fonts') ?></h3>
		<p class="teaser"><?= @text('If enabled, this will replace your standard H1 and H2 fonts with the custom font you select. These fonts are hosted on the Google Fonts Directory.') ?></p>
		<p><a href="http://code.google.com/webfonts" class="btn-link"><?= @text('Browse Fonts') ?></a>&nbsp;&nbsp;
		<a href="http://code.google.com/apis/webfonts/" class="btn-link"><?= @text('Learn more') ?></a></p>		
	</div>
</div>