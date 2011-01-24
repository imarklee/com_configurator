<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="toolbar-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="toolbar-options" class="options-panel">
	    <h3><?= @text('Toolbar Block Settings') ?></h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('toolbar', 'toolbardata')); ?>
		</ol>
	</div>
	<div id="toolbar-info" class="info-panel">
		<h3><?= @text('Toolbar block overview') ?></h3>
		<p class="teaser"><?= @text('The toolbar block is a general utilities bar and can be used for a number of different functions.') ?></p>
		<p><?= @text('The toolbar block is a general utilities bar and can be used for a number of different functions. This block can be 
		positioned in 4 different areas, giving you additional flexibility with how you use it.') ?></p>
	</div>
</div>