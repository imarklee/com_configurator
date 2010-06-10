<div id="enhancements-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="enhancements-options" class="options-panel">
		<h3>Article view enhancements</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('articleenhancements', 'articleenhancementsdata')); ?>
		</ol>
		<h3>Blog view enhancements</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('blogenhancements', 'blogenhancementsdata')); ?>
		</ol>
	</div>
	<div id="enhancements-info" class="info-panel">
		<h3>Core Enhancements overview</h3>
		<p class="tease">The Core Enhancements extend Joomla's core functionality via the templates html overrides.</p>
		<p>These options let you decided which of these enhancements are enabled.</p>	
	</div>
</div>