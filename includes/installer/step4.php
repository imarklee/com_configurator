<div id="sd-header">
		<!-- <img src="components/com_configurator/images/morph-logo.png" alt="morph logo" width="173" height="60" border="0" /> -->
		<img src="../com_configurator/images/morph-logo.png" alt="morph logo" width="173" height="60" border="0" />
		<p class="steps"><strong>Step 4 of 4: </strong>Customize your setup</p>
	</div>
	<div id="sd-body">
		<div id="sd-text">
			
			<h3>Customize your install setup</h3>
			<p>This step is where you choose exactly what gets installed. Please be advised
			that this option does interact with your site's database, so it is important
			to make you sure you read through each option carefully.</p>
			<h4>Customize your install:</h4>
			<form id="install-themelet" method="post" action="#">
				<ul>
					<li>
						<input type="checkbox" name="all-options" id="all-options" />
						<label for="all-options"><strong>Select all of the options below</strong></label>
						<ul>
							<li>
								<input type="checkbox" name="sample-options" id="sample-options" />
								<label for="sample-options"><strong>Sample sections, categories &amp; content</strong></label>
							</li>
							<li>
								<input type="checkbox" name="typo-options" id="typo-options" />
								<label for="typo-options"><strong>Example typography page</strong></label>
							</li>
							<li>
								<input type="checkbox" name="core-options" id="core-options" />	
								<label for="core-options"><strong>Core Joomla! modules configuration</strong></label>								
							</li>
							<li>	
								<input type="checkbox" name="menu-options" id="menu-options" />
								<label for="menu-options"><strong>Example menu items</strong></label>
							</li>
						</ul>
					</li>
					<li>
						<input type="checkbox" name="database-options" id="database-options" />
						<label for="database-options"><strong>Backup your entire database</strong> (recommended)</label>
					</li>
				</ul>
		</div>
		<input class="action" type="submit" value="submit" />
		<!--<a href="#" class="btn-install">Install Template</a> old button -->
		</form>
		<a href="index.php?option=com_configurator&task=manage" class="btn-skip">Skip this step</a>
	</div>
	<div id="sd-image">
		<!-- <img src="components/com_configurator/images/loader3.gif" height="16" width="16" border="0" align="center" alt="Loading" /> -->
		<img src="../com_configurator/images/loader3.gif" height="16" width="16" border="0" align="center" alt="Loading" />
	</div>