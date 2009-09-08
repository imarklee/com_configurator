<div id="inner-sidebar-tab" class="ui-tabs-hide">
	<div id="inner-sidebar-options" class="options-panel">
	    <h3>Inner Sidebar (Right) Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('inner-sidebar', 'innersidebardata')); ?>
		</ol>
	    <h3>Split Right Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('splitright', 'splitrightdata')); ?>
		</ol>
	    <h3>Top Right Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('topright', 'toprightdata')); ?>
		</ol>
	    <h3>Right Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('right', 'rightdata')); ?>
		</ol>
	    <h3>Bottom Right Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('bottom-right', 'bottomrightdata')); ?>
		</ol>
	</div>
	<div id="inner-sidebar-info" class="info-panel">
		<h3>Inner sidebar (right)</h3>
		<p class="teaser">The concept of the inner &amp; outer layouts require a bit of understanding to 
		grasp, but once you do you will have unparalelled flexibility at your finger tips.</p>
		<p>Based on commonly accepted <em>best practices</em>, we refer to your sites main content as your 
		<strong>primary content</strong> &amp; likewise your two optional sidebars are referred to as your 
		<strong>secondary &amp; tertiary content</strong>. This naming convention relates to the importance 
		of the content &amp; is ordered accordingly in your sites source code.</p>
		
<!--		<h4>Understanding the Inner &amp; Outer layouts</h4>
		<p>The <strong>outer layout</strong> refers to the width and position of your <strong>secondary content</strong>, whereas the <strong>inner layout</strong> refers to the width and position of your <strong>tertiary content</strong>.</p>
		
		<p>Setting the inner &amp; outer layout defaults is only the tip of the iceberg. The true power of these is the ability to control them on a page by page basis, using our PageFX feature.</p>
		
		<p><a class="modal-link btn-link" href="pagefx.html" title="Getting started with PageFX">Learn more about PageFX</a></p>-->
	</div>
</div>