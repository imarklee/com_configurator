<?php
$db = JFactory::getDBO();
$query = $db->setQuery("select param_value from #__configurator where param_name = 'themelet';");
$curr_themelet = $db->loadResult($query);
?>
<div id="database-manager">
	<h2>Export / Import Manager</h2>
	<ul>
	    <li><label><input type="radio" name="dbmanage" value="export" /> Export</label>
   			<ul>
   				<li><label><input type="checkbox" name="export_data[]" value="full-database" /> Entire Database</label></li>
   				<li><label><input type="checkbox" name="export_data[]" value="themelet-settings <?php echo $curr_themelet; ?>" /> Current Themelet Settings</label></li>
   				<li><label><input type="checkbox" name="export_data[]" value="configurator-settings" /> Configurator Settings</label></li>
   				<li><label><input type="checkbox" name="export_data[]" value="configurator-preferences" /> Configurator Preferences</label></li>
   			</ul>
	    </li>
	    <li><label><input type="radio" name="dbmanage" value="import" /> Import</label>
		    <ul>
			    <li><input type="file" name="import_file" id="import_file" /></li>
			</ul>
	    </li>
	    <li class="action">
	    	<a href="#" name="db-do" id="db-do" class="tools-btn">Submit</a>
	    </li>
	</ul>
	<div class="note">
	    <div class="note-inner">
    	    <h3>About this tool:</h3>
    	    <p>This tool is aimed at making the process of importing and exporting your various Configurator or themelet settings easier.</p>
    	    <p>You will be given the option to download a backup of your existing settings when importing.</p>
        </div>
    </div>
</div>