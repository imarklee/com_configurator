<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="general-tab" class="ui-tabs-panel">
	<div id="general-options" class="options-panel">
		<h3>General Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('general', 'generaldata')); ?>
		</ol>
	</div>
	<div id="general-info" class="info-panel">
		<h3>Not sure what a themelet is?</h3>
		<p class="teaser">This is where you set your sites width and which themelet you would like to use. Themelets (also known as child themes) handle the visual aspect of Morph. <a class="modal-link" href="themelets.html" title="What is a themelet?">Click here to learn more</a></p>
		
		<h4>Where to from here?</h4>
		<p>New themelets can be installed from the <strong>Toolbox</strong> tab, viewed in the <strong>Assets</strong> tab and customized in the <strong>Customize</strong> tab.</p>
	</div>
</div>