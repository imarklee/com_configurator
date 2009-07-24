<?php 
if(strpos($_SERVER['SCRIPT_NAME'], 'install.configurator.php') === false){
$base = './components/com_configurator';
}else{
$base = '.';
}
define('JURL', $base);
define('JROOT', str_replace('administrator/components/com_configurator/installer', '', dirname(__FILE__)));
$config = JFactory::getConfig();
$gzipval = $config->getValue( 'config.gzip' ); ?>
?>
<form id="install-sample" class="step3" method="post" action="#">
	<div id="install-head">
		<img src="<?php echo JURL; ?>/installer/images/install-logo.png" alt="morph logo" width="160" height="60" border="0" class="logo" />
		<img src="<?php echo JURL; ?>/installer/images/tagline.png" alt="morph tagline" width="195" height="24" border="0" class="tagline" />
		<p class="steps"><strong>Step 3 of 3: </strong>Quick Setup options</p>
	</div>
	<div id="install-shadow">
	<div id="install-main">	
		<div id="install-title">
			<h2><strong>Step 3:</strong> Configure your Quick Setup</h2>
			<a href="#" class="help-step3">Help with this step</a>
		</div>
		<div id="install-body">
			<h3>Now choose which sample data options should be installed.</h3>
			<p class="alert"><strong>Important!</strong> This step interacts with your site's database. Please ensure you <a href="#" class="help-step3" title="click here for help with this step">read about each option</a> before making a selection. You can also choose to skip this step completely.</p>			

			<h4 class="step4title">Select which <strong>QuickSetup</strong> options should be installed:</h4>
			<ul>
				<li><label for="all-options"><input type="checkbox" name="all-options" id="all-options" /> Select all of the options below</label>
					<ul>
						<li><label><input type="checkbox" name="sample-options[]" id="sample-options" value="sample" />
							Sample content &amp; example typography</label></li>
						<li><label><input type="checkbox" name="sample-options[]" id="module-options" value="module" />	
							ModFX module examples <span></label></li>
						<li><label><input type="checkbox" name="sample-options[]" id="basic-options" value="basic" />
							Basic module configuration</label></li>
					</ul></li>
				<li><label><input type="checkbox" name="database-options" id="database-options" checked="checked" value="db" />
					Backup your entire database (recommended)</label></li>
				<?php
				if(extension_loaded('zlib') && $gzipval == 0){ ?>
				<li><label><input type="checkbox" name="gzip-options" id="gzip-options" checked="checked" value="1" />
					Enable GZIP Compression (recommended)</label></li>
				<?php } ?>
			</ul>
		</div>
			
		<div id="install-foot">
			<ul id="action">
				<li class="next"><input class="action install-sample btn-install" type="submit" value="submit" /></li>
				<li class="previous"><a href="#" class="btn-skip back-step2"><span>&raquo; </span>Previous step</a></li>
				<li class="skip"><a href="#" class="btn-skip skip-step3">Skip this step<span> &raquo;</span></a></li>
			</ul>
		</div>
	</div>	
	</div>
</form>