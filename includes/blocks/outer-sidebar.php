<div id="outer-sidebar-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="outer-sidebar-options" class="options-panel">
	    <h3>Outer Sidebar (Left) Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('outersidebar', 'outersidebardata')); ?>
		</ol>
	    <h3>Split Left Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('splitleft', 'splitleftdata')); ?>
		</ol>
	    <h3>Top Left Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('topleft', 'topleftdata')); ?>
		</ol>
	    <h3>Left Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('left', 'leftdata')); ?>
		</ol>
	    <h3>Bottom Left Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('bottomleft', 'bottomleftdata')); ?>
		</ol>
	</div>
	<div id="outer-sidebar-info" class="info-panel">
		<h3>Outer sidebar (left)</h3>
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