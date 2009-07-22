<div id="tools-installer">
	<div id="uploader">
		<div class="upload-tool">
		<h3>Universal Installer</h3>		
			<fieldset id="install-type">
				<legend><strong>Step 1: </strong>Choose install type</legend>
				<label for="upload_themelet"> <input type="radio" name="upload_type" value="themelet" id="upload_themelet">Themelet</label>
				<label for="upload_logo"><input type="radio" name="upload_type" value="logo" id="upload_logo">Logo</label>
				<label for="upload_background"><input type="radio" name="upload_type" value="background" id="upload_background">Background</label>
				<label for="upload_favicon"><input type="radio" name="upload_type" value="favicon" id="upload_favicon">Favicon</label>
			</fieldset>
			
			<fieldset id="select-file">
				<legend><strong>Step 2: </strong>Select file to install</legend>
				<input type="file" id="insfile" name="insfile" class="input-installer" />
			</fieldset>
				
			<fieldset id="upload-install">
				<legend><strong>Step 3: </strong>Upload &amp; install</legend>
				<input id="uploader-button" type="button" class="fg-button ui-state-default ui-corner-all" value="Install" />
			</fieldset>	
		</div>
		<div class="upload-info">
		<h4>About this tool</h4>
		<p>Select the type of file you would like to install below. Once you have installed your chosen file type, open the "customization settings" tab on the left.</p>
		<p>All of these files (including backups) are located in your template's "assets" folder. Click here to read more about how to best utilize this feature.</p>
		</div>
	</div>
	<div id="upload-message"></div>
</div>