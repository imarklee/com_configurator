<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="tools-installer">
	<div id="uploader">
	    <h2>Universal Installer</h2>		
		<div class="upload-tool">
			<fieldset id="install-type">
				<h3>Install</h3>
				<label for="upload_template"> <input type="radio" name="upload_type" value="template" id="upload_template" />Upgrade Morph</label>
				<label for="upload_themelet"> <input type="radio" name="upload_type" value="themelet" id="upload_themelet" />Install / Upgrade Themelet</label>
				<label for="upload_themelet_assets"><input type="radio" name="upload_type" value="themelet_assets" id="upload_themelet_assets" />Upload Themelet Assets</label>
				<label for="upload_sample"><input type="radio" name="upload_type" value="sample" id="upload_sample" />Install Demo Content</label>
				<h3>Upload</h3>
				<label for="upload_logo"><input type="radio" name="upload_type" value="logo" id="upload_logo" />Your Site's Logo</label>
				<label for="upload_background"><input type="radio" name="upload_type" value="background" id="upload_background" />A Background Image</label>
				<label for="upload_iphone"><input type="radio" name="upload_type" value="iphone" id="upload_iphone" />iPhone Header/Webclip</label>
				<label for="upload_favicon"><input type="radio" name="upload_type" value="favicon" id="upload_favicon" />A Favicon</label>
			</fieldset>
			<fieldset id="select-file">
			    <h4><strong>Step 1:</strong> Choose an install type</h4>
				<p class="install-desc">Select an install type on the left, then select the file you want to install/upload.</p>
				<h4><strong>Step 2:</strong> Then select a file &amp; install</h4>
				<p class="file-input">
				<input type="file" id="insfile" name="insfile" class="input-installer" /></p>
				<a href="#" id="uploader-btn" class="btn-primary"><span><strong>Upload</strong> and install</span></a>
			</fieldset>	
		</div>
    	<div class="note">
    	    <div class="note-inner">
    	        <h3>About this tool:</h3>
        		<p>Select the type of file you would like to install below. Once you have installed your chosen file type, 
        		open the "customization settings" tab on the left.</p>
        		<p>All of these files (including backups) are located in your "morph_assets" folder.</p>
            </div>
        </div>
	</div>
	<div id="upload-message" style="display:none;"></div>
</div>