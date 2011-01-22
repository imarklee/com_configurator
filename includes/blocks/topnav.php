<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="topnav-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="topnav-options" class="options-panel">
		<h3>Menu Block Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('topnav', 'topnavdata')); ?>
		</ol>
		<h3>Menu Customization Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('menu', 'menudata')); ?>
		</ol>
	</div>
	<div id="topnav-info" class="info-panel">
		<h3>Menu overview</h3>
		<p class="teaser">Morph gives you a number of different menus to choose from as well 
		as the ability to customize how they work.<br /><br />The menu can be positioned before or after any of Morphs blocks. Simply select where you would like the menu to output via the Topnav position setting.</p>
		<p>Most of Morphs menu settings are here, but in order to activate one of the different 
		menu types, you need to add the appropriate module suffix.</p>
		<p><a href="menufx.html" title="Understanding Morphs menus" 
		class="topnav-tab btn-link modal-link">Learn more </a></p>
	</div>
</div>