<div id="topnav-tab" class="ui-tabs-hide">
	<div id="topnav-options" class="options-panel">
	    <h3>Top Menu Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('topnav', 'topnavdata')); ?>
		</ol>
	</div>
	<div id="topnav-info" class="info-panel">
		<h3>Top Navigation block</h3>
		<p class="teaser">This block is used for your sites horizontal navigation (if enabled) 
		&amp; can be positioned above or below the branding block.</p>
		
		<p>The settings this tab only control how the top navigation block is structured. In order 
		to actually configure how your sites navigation works, you'll need to configure the menu 
		tab using the link below.</p>

		<p><a href="#" class="menu-tab btn-link">Configure your menu settings</a></p>
	</div>
</div>