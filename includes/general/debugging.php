<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="debugging-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="debugging-options" class="options-panel">
		<h3><?= @text('Debugging Settings') ?></h3>
		<ol class="forms">
			<?= @params(array('name' => 'debugging')) ?>
		</ol>
	</div>
	<div id="debugging-info" class="info-panel">
		<h3><?= @text('Debugging overview') ?></h3>
		<p class="teaser"><?= @text('These options are useful when developing your site and can be used 
		to help you debug any issues you may encounter.') ?></p>
		
		<p><?= @text('The <strong>Debug Modules</strong> option will globabally change all modules to use 
		the "outline" module chrome, giving you a visual breakdown of all the module 
		positions that are being used.') ?></p>
		
		<p><?= @text('Change the <strong>Joomla SEF Setup</strong> option if you are using a 3rd party 
		Search Engine Friendly urls extension and are having issues with Morphs css &amp; js loading.') ?></p>
	</div>
</div>