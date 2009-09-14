<div id="database-manager">
	<form action="#" method="post" id="db-manager">
	    <h2>Export / Import Manager</h2>
		<ul>
		    <li><label><input type="radio" name="dbmanage" value="export">Export</input></label>
    			<ul>
    				<li><label><input type="checkbox" name="export_all"> Entire Database</label></li>
    				<li><label><input type="checkbox" name="export_themelet"> Current Themelet Settings</label></li>
    				<li><label><input type="checkbox" name="export_cfg"> Configurator Settings</label></li>
    				<li><label><input type="checkbox" name="export_cfgprefs"> Configurator Preferences</label></li>
    			</ul>
		    </li>
		    <li><label><input type="radio" name="dbmanage" value="import">Import</input></label>
			    <ul>
				    <li><input type="file" name="import_file"></li>
				</ul>
		    </li>
		    <li class="action">
		    	<input type="submit" name="db-do" value="Submit" id="db-do">
		    </li>
		</ul>
	</form>
</div>