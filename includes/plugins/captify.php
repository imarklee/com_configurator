<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="captify-tab" class="ui-tabs-hide">
	<div id="captify-options" class="options-panel">
	    <h3><?= @text('Fancy Captions Settings') ?></h3>
		<ol class="forms">
			<?= @params(array('captify' => 'captifydata')); ?>
		</ol>
	</div>
	<div id="captify-info" class="info-panel">
		<h3><?= @text('Fancy captions') ?></h3>
		<p class="teaser"><?= @text('This plugin lets you easily add fancy captions to any of your contents images.') ?></p>
		<p><?= @text('To use, simply add an image to your Joomla article using the default insert image button, then in the image lightbox:') ?></p>
	    <ol>
    		<li><?= @text('Add the text you would like displayed in the <strong>image description</strong> input.') ?></li>
    		<li><?= @text('Optionally add a <strong>title</strong> describing the image (recommended).') ?></li>
    		<li><?= @text('Tick the <strong>caption</strong> checkbox.') ?></li>
    		<li><?= @text('Set the <strong>image alignment</strong>.') ?></li>
    		<li><?= @text('Click the <strong>insert</strong> button on the top right of the popup.') ?></li>
        </ol>
	</div>
</div>

