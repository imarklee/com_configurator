<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="performance-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="performance-options" class="options-panel">
		<h3>Performance Settings</h3>
		<ol class="forms">
			<?= @params(array('name' => 'performance')); ?>
		</ol>
	</div>
	<div id="performance-info" class="info-panel">
		<h3>Performance overview</h3>
		<p class="teaser">Our aim is to make Morph as optimized as possible &amp; though this is something we will constantly improve &amp; build on, there are already a number of ways you can take advantage of.</p>
		<p>Once Morph is stable we will be publishing a series of articles about ways you can further optimize your sites performance. The articles will cover things that are not possible to do from within Morph - such as enabling gzip on your server, including your sites assets in a subdomain, taking advantage of services like Amazon S3, etc.</p>
	</div>
</div>