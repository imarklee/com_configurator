<?php defined('_JEXEC') or die('Restricted access');
ob_start();
if(strpos($_SERVER['SCRIPT_NAME'], 'install.configurator.php') === false){
$base = './components/com_configurator';
}else{
$base = '.';
}
define('JURL', $base);
define('JROOT', str_replace(array('administrator/components/com_configurator/installer','administrator\components\com_configurator\installer'), '', dirname(__FILE__)));
if(is_dir(JROOT . '/morph_assets')){ echo '<div id="assets_folder_exists" style="display:none;"></div>'; }
?>
<form id="install-template" class="step1" method="post" action="?option=com_configurator&view=configuration&task=installTemplate&format=raw&backup=false" enctype="multipart/form-data">
	<div id="install-head">
		<img src="<?php echo JURL; ?>/installer/images/morphlogo.png" alt="morph logo" width="182" height="59" border="0" class="logo" />
		<p class="steps"><?= @text('<strong>Step 1 of 2: </strong>Install &amp; publish Morph') ?></p>
	</div>
		
	<div id="install-shadow">
		<div id="install-main">	
			<div id="install-title">
				<h2><?= @text('<strong>Step 1: </strong>Install &amp; publish Morph') ?></h2>
				<a href="#" class="help-step1"><?= @text('Help with this step') ?></a>
			</div>
			
			<div id="install-body">
				<h3><?= @text('In this step, you will install and publish the Morph template.') ?></h3>
				<p><?= @text('If you already have a copy of Morph installed, you can choose to have a backup automatically created for you or skip this step completely.') ?></p>
				
				<label class="upload"><h4><?= @text('Select the template framework install file:') ?></h4>
				<input type="file" name="template-file" id="template-file" /></label>
				
				<label class="backup"><input type="checkbox" name="publish_template" id="publish_template" checked="checked" value="true" />
				<?= @text('Publish Morph as the default template?') ?></label>
				
			</div>
				
			<div id="install-foot">
				<ul id="action">
					<?php if(is_dir(JROOT . 'morph_assets')){ ?><li class="next"><input class="action install-template btn-install" type="submit" value="submit" /></li><?php } ?>
					<li class="previous"><span>&laquo; </span><?= @text('Previous step') ?></li>
					<li class="skip"><a href="#" class="btn-skip skip-step1"><?= @text('Skip this step') ?><span> &raquo;</span></a></li>
				</ul>
			</div>
		</div>	
	</div>	
</form>