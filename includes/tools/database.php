<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php $curr_themelet = KFactory::get('admin::com.configurator.model.configurations')->getItem()->themelet ?>
<div id="database-manager">
	<h2>Export / Import Manager</h2>
	<ul>
	    <li><label><input type="radio" name="dbmanage" value="export" /> <?= @text('Export') ?></label>
   			<ul>
   				<li><label><input type="checkbox" name="export_data[]" value="full-database" /> <?= @text('Entire Database') ?></label></li>
   				<li><label><input type="checkbox" name="export_data[]" value="themelet-settings <?php echo $curr_themelet; ?>" /> <?= @text('Current Themelet Settings') ?></label></li>
   				<li><label><input type="checkbox" name="export_data[]" value="configurator-settings" /> <?= @text('Configurator Settings') ?></label></li>
   				<li><label><input type="checkbox" name="export_data[]" value="configurator-preferences" /> <?= @text('Configurator Preferences') ?></label></li>
   			</ul>
	    </li>
	    <li><label><input type="radio" name="dbmanage" value="import" /> <?= @text('Import') ?></label>
		    <ul>
			    <li><input type="file" name="import_file" id="import_file" /></li>
			</ul>
	    </li>
	    <li class="action">
	    	<a href="#" name="db-do" id="db-do" class="tools-btn"><?= @text('Submit') ?></a>
	    </li>
	</ul>
	<div class="note">
	    <div class="note-inner">
    	    <h3><?= @text('About this tool:') ?></h3>
    	    <p><?= @text('This tool is aimed at making the process of importing and exporting your various Configurator or themelet settings easier.') ?></p>
    	    <p><?= @text('You will be given the option to download a backup of your existing settings when importing.') ?></p>
        </div>
    </div>
</div>