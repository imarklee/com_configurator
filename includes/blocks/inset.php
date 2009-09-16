<div id="insets-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="inset-options" class="options-panel">
	    <h3>Inset1 Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('inset1', 'inset1data')); ?>
		</ol>
	    <h3>Inset2 Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('inset2', 'inset2data')); ?>
		</ol>
	    <h3>Inset3 Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('inset3', 'inset3data')); ?>
		</ol>
	    <h3>Inset4 Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('inset4', 'inset4data')); ?>
		</ol>
	</div>
	<div id="inset-info" class="info-panel">
		<h3>Inset block overview</h3>
		<p class="teaser">One of the challenges with Morph was to predict all the possible 
		ways that our members would want to use it. We realize this is almost </p>
		<p>There are four inset positions available &amp; each can be configured differently. 
		The diagram below indicates how the inset positions are structured:</p>
		<p><img src="components/com_configurator/images/insets-layout.png" alt="insets layout 
		map" border="0" width="355" height="168" />
	</div>
</div>