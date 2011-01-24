<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="reset-settings">
	<h2><?= @text("Reset Configurator's Settings") ?></h2>
	<div class="note">
	    <div class="note-inner">
    	    <h3><?= @text('About this tool:') ?></h3>
	        <p><?= @text('You can use this tool to reset your Configurator Settings and/or Preferences. This tool is not recommended on production
	        sites as it will revert your install back to its initial setup.') ?></p>
	        <p><?= @text('A backup will be created and will be available to download or reset from the Backup Manager tab.') ?></p>
	    </div>
	</div>
	<ul>
	    <li><label><input type="checkbox" name="reset-prefs" value="prefs" /> <?= @text('Reset your Configurator preferences') ?></label></li>
		<li><label><input type="checkbox" name="reset-cfg" value="cfg" /> <?= @text('Reset your Configurator settings') ?></label></li>
	    <li class="action">
			<label><input type="checkbox" name="reset-confirm" id="reset-confirm" value="true" /> <?= @text('Please confirm that you wish to reset your settings.') ?></label>
	    	<a href="#" name="reset-do" id="reset-do" class="tools-btn"><?= @text('Reset') ?></a>
	    </li>
	</ul>
</div>
