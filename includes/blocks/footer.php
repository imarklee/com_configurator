<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="footer-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="footer-options" class="options-panel">
	    <h3><?= @text('Footer Block Options') ?></h3>
		<ol class="forms">
			<?= @params(array('name' => 'footer')) ?>
		</ol>
	</div>
	<div id="footer-info" class="info-panel">
		<h3><?= @text('Footer block overview') ?></h3>
		<p class="teaser"><?= @text('We have tried to make the footer block as easy to customize as possible.</p>
		<p>Although there is an option to disable / change the credits, we do ask that you consider leaving 
		the "Morph Inside" link intact to help us promote Morph to a greater audience.') ?></p>
	</div>
</div>