<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="shareit-tab" class="ui-tabs-hide">
	<div id="shareit-options" class="options-panel">
	    <h3><?= @text('Shareit Settings') ?></h3>
		<ol class="forms">
			<?= @params(array('shareit' => 'shareitdata')); ?>
		</ol>
	</div>
	<div id="shareit-info" class="info-panel">
		<h3><?= @text('Shareit') ?></h3>
		<p class="teaser"><?= @text('The ShareIt plugin adds an option to your Joomla article page, allowing your sites visitors to share the page on various social websites.') ?></p>
	</div>
</div>

