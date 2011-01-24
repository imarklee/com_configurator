<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="lazyload-tab" class="ui-tabs-hide">
	<div id="lazyload-options" class="options-panel">
	    <h3><?= @text('Lazyload Settings') ?></h3>
		<ol class="forms">
			<?= @params(array('lazyload' => 'lazyloaddata')); ?>
		</ol>
	</div>
	<div id="lazyload-info" class="info-panel">
		<h3><?= @text('Lazyload images') ?></h3>
		<p class="teaser"><?= @text('Lazy loader is a jQuery plugin that delays the loading of images in (long) web pages.') ?></p>
		<p><?= @text('Images outside of viewport (visible part of web page) wont be loaded before user scrolls to them. This is opposite of image preloading.') ?></p>
	</div>
</div>

