<div id="sd-header">
		<img src="components/com_configurator/images/morph-logo.png" alt="morph logo" width="173" height="60" border="0" />
		<!-- <img src="../com_configurator/images/morph-logo.png" alt="morph logo" width="173" height="60" border="0" /> -->
		<p class="steps"><strong>Step 2 of 4: </strong>Install Template Framework</p>
	</div>
	<div id="sd-body">
		<div id="sd-text">
			
			<h3>Install the Morph template framework</h3>
			<p>We are now going to install the Morph Framework. If you have a previously installed version,
			you can either choose to skip this step or proceed with the install. If you proceed, a backup
			of the previous version will automatically be created.</p>
			<form id="install-template" method="post" action="../../../administrator/index.php?option=com_configurator&task=installTemplate&format=raw&backup=false" enctype="multipart/form-data">
				<label>
					<h4>Select the template framework install file:</h4>
					<input type="file" name="template-file" id="template-file" />
				</label>
				<label>
				<input type="checkbox" name="backup_template" id="backup_template" checked="checked" value="true" />
				Backup your existing template?
				</label>
			
		</div>
		<input class="action install-template" type="submit" value="submit" />
		<!--<a href="#" class="btn-install">Install Template</a> old button -->
		</form>
		<a href="#" class="btn-skip skip-step2">Skip this step</a>
	</div>