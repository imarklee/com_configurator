<?php
$db = JFactory::getDBO();
$query = $db->setQuery("select param_value from #__configurator where param_name = 'themelet';");
$curr_themelet = $db->loadResult($query);
?>
<div id="reset-settings">
	<h2>Reset Configurator</h2>
	<div class="warning"><div class="warning-inner">You can use this tool to reset your Configurator Settings and/or Preferences. This tool is not recommended on production
		sites as it will revert your install back to its initial setup. <strong>Use with caution.</strong></div></div>
		
	<ul>
	    <li><label><input type="checkbox" name="reset-prefs" value="prefs" />Reset your Configurator Preferences</label>
		<li><label><input type="checkbox" name="reset-cfg" value="cfg" />Reset your Configurator Settings</label>
	    <li class="action">
			<ul>
				<li><label><input type="checkbox" name="reset-confirm" id="reset-confirm" value="true" />Please confirm that you wish to reset your tables.</label>
			</ul>
	    	<a href="#" name="reset-do" id="reset-do">Reset</a>
	    </li>
	</ul>
</div>
