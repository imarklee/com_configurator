<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="enhancements-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="enhancements-options" class="options-panel">
		<h3><?= @text('Article view enhancements') ?></h3>
		<ol class="forms">
			<?= @params(array('name' => 'articleenhancements')); ?>
		</ol>
		<!--<h3><?= @text('Article module position chromes') ?></h3>
		<ol class="forms">
			<?= @params(array('name' => 'articlepositions')); ?>
		</ol>-->
		<h3><?= @text('Blog view enhancements') ?></h3>
		<ol class="forms">
			<?= @params(array('name' => 'blogenhancements')); ?>
		</ol>
	</div>
	<div id="enhancements-info" class="info-panel">
		<h3><?= @text('Core Enhancements overview') ?></h3>
		<p class="tease"><?= @text('The Core Enhancements extend Joomla\'s core functionality via the templates html overrides.</p>
		<p>These options let you decided which of these enhancements are enabled.') ?></p>
		<!--<h4><?= @text('Article module positions') ?></h4>
		<p><?= @text('There are 6 module positions that you can use to display modules within your content. The module position names are <strong>article_top1-3</strong> &amp; <strong>article_bottom1-3</strong>. To use, simply publish your module to any of the positions &amp; set the module chrome for that position.') ?></p>-->
	</div>
</div>