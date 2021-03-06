<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="outer-shelves-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="shelf-options" class="options-panel">
   	    <h3>Top Shelf 1 Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('topshelf1', 'topshelf1data')); ?>
		</ol>
		<h3>Top Shelf 2 Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('topshelf2', 'topshelf2data')); ?>
		</ol>
		<h3>Top Shelf 3 Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('topshelf3', 'topshelf3data')); ?>
		</ol>
   	    <h3>Bottom Shelf 1 Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('bottomshelf1', 'bottomshelf1data')); ?>
		</ol>
		<h3>Bottom Shelf 2 Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('bottomshelf2', 'bottomshelf2data')); ?>
		</ol>
		<h3>Bottom Shelf 3 Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('bottomshelf3', 'bottomshelf3data')); ?>
		</ol>
	</div>
	<div id="shelves-info" class="info-panel">
		<h3>Top &amp; Bottom Shelves</h3>
		<p class="teaser">The top &amp; bottom shelves are outside of the main content block. 
		This means that although the contents are constrained to the overall sites width, they can be 
		configured to have a "wrapping div", which will span the full width of the browser window. These are useful when you need the blocks background to span the full width of the browser.</p>
		<img src="components/com_configurator/images/outershelf-block-outlines.png" alt="outer blocks diagram" />	
	</div>
</div>