<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="mainhead-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="mainhead-options" class="options-panel">
   	    <h3>Masthead Settings</h3>
		<ol class="forms">
			<?= @params(array('name' => 'masthead')) ?>
		</ol>
	</div>
	<div id="mainhead-info" class="info-panel">
		<h3>Masthead (Main Header)</h3>
		<p class="teaser">This block is typically used for your sites branding / logo. Check the 
		<a href="#" class="logo-tab">logo tab</a> to customize your logo settings.</p>
		
		<p>In most cases this area will be used for your sites branding / logo, but in order to make 
		Morph as flexible as possible, we have given you the option to use a module position instead 
		(branding). The module chrome option on the left is only relevant if the module option is chosen.</p>

		<p><a href="#" class="upload-logo btn-link">Upload a new logo</a>&nbsp;&nbsp;<a href="#" 
		class="logo-tab btn-link">Configure your logo settings</a></p>
	</div>
</div>