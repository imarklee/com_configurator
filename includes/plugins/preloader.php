<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="preloader-tab" class="ui-tabs-hide">
	<div id="preloader-options" class="options-panel">
	    <h3>Preloader Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('preloader', 'preloaderdata')); ?>
		</ol>
	</div>
	<div id="preloader-info" class="info-panel">
		<h3>Preloader</h3>
		<p class="teaser">This feature uses the QueryLoader jQuery plugin to give you an animated loading overlay while your site is loaded.</p>
		<p><a href="http://www.gayadesign.com/diy/queryloader-preload-your-website-in-style/" target="_blank" class="btn-link">Visit Plugin</a></p>
	</div>
</div>