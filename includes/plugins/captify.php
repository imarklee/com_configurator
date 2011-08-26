<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="captify-tab" class="ui-tabs-hide">
	<div id="captify-options" class="options-panel">
	    <h3><?= @text('Fancy Captions Settings') ?></h3>
		<ol class="forms">
			<?= @params(array('name' => 'captify')); ?>
		</ol>
	</div>
	<div id="captify-info" class="info-panel">
		<h3><?= @text('Fancy captions') ?></h3>
		<?= @text('This plugin lets you easily add fancy captions to any of your contents images.</p>
		<p>To use, simply add an image to your Joomla article using the default insert image button, then in the image lightbox:</p>
	    <ol>
    		<li>Add the text you would like displayed in the <strong>image description</strong> input.</li>
    		<li>Optionally add a <strong>title</strong> describing the image (recommended).</li>
    		<li>Tick the <strong>caption</strong> checkbox.</li>
    		<li>Set the <strong>image alignment</strong>.</li>
    		<li>Click the <strong>insert</strong> button on the top right of the popup.</li>
        </ol>') ?>
	</div>
</div>

