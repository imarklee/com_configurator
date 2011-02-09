<?php defined('_JEXEC') or die('Restricted access');
//@TODO this file shouldn't be requested by ajax outside of the mvc flow
if(strpos($_SERVER['SCRIPT_NAME'], 'install.configurator.php') === false){
$base = './components/com_configurator';
}else{
$base = '.';
}
$root = str_replace(array('administrator/components/com_configurator/installer','administrator\components\com_configurator\installer'), '', dirname(__FILE__));

//@TODO we can't use this yet until this part is mvc, so we use a dirtier temporary workaround
$themelet_installed = KFactory::get('admin::com.configurator.helper.utilities')->getInstallState('themelet_installed');
?>
<form id="install-themelet" class="step2" method="post" action="#">
	<div id="install-head">
		<img src="<?php echo $base; ?>/installer/images/morphlogo.png" alt="morph logo" width="182" height="59" border="0" class="logo" />
		<p class="steps"><?php echo JText::_('<strong>Step 2 of 2: </strong>Install your themelet') ?></p>
	</div>
	<div id="install-shadow">
	<div id="install-main">	
		<div id="install-title">
			<h2><?php echo JText::_('<strong>Step 2:</strong> Install your themelet') ?></h2>
			<a href="#" class="help-step2"><?php echo JText::_('Help with this step') ?></a>
		</div>
		<div id="install-body">
			<h3><?php echo JText::_('In this step, you will install and publish your themelet.') ?></h3>
			<p><?php echo JText::_('Themelets are child themes for Morph and are essentially the seperation of the visual and functional aspects of your template. <a href="#" class="help-step2" title="click here for help with this step" class="step2-help">Click here to learn more</a>') ?></p>
			
			<label class="upload"><h4><?php echo JText::_('Select your themelet install file:') ?></h4>
			<input type="file" name="insfile" id="insfile" /></label>
			<?php if($themelet_installed) : ?><span style="display:none;"><?php endif ?>
			<label class="backup"><input type="checkbox" name="activate_themelet" id="activate_themelet" checked="checked" value="true" />
			<?php echo JText::_('Activate themelet (recommended for first time installs)') ?></label>
			<?php if($themelet_installed) : ?></span><?php endif ?>
		</div>	
		<div id="install-foot">
			<ul id="action">
				<?php if(is_dir($root . 'morph_assets')){ ?><li class="next"><input class="action install-themelet btn-install" type="submit" value="submit" /></li><?php } ?>
				<li class="previous"><a href="#" class="btn-skip back-step1"><span>&raquo; </span><?php echo JText::_('Previous step') ?></a></li>
				<li class="skip"><a href="#" class="btn-skip skip-step2"><?php echo JText::_('Skip this step') ?><span> &raquo;</span></a></li>
			</ul>
		</div>
	</div>	
	</div>
</form>