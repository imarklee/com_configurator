<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="megamenu-tab" class="ui-tabs-hide">
	<div id="megamenu-options" class="options-panel">
	    <h3>Mega Shelf Menu Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('megamenu', 'megamenudata')); ?>
		</ol>
	</div>
	<div id="megamenu-info" class="info-panel">
		<h3>Mega Shelf Menu</h3>
		<p class="teaser"></p>
	</div>
</div>

