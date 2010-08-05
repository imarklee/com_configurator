<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="subhead-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="subhead-options" class="options-panel">
	    <h3>Sub Header Block</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('subhead', 'subheaddata')); ?>
		</ol>
	</div>
	<div id="subhead-info" class="info-panel">
		<h3>Sub header block</h3>
		<p class="teaser">This block can be used compliment your sites branding, but is not limited to that.</p>
		
		<p>Some possible uses for this block could be an css background image, image rotator, slideshow, tabs block, intro video, etc.</p>
	</div>
</div>