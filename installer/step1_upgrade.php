<?php defined('_JEXEC') or die('Restricted access');
if(strpos($_SERVER['SCRIPT_NAME'], 'install.configurator.php') === false){
$base = './components/com_configurator';
}else{
$base = '.';
}
define('JURL', $base);
define('JROOT', str_replace(array('administrator/components/com_configurator/installer','administrator\components\com_configurator\installer'), '', dirname(__FILE__)));
if(is_dir(JROOT . '/morph_assets')){ echo '<div id="assets_folder_exists" style="display:none;"></div>'; }
?>
<form id="install-template" class="step1" method="post" action="index.php?option=com_configurator&task=installTemplate&format=raw&backup=false" enctype="multipart/form-data">
	<div id="install-head">
		<img src="<?php echo JURL; ?>/installer/images/morphlogo.png" alt="morph logo" width="182" height="59" border="0" class="logo" />
		<p class="steps"><strong><?= @text('Step 1 of 2: </strong>Install &amp; publish Morph') ?></p>
	</div>
		
	<div id="install-shadow">
		<div id="install-main">	
			<div id="install-title">
				<h2><?= @text('<strong>Step 1: </strong>Install &amp; publish Morph') ?></h2>
				<a href="#" class="help-step1"><?= @text('Help with this step') ?></a>
			</div>
			
			<div id="install-body" class="upgrade">
				<h3><?= @text('Are you upgrading?') ?></h3>
				<p><?= @text("It seems like you are upgrading your install of Morph's Configurator component. 
				Please select from the options below to continue.") ?></p>
				
				<h4 class="blank">&nbsp;</h4>
				
				<label class="upgrade">
					<input type="radio" name="upgrade" value="opt1">
						<?= @text('<strong>Option 1:</strong> I just want to upgrade Configurator.') ?>
				</label>
				<div class="upgrade-sub-options">
					<label class="upgrade">
						<input type="radio" name="upgrade" value="opt2">
							<?= @text('<strong>Option 2:</strong> Upgrade Configurator, Morph and/or a themelet.') ?>
							<ul>
								<li><label><input type="radio" name="upgrade_type" value="fresh" />
									<strong><?= @text('Start from scratch') ?> </strong>
									<span><?= @text('This option will empty the component database and install the default settings.') ?></span>
								</label></li>
								<li><label><input type="radio" name="upgrade_type" value="existing" />
									<strong><?= @text('Keep existing settings') ?> </strong>
									<span><?= @text('This option will keep your existing installation and configuration intact.') ?></span>
								</label></li>
							</ul>
					</label>
				</div>
				
			</div>
				
			<div id="install-foot">
				<ul id="action">
					
					<li class="previous"><span>&laquo; </span><?= @text('Previous step') ?></li>
					<li class="skip"><a href="#" class="btn-skip skip-step1"><?= @text('Skip this step') ?><span> &raquo;</span></a></li>
					<li class="next"><a href="#" class="launch-cfg btn-install" title="click here to get started with configurator"><?= @text('Launch Configurator') ?></a></li>
				</ul>
			</div>
		</div>	
	</div>	
</form>