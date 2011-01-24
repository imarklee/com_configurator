<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="fontsizer-tab" class="ui-tabs-hide">
	<div id="fontsizer-options" class="options-panel">
	    <h3><?= @text('Fontsizer Settings') ?></h3>
		<ol class="forms">
			<?= @params(array('name' => 'fontsizer')); ?>
		</ol>
	</div>
	<div id="fontsizer-info" class="info-panel">
		<h3><?= @text('Fontsizer') ?></h3>
		<p class="teaser"><?= @text('This will enable a text resizer on your Joomla article page, allowing your readers to increase or descrease the size of the article body text.') ?></p>
		<p> </p>
	</div>
</div>