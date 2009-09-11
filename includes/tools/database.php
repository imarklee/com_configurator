<div id="database-manager">
	
	<form action="#" method="post" id="db-manager">
		<h3>Select an action</h3>
		<ul class="actions">
		<li><label><input type="radio" name="dbmanage" value="export">Export</input></label>
			<ul>
				<li><label><input type="checkbox" name="export_all">Entire Database</label></li>
				<li><label><input type="checkbox" name="export_themelet">Current Themelet Settings</label></li>
				<li><label><input type="checkbox" name="export_cfg">Configurator Settings</label></li>
				<li><label><input type="checkbox" name="export_cfgprefs">Configurator Preferences</label></li>
			</ul>
		</li>
		<li><label><input type="radio" name="dbmanage" value="import">Import</input></label>
			<ul>
				<li><input type="file" name="import_file"></li>
		</li>
		</ul>
		<input type="submit" name="db-do" value="Submit" id="db-do">
	</form>
</div>