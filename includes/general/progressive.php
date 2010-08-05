<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="progressive-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="progressive-options" class="options-panel">
		<h3>Progressive Enhancements Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('progressive', 'progressivedata')); ?>
		</ol>
	</div>
	<div id="progressive-info" class="info-panel">
		<h3>Progressive Enhancements overview</h3>
		<p class="teaser">These are the subtle enhancements that are layered onto your site, as 
		browsers can support them. Morph has a number of these that take place automatically in 
		the background.</p>
		
		<p>Some examples of progressive enhancements that take place in Morph include the adding 
		of first &amp; last classes where needed, custom classes added to form elements, article 
		intro paragraph, image aligment classes, zebra striping on table rows, rounded corners, 
		equal heights &amp; more.</p>
	</div>
</div>