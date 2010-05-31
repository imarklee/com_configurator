<div id="enhancements-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="enhancements-options" class="options-panel">
		<h3>Article view enhancements</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('article_enhancements', 'article_enhancementsdata')); ?>
		</ol>
		<h3>Blog view enhancements</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('blog_enhancements', 'blog_enhancementsdata')); ?>
		</ol>
	</div>
	<div id="enhancements-info" class="info-panel">
		<h3>Core Enhancements overview</h3>
		<p class="teaser">The Core Enhancements extend Joomla's core functionality.</p>
		<p>Choose which of these enhancements are enabled.</p>	
	</div>
</div>