<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="enhancements-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="enhancements-options" class="options-panel">
		<h3><?= @text('Article view enhancements') ?></h3>
		<ol class="forms">
			<?= @params(array('articleenhancements' => 'articleenhancementsdata')); ?>
		</ol>
		<h3><?= @text('Blog view enhancements') ?></h3>
		<ol class="forms">
			<?= @params(array('blogenhancements' => 'blogenhancementsdata')); ?>
		</ol>
	</div>
	<div id="enhancements-info" class="info-panel">
		<h3><?= @text('Core Enhancements overview') ?></h3>
		<p class="tease"><?= @text('The Core Enhancements extend Joomla's core functionality via the templates html overrides.</p>
		<p>These options let you decided which of these enhancements are enabled.') ?></p>	
	</div>
</div>