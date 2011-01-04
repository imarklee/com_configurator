<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="insets-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="inset-options" class="options-panel">
	    <h3>Inset1 Settings</h3>
		<ol class="forms">
			<?= @params(array('name' => 'inset1')) ?>
		</ol>
	    <h3>Inset2 Settings</h3>
		<ol class="forms">
			<?= @params(array('name' => 'inset2')) ?>
		</ol>
	    <h3>Inset3 Settings</h3>
		<ol class="forms">
			<?= @params(array('name' => 'inset3')) ?>
		</ol>
	    <h3>Inset4 Settings</h3>
		<ol class="forms">
			<?= @params(array('name' => 'inset4')) ?>
		</ol>
	</div>
	<div id="inset-info" class="info-panel">
		<h3>Inset block overview</h3>
		<p class="teaser">One of the challenges with Morph was to predict all the possible 
		ways that our members would want to use it. We realize this is almost </p>
		<p>There are four inset positions available &amp; each can be configured differently. 
		The diagram below indicates how the inset positions are structured:</p>
		<p><img src="components/com_configurator/images/insets-layout.png" alt="insets layout 
		map" border="0" width="355" height="168" /></p>
	</div>
</div>

