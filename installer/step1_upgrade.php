<?php defined('_JEXEC') or die('Restricted access');
if(strpos($_SERVER['SCRIPT_NAME'], 'install.configurator.php') === false){
$base = './components/com_configurator';
}else{
$base = '.';
}
$root = str_replace(array('administrator/components/com_configurator/installer','administrator\components\com_configurator\installer'), '', dirname(__FILE__));
if(is_dir($root . '/morph_assets')){ echo '<div id="assets_folder_exists" style="display:none;"></div>'; }
?>
<form id="install-template" class="step1" method="post" action="index.php?option=com_configurator&format=raw&backup=false" enctype="multipart/form-data">
	<input type="hidden" name="action" value="install_template" />
	<div id="install-head">
		<img src="<?php echo $base; ?>/installer/images/morphlogo.png" alt="morph logo" width="182" height="59" border="0" class="logo" />
		<p class="steps"><strong><?php echo JText::_('Step 1 of 2: </strong>Install &amp; publish Morph') ?></p>
	</div>
		
	<div id="install-shadow">
		<div id="install-main">	
			<div id="install-title">
				<h2><?php echo JText::_('<strong>Step 1: </strong>Install &amp; publish Morph') ?></h2>
				<a href="#" class="help-step1"><?php echo JText::_('Help with this step') ?></a>
			</div>
			
			<div id="install-body" class="upgrade">
				<h3><?php echo JText::_('Are you upgrading?') ?></h3>
				<p><?php echo JText::_("It seems like you are upgrading your install of Morph's Configurator component. 
				Please select from the options below to continue.") ?></p>
				
				<h4 class="blank">&nbsp;</h4>
				
				<label class="upgrade">
					<input type="radio" name="upgrade" value="opt1">
						<?php echo JText::_('<strong>Option 1:</strong> I just want to upgrade Configurator.') ?>
				</label>
				<div class="upgrade-sub-options">
					<label class="upgrade">
						<input type="radio" name="upgrade" value="opt2">
							<?php echo JText::_('<strong>Option 2:</strong> Upgrade Configurator, Morph and/or a themelet.') ?>
							<ul>
								<li><label><input type="radio" name="upgrade_type" value="fresh" />
									<strong><?php echo JText::_('Start from scratch') ?> </strong>
									<span><?php echo JText::_('This option will empty the component database and install the default settings.') ?></span>
								</label></li>
								<li><label><input type="radio" name="upgrade_type" value="existing" />
									<strong><?php echo JText::_('Keep existing settings') ?> </strong>
									<span><?php echo JText::_('This option will keep your existing installation and configuration intact.') ?></span>
								</label></li>
							</ul>
					</label>
				</div>
				
			</div>
				
			<div id="install-foot">
				<ul id="action">
					
					<li class="previous"><span>&laquo; </span><?php echo JText::_('Previous step') ?></li>
					<li class="skip"><a href="#" class="btn-skip skip-step1"><?php echo JText::_('Skip this step') ?><span> &raquo;</span></a></li>
					<li class="next"><a href="#" class="launch-cfg btn-install" title="click here to get started with configurator"><?php echo JText::_('Launch Configurator') ?></a></li>
				</ul>
			</div>
		</div>	
	</div>	
</form>