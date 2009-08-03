<?php 
if(strpos($_SERVER['SCRIPT_NAME'], 'install.configurator.php') === false){
$base = './components/com_configurator';
}else{
$base = '.';
}
define('JURL', $base);
define('JROOT', str_replace(array('administrator/components/com_configurator/installer','administrator\components\com_configurator\installer'), '', dirname(__FILE__)));
?>
<form id="install-template" class="step1" method="post" action="index.php?option=com_configurator&task=installTemplate&format=raw&backup=false" enctype="multipart/form-data">
	<div id="install-head">
		<img src="<?php echo JURL; ?>/installer/images/install-logo.png" alt="morph logo" width="160" height="60" border="0" class="logo" />
		<img src="<?php echo JURL; ?>/installer/images/tagline.png" alt="morph tagline" width="195" height="24" border="0" class="tagline" />
		<p class="steps"><strong>Step 1 of 3: </strong>Install &amp; publish Morph</p>
	</div>
		
	<div id="install-shadow">
		<div id="install-main">	
			<div id="install-title">
				<h2><strong>Step 1: </strong>Install &amp; publish Morph</h2>
				<a href="#" class="help-step1">Help with this step</a>
			</div>
			
			<div id="install-body">
				<h3>In this step, you will install and publish the Morph template.</h3>
				<p>If you already have a copy of Morph installed, you can choose to have a backup automatically created for you or skip this step completely.</p>
				
				<?php 
				if(is_dir(JROOT . 'morph_assets')){ ?>
				<label class="upload"><h4>Select the template framework install file:</h4>
				<input type="file" name="template-file" id="template-file" /></label>
				
				<label class="backup"><input type="checkbox" name="publish_template" id="publish_template" checked="checked" value="true" />
				Publish Morph as the default template?</label>
				
				<?php if(is_dir(JROOT . 'templates/morph')){ ?>
				<label class="backup"><input type="checkbox" name="backup_template" id="backup_template" checked="checked" value="true" />
				Backup your existing copy of Morph?</label>
				<?php }else{ setcookie('installed_nomorph', 'true'); } ?>
				<span class="mascot">&nbsp;</span>
				
				<?php } else{ ?>
				<div class="assets-warning">
				<strong>Warning! - Assets folder not found.</strong>
				<p>The installer cannot find the assets folder. This is needed to continue with the installation.</p>
				<p><a href="#" class="create-assets">Click here</a> to create the assets folder and its subfolders.</p>
				<p>If you wish, you can manually create these folders using the folder structure below, in the root of your Joomla! install
				and <a href="#" class="refresh-step1">click here</a> to refresh this page and continue.</p>
				
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
				<?php }?>	
			</div>
				
			<div id="install-foot">
				<ul id="action">
					<?php if(is_dir(JROOT . 'morph_assets')){ ?><li class="next"><input class="action install-template btn-install" type="submit" value="submit" /></li><?php } ?>
					<li class="previous"><span>&laquo; </span>Previous step</li>
					<li class="skip"><a href="#" class="btn-skip skip-step1">Skip this step<span> &raquo;</span></a></li>
				</ul>
			</div>
		</div>	
	</div>	
</form>
