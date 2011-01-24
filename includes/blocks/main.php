<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="main-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="main-options" class="options-panel">
	    <h3><?= @text('Main Block Settings') ?></h3>
		<ol class="forms">
			<?= @params(array('name' => 'main')) ?>
		</ol>
	</div>
	<div id="main-info" class="info-panel">
		<h3><?= @text('Main block') ?></h3>
		<p class="teaser"><?= @text('The main block wraps around your sites content &amp; sidebars.') ?></p>
		<p><?= @text('Everything related to the inner (right) and outer (left) sidebars can be found in the Sidebars tab.') ?></p>
		<p><a href="#" class="sidebar-tab btn-link" id="sidebar-link"><?= @text('Go to the Sidebars tab') ?></a></p>
	</div>
</div>