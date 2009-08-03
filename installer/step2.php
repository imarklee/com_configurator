<?php 
if(strpos($_SERVER['SCRIPT_NAME'], 'install.configurator.php') === false){
$base = './components/com_configurator';
}else{
$base = '.';
}
define('JURL', $base);
define('JROOT', str_replace(array('administrator/components/com_configurator/installer','administrator\components\com_configurator\installer'), '', dirname(__FILE__)));
?>
<form id="install-themelet" class="step2" method="post" action="#">
	<div id="install-head">
		<img src="<?php echo JURL; ?>/installer/images/install-logo.png" alt="morph logo" width="160" height="60" border="0" class="logo" />
		<img src="<?php echo JURL; ?>/installer/images/tagline.png" alt="morph tagline" width="195" height="24" border="0" class="tagline" />
		<p class="steps"><strong>Step 2 of 3: </strong>Install your themelet</p>
	</div>
	<div id="install-shadow">
	<div id="install-main">	
		<div id="install-title">
			<h2><strong>Step 2:</strong> Install your themelet</h2>
			<a href="#" class="help-step2">Help with this step</a>
		</div>
		<div id="install-body">
			<h3>In this step, you will install and publish your themelet.</h3>
			<p>Themelets are child themes for Morph and are essentially the seperation of the visual and functional aspects of your template. <a href="#" class="help-step2" title="click here for help with this step" class="step2-help">Click here to learn more</a></p>
			
			<?php if(is_dir(JROOT . 'morph_assets')){ ?>
			<label class="upload"><h4>Select your themelet install file:</h4>
			<input type="file" name="insfile" id="insfile" /></label>
			
			<label class="backup"><input type="checkbox" name="activate_themelet" id="activate_themelet" checked="checked" value="true" />
			Activate themelet (recommended for first time installs)</label>
			<?php } else { ?>

			<div class="assets-warning">
				<strong>Warning! - Assets folder not found.</strong>
				<p>The installer cannot find the assets folder. This is needed to continue with the installation.</p>
				<p><a href="#" class="create-assets">Click here</a> to create the assets folder and its subfolders.</p>
				<p>If you wish, you can manually create these folders using the folder structure below, in the root of your Joomla! install
				and <a href="#" class="refresh-step2">click here</a> to refresh this page and continue.</p>
				
				<strong class="sub-heading">Folder Structure</strong>
				<p>All folders below should be writable - 755 via FTP/chmod.</p>
				<ul>
					<li>morph_assets
						<ul>
							<li>backgrounds</li>
							<li>backups
								<ul>
									<li>db</li>
								</ul>
							</li>
							<li>logos</li>
							<li>themelets</li>
						</ul>
					</li>
				</ul>
			</div>
			<?php } ?>
		</div>	
		<div id="install-foot">
			<ul id="action">
				<?php if(is_dir(JROOT . 'morph_assets')){ ?><li class="next"><input class="action install-themelet btn-install" type="submit" value="submit" /></li><?php } ?>
				<li class="previous"><a href="#" class="btn-skip back-step1"><span>&raquo; </span>Previous step</a></li>
				<li class="skip"><a href="#" class="btn-skip skip-step2">Skip this step<span> &raquo;</span></a></li>
			</ul>
		</div>
	</div>	
	</div>
</form>