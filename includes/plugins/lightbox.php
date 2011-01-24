<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="lightbox-tab" class="ui-tabs-hide">
	<div id="lightbox-options" class="options-panel">
	    <h3><?= @text('Colorbox Lightbox Settings') ?></h3>
		<ol class="forms">
			<?= @params(array('name' => 'lightbox')); ?>
		</ol>
	</div>
	<div id="lightbox-info" class="info-panel">
		<h3><?= @text('Colorbox Lightbox') ?></h3>
		<p class="teaser"><?= @text('Colorbox is a light-weight, customizable lightbox plugin for jQuery, that supports photos, photo groups, slideshows, ajax, inline, and iframed content.') ?></p>
		<p><?= @text("We'll be publishing some tutorials on how you can take advantage of this, but in the mean time you can read more on the official Colorbox website.") ?></p>
		<p><a href="http://colorpowered.com/colorbox/" target="_blank" class="btn-link"><?= @text('Visit Plugin') ?></a> <!--<a href="#" target="_blank" class="btn-link">View Documentation</a>--></p>
	</div>
</div>

