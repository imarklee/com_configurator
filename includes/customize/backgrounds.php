<div id="backgrounds-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="background-options" class="options-panel">
		<h3>Html Background Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('htmlbackgrounds', 'htmlbackgroundsdata')); ?>
		</ol>
		<h3>Body Background Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('bodybackgrounds', 'bodybackgroundsdata')); ?>
		</ol>
	</div>
	<div id="background-info" class="info-panel">
		<h3>Backgrounds overview</h3>
		<p class="teaser">These options allow you to easily customize your sites background.</p>
		<p>Looking for a custom background image? Here is a list of our favorite (free) background pattern generators:</p>	
		<ul class="morph-resources">
			<li><a href="http://pattern8.com" title="click here to open this site in a new window" target="_blank">Pattern8</a></li>
			<li><a href="http://bgpatterns.com" title="click here to open this site in a new window" target="_blank">BgPatterns</a></li>
			<li><a href="http://www.stripemania.com" title="click here to open this site in a new window" target="_blank">StripeMania</a></li>
			<li><a href="http://www.tartanmaker.com" title="click here to open this site in a new window" target="_blank">TartanMaker</a></li>
			<li><a href="http://www.colourlovers.com/patterns/add" title="click here to open this site in a new window" target="_blank">ColourLovers</a></li>
		</ul>
	</div>
</div>