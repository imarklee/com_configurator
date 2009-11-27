<div id="lazyload-tab" class="ui-tabs-hide">
	<div id="lazyload-options" class="options-panel">
	    <h3>Lazyload Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('lazyload', 'lazyloaddata')); ?>
		</ol>
	</div>
	<div id="lazyload-info" class="info-panel">
		<h3>Lazyload images</h3>
		<p class="teaser">Lazy loader is a jQuery plugin that delays the loading of images in (long) web pages.</p>
		<p>Images outside of viewport (visible part of web page) wont be loaded before user scrolls to them. This is opposite of image preloading.</p>
	</div>
</div>

