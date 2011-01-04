<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="main-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="main-options" class="options-panel">
	    <h3>Main Block Settings</h3>
		<ol class="forms">
			<?= @params(array('name' => 'main')) ?>
		</ol>
	</div>
	<div id="main-info" class="info-panel">
		<h3>Main block</h3>
		<p class="teaser">The main block wraps around your sites content &amp; sidebars.</p>
		
		<p>Everything related to the inner (right) and outer (left) sidebars can be found in the Sidebars tab.</p>
		
		<p><a href="#" class="sidebar-tab btn-link" id="sidebar-link">Go to the Sidebars tab</a></p>
	</div>
</div>