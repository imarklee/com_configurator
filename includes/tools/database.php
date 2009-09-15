<?php
$db = JFactory::getDBO();
$query = $db->setQuery("select param_value from #__configurator where param_name = 'themelet';");
$curr_themelet = $db->loadResult($query);
?>
<div id="database-manager">
	<form action="#" method="post" id="db-manager">
	    <h2>Export / Import Manager</h2>
		<ul>
		    <li><label><input type="radio" name="dbmanage" value="export">Export</input></label>
    			<ul>
    				<li><label><input type="checkbox" name="export_data[]" value="full-database"> Entire Database</label></li>
    				<li><label><input type="checkbox" name="export_data[]" value="themelet-settings <?php echo $curr_themelet; ?>"> Current Themelet Settings</label></li>
    				<li><label><input type="checkbox" name="export_data[]" value="configurator-settings"> Configurator Settings</label></li>
    				<li><label><input type="checkbox" name="export_data[]" value="configurator-preferences"> Configurator Preferences</label></li>
    			</ul>
		    </li>
		    <li><label><input type="radio" name="dbmanage" value="import">Import</input></label>
			    <ul>
				    <li><input type="file" name="import_file" id="import_file"></li>
				</ul>
		    </li>
		    <li class="action">
		    	<input type="submit" name="db-do" value="Submit" id="db-do">
		    </li>
		</ul>
	</form>
</div>