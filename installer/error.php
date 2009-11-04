<div id="error-assets" class="dialog-msg">
	<p>Oops. It looks like Configurator was unable to create the required assets folders. 
	<strong>Please note, these folders are required for Morph to function correctly.</strong></p>
	<p>Please select option 1 or 2 below in order to continue.</p>
	
	<p><strong>Option 1</strong><br />
	Click on the "Create Assets" button below, and Configurator will try and create the folders again. 
	If this option is unsuccessful or you would prefer to create the folders yourself, please follow Option 2 below.</p>
	
	<p><strong>Option 2</strong><br />
	Manually create the following folder structure below in the root of your Joomla! install
	and then click the "Refresh" button to continue.</p>
	
	<strong class="sub-heading">Folder Structure</strong>
	<p>The following folders should be writable (755 via FTP or CHMOD)</p>
	<ul>
		<li>morph_assets/
			<ul>
				<li>backgrounds/</li>
				<li>backups/
					<ul>
						<li>db/</li>
					</ul>
				</li>
				<li>logos/</li>
				<li>themelets/</li>
				<li>iphone/</li>
			</ul>
		</li>
		<li>morph_recycle_bin</li>
	</ul>
</div>