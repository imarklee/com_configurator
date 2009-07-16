<div id="sd-header">
		<img src="components/com_configurator/images/morph-logo.png" alt="morph logo" width="173" height="60" border="0" />
		<!-- <img src="../com_configurator/images/morph-logo.png" alt="morph logo" width="173" height="60" border="0" /> -->
		<p class="steps"><strong>Step 4 of 4: </strong>Customize your setup</p>
	</div>
	<div id="sd-body">
		<div id="sd-text">
			
			<h3>Customize your install setup</h3>
			<p>This step is where you choose exactly what gets installed. Please be advised
			that this option does interact with your site's database, so it is important
			to make you sure you read through each option carefully.</p>
			<h4>Customize your install:</h4>
			<form id="install-sample" method="post" action="#">
				<ul>
					<li>
						<input type="checkbox" name="all-options" id="all-options" />
						<label for="all-options"><strong>Select all of the options below</strong></label>
						<ul>
							<li>
								<label><input type="checkbox" name="sample-options[]" id="sample-options" value="sample" />
								<strong>Sample content & example typography</strong></label>
							</li>
							<li>
								<label><input type="checkbox" name="sample-options[]" id="module-options" value="module" />	
								<strong>ModFX module examples</strong></label>								
							</li>
							<li>	
								<label><input type="checkbox" name="sample-options[]" id="basic-options" value="basic" />
								<strong>Basic module configuration</strong></label>
							</li>
						</ul>
					</li>
					<li>
						<label><input type="checkbox" name="database-options" id="database-options" checked="checked" value="db" />
						<strong>Backup your entire database</strong> (recommended)</label>
					</li>
				</ul>
		</div>
		<input class="action install-sample" type="submit" value="submit" />
		<!--<a href="#" class="btn-install">Install Template</a> old button -->
		</form>
		<a href="#" class="btn-skip skip-step4">Skip this step</a>
		<a href="#" class="btn-back back-step3">Go back a step</a>
	</div>