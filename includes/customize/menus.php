<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="menus-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="menu-options" class="options-panel">
	    <h3>Horizontal Menu Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('menu', 'menudata')); ?>
		</ol>
	</div>
	<div id="menu-info" class="info-panel">
		<h3>Menu overview</h3>
		<p class="teaser">Morph gives you a number of different menus to choose from as well 
		as the ability to customize how they work. We will be adding a full page to explain 
		how to take advantange of the different menus that are available.</p>
		
		<p>Most of Morphs menu settings are here, but in order to activate one of the different 
		menu types, you need to add the appropriate module suffix.</p>
		<p><a href="#" class="topnav-tab btn-link">Configure the <strong>Top Menu</strong> 
		block</a>&nbsp;&nbsp;<a href="menufx.html" title="Understanding Morphs menus" 
		class="topnav-tab btn-link modal-link">Learn more </a></p>
	</div>
</div>