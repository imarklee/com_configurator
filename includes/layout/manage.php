<?php defined('_JEXEC') or die('Restricted access');
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

$template_dir = JPATH_SITE.'/templates/morph';
$jVer 		= new JVersion();
$jVer_curr  = $jVer->RELEASE.'.'.$jVer->DEV_LEVEL;
?>
<div id="browser-wrap" class="<?php echo $browser->name . ' ' . $browser->name.$browser->version; ?>">
<?php
	
// Show a specific template in editable mode.
if(isset($lists['err_messages'])) echo count($lists['err_messages'])?'<span style="color:#fff;background-color:#FF0000;font-weight:bold;">'.implode(',', $lists['err_messages']).'</span>':'';		

//if(!$this->checkUser()){
//@TODO move this into the view instead
if(false) {
	include JPATH_COMPONENT_ADMINISTRATOR.'/includes/layout/login.php';
} else {
	// auto updates
    if($cfg_pref->check_updates == 0){
    	setcookie('noupdates', 'true', time()+60*60*24*365);
    }else{
    	setcookie('noupdates', 'true', time()+3600);
    }
	
	if(function_exists('ini_set')){ ini_set('memory_limit', '32M'); 
	}else{
		$mem_limit = ini_get('memory_limit');
		if(str_replace('M', '', $mem_limit) < 32) echo $this->show_error('We are unable to adjust your memory limit.'.
		'Your current memory limit is '.$mem_limit.', which is less than what is required for optimal performance.'.
		'<a href="#" id="readmore-memory">click here</a> to find out more.', 'notice', 'memory');
	}

$db=& JFactory::getDBO();
$query = "SELECT COUNT(*) FROM `#__components` WHERE `name` = 'Jom Social' AND `enabled` = '1'";
$db->setQuery( $query ); 
$jomsocial_installed = false;
if($db->loadResult())
{
	$query = "SELECT `params` FROM `#__community_config` WHERE `name` = 'config'";
	$db->setQuery( $query );
	if($jomsocial = $db->loadResult())
	{
		$jomsocial = new JParameter($jomsocial);
		$jomsocial_installed = 'morph' == $jomsocial->getValue('template');
	}
}

$app		     = JFactory::getApplication();
$menuitem_active = $app->getUserState('configurator') ? ' menuitem_active' : null;

?>
<form action="<?= @route() ?>" method="post" name="adminForm" id="templateform" enctype="multipart/form-data">    	
<div id="cfg" class="container_16<?php if($cfg_pref->shelf_position == 0){ ?> noshelf<?php } if($cfg_pref->shelf_position == 1){ ?> shelftop<?php } if($cfg_pref->shelf_position == 2){ ?> shelfbtm<?php } if($cfg_pref->show_footer == 0 ){ ?> nofooter<?php } if($cfg_pref->show_footer == 1 ){ ?> footer<?php } if($cfg_pref->show_branding == 0){ ?> nobranding<?php } if($cfg_pref->show_branding == 1){ ?> branding<?php } ?><?php echo $menuitem_active ?>" data-active-menuitems="<?php echo implode(',', KFactory::get('admin::com.configurator.database.table.templatesettings')->getActiveMenuitemParams()) ?>">
	
	<? if($cfg_pref->show_branding) echo @template('top') ?>
	<? if($cfg_pref->shelf_position) echo @template('shelf') ?>

	<div class="clear spacer">&nbsp;</div>

	<div id="tabs" class="ui-tabs ui-widget ui-widget-content <?= $cfg_pref->settings_effect ?>">
		<ul class="primary ui-tabs-nav ui-helper-reset ui-helper-clearfix">
			<li class="site-icon ui-tabs-selected"><a href="#site"><?= @text('General') ?></a></li>
			<li class="themelet-icon"><a href="#customize"><?= @text('Customize') ?></a></li>
			<li class="blocks-icon"><a href="#blocks"><?= @text('Building Blocks') ?></a></li>
			<li class="plugins-icon"><a href="#plugins"><?= @text('Plugins') ?></a></li>
			<li class="tools-icon"><a href="#tools"><?= @text('Tools') ?></a></li>
			<li class="assets-icon"><a href="#assets"><?= @text('Your Assets') ?></a></li>
			<li class="help-icon last"><a href="#help"><?= @text('Help') ?></a></li>
		</ul>
		<div id="site" class="ui-tabs-panel">
			<div id="site-tabs" class="subtabs">
				<?php if ($cfg_pref->show_intros == 1 && !isset($_COOKIE['site-desc'])) @template('admin::com.configurator.includes.general.desc-site') ?>
				<ul class="ui-helper-clearfix ui-tabs-nav">
					<li class="icon-general ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a href="#general-tab"><?= @text('General') ?></a></li>
					<li class="icon-performance"><a href="#performance-tab"><?= @text('Performance') ?></a></li>
					<li class="icon-debugging"><a href="#debugging-tab"><?= @text('Debugging') ?></a></li>
                    <li class="icon-components"><a href="#components-tab"><?= @text('Component Layouts') ?></a></li>
                    <li class="icon-comperformance"><a href="#mootools-tab"><?= @text('Mootools Compatibility') ?></a></li>
                    <!--<?php if($jomsocial_installed == 1) { ?><li class="icon-jomsocial"><a href="#jomsocial-tab"><?= @text('JomSocial Integration') ?></a></li><?php } ?>-->
                    <!--<li class="icon-menuitems"><a href="#menuitems-tab"><?= @text('Menu Items') ?></a></li>-->
                    <li class="icon-enhancements"><a href="#enhancements-tab"><?= @text('Core Enhancements') ?></a></li>
				</ul>
				<?= @template('admin::com.configurator.includes.general.general') ?>
				<?= @template('admin::com.configurator.includes.general.performance') ?>
				<?= @template('admin::com.configurator.includes.general.debugging') ?>
				<?= @template('admin::com.configurator.includes.general.components') ?>
				<?= @template('admin::com.configurator.includes.general.mootools') ?>
				<!--<?php //if($jomsocial_installed == 1) @template('admin::com.configurator.includes.general.jomsocial') ?>-->
				<?= @template('admin::com.configurator.includes.general.menuitems') ?>
				<?= @template('admin::com.configurator.includes.general.enhancements') ?>
			</div>
		</div>

		<div id="customize" class="ui-tabs-panel ui-tabs-hide">
			<div id="customize-tabs" class="subtabs">
				<?php if ($cfg_pref->show_intros == 1 && !isset($_COOKIE['themelet-desc'])) { @template('admin::com.configurator.includes.customize.desc-customize'); } ?>
				<ul class="ui-helper-clearfix ui-tabs-nav">
					<li class="ui-tabs-selected icon-colors"><a href="#colors-tab"><?= @text('Color Settings') ?></a></li>
					<li class="icon-logos"><a href="#logos-tab"><?= @text('Logo Settings') ?></a></li>
					<li class="icon-backgrounds"><a href="#backgrounds-tab"><?= @text('Background Settings') ?></a></li>
					<li class="ui-tabs-selected icon-fonts"><a href="#fonts-tab"><?= @text('Custom Fonts') ?></a></li>
					<li class="icon-iphone"><a href="#iphone-tab"><?= @text('iPhone Compatibility') ?></a></li>
				</ul>
				<?= @template('admin::com.configurator.includes.customize.colors') ?>
				<?= @template('admin::com.configurator.includes.customize.logos') ?>
				<?= @template('admin::com.configurator.includes.customize.backgrounds') ?>
				<?= @template('admin::com.configurator.includes.customize.fonts') ?>
				<?= @template('admin::com.configurator.includes.customize.iphone') ?>
			</div>
		</div>

		<div id="blocks" class="ui-tabs-panel ui-tabs-hide">
			<div id="blocks-tabs" class="subtabs">
				<?php if ($cfg_pref->show_intros == 1 && !isset($_COOKIE['blocks-desc'])) { @template('admin::com.configurator.blocks.desc-blocks'); } ?>
				<ul class="ui-helper-clearfix ui-tabs-nav">
					<li class="icon-toolbar ui-tabs-selected"><a href="#toolbar-tab"><?= @text('Toolbar') ?></a></li>
					<li class="icon-mainhead"><a href="#mainhead-tab"><?= @text('Masthead') ?></a></li>
					<li class="icon-subhead"><a href="#subhead-tab"><?= @text('Subhead') ?></a></li>
					<li class="icon-topnav"><a href="#topnav-tab"><?= @text('Topnav') ?></a></li>
					<li class="icon-oshelves"><a href="#outer-shelves-tab"><?= @text('Outer Shelves') ?></a></li>
					<li class="icon-ishelves"><a href="#inner-shelves-tab"><?= @text('Inner Shelves') ?></a></li>
					<li class="icon-main"><a href="#main-tab"><?= @text('Main Content') ?></a></li>
					<li class="icon-sidebars"><a href="#outer-sidebar-tab"><?= @text('Outer Sidebar') ?></a></li>
					<li class="icon-sidebars"><a href="#inner-sidebar-tab"><?= @text('Inner Sidebar') ?></a></li>
					<li class="icon-insets"><a href="#insets-tab"><?= @text('Insets') ?></a></li>
					<li class="icon-footer"><a href="#footer-tab"><?= @text('Footer') ?></a></li>
				</ul>
				<?= @template('admin::com.configurator.includes.blocks.toolbar') ?>
				<?= @template('admin::com.configurator.includes.blocks.mainhead') ?>
				<?= @template('admin::com.configurator.includes.blocks.subhead') ?>
				<?= @template('admin::com.configurator.includes.blocks.topnav') ?>
				<?= @template('admin::com.configurator.includes.blocks.outer-shelves') ?>
				<?= @template('admin::com.configurator.includes.blocks.inner-shelves') ?>
				<?= @template('admin::com.configurator.includes.blocks.main') ?>
				<?= @template('admin::com.configurator.includes.blocks.outer-sidebar') ?>
				<?= @template('admin::com.configurator.includes.blocks.inner-sidebar') ?>
				<?= @template('admin::com.configurator.includes.blocks.inset') ?>
				<?= @template('admin::com.configurator.includes.blocks.footer') ?>
			</div>
		</div>

		<div id="plugins" class="ui-tabs-panel ui-tabs-hide">
			<div id="plugins-tabs" class="subtabs">
				<?php if ($cfg_pref->show_intros == 1 && !isset($_COOKIE['plugins-desc'])) { @template('admin::com.configurator.plugins/desc-plugins'); } ?>
				<ul class="ui-helper-clearfix ui-tabs-nav">
					<li class="icon-toolbar ui-tabs-selected"><a href="#captify-tab"><?= @text('Fancy Captions') ?></a></li>
					<li class="icon-lightbox"><a href="#lightbox-tab"><?= @text('Lightbox') ?></a></li>
					<li class="icon-preloader"><a href="#preloader-tab"><?= @text('Preloader') ?></a></li>
				</ul>
				<?= @template('admin::com.configurator.includes.plugins.captify') ?>
				<?= @template('admin::com.configurator.includes.plugins.lightbox') ?>
				<?= @template('admin::com.configurator.includes.plugins.preloader') ?>
			</div>
		</div>

		<div id="tools" class="ui-tabs-panel ui-tabs-hide">
			<div id="tools-tabs" class="subtabs">
				<?php if ($cfg_pref->show_intros == 1 && !isset($_COOKIE['tools-desc'])) { @template('admin::com.configurator.tools.desc-tools'); } ?>
				<ul class="ui-helper-clearfix ui-tabs-nav">
					<li class="icon-installer"><a href="#tools-installer"><?= @text('Universal Installer') ?></a></li>
					<li class="icon-db"><a href="#database-manager"><?= @text('Import / Export') ?></a></li>
					<li class="icon-reset"><a href="#reset-settings"><?= @text('Reset Settings') ?></a></li>
					<li class="icon-editor"><a href="#editor-wrap"><?= @text('Code Editor') ?></a></li>
					<li class="icon-modules"><a href="#module-migrator"><?= @text('Module Migrator') ?></a></li>
				</ul>
				<?= @template('admin::com.configurator.includes.tools.uploader') ?>
				<?= @template('admin::com.configurator.includes.tools.database') ?>
				<?= @template('admin::com.configurator.includes.tools.reset') ?>
				<?= @template('admin::com.configurator.includes.tools.editor') ?>
				<?= @template('admin::com.configurator.includes.tools.modules') ?>
			</div>
		</div>

		<div id="assets" class="ui-tabs-panel ui-tabs-hide">
			<div id="assets-tabs" class="subtabs">
				<?php if ($cfg_pref->show_intros == 1 && !isset($_COOKIE['assets-desc'])) include JPATH_COMPONENT_ADMINISTRATOR.'/views/help/tmpl/desc_assets.php' ?>
				<ul class="ui-helper-clearfix ui-tabs-nav">
					<li class="icon-themelets"><a href="<?php echo JRoute::_('?option=com_configurator&amp;view=themelets&amp;format=raw') ?>"><?= @text('Themelets') ?></a></li>
					<li class="icon-logos"><a href="?option=com_configurator&amp;view=logos&amp;format=raw"><?= @text('Logos') ?></a></li>
					<li class="icon-backgrounds"><a href="?option=com_configurator&amp;view=backgrounds&amp;format=raw"><?= @text('Backgrounds') ?></a></li>
					<li class="icon-iphone"><a href="?option=com_configurator&amp;view=iphone&amp;format=raw"><?= @text('iPhone') ?></a></li>
					<li class="icon-backupmgr"><a href="?option=com_configurator&amp;view=backups&amp;format=raw"><?= @text('Backups') ?></a></li>
					<li class="icon-recycle"><a href="?option=com_configurator&amp;view=recycle&amp;format=raw"><?= @text('Recycle Bin') ?></a></li>
				</ul>
				<div class="icon-backup"> 
					<span><a href="?option=com_configurator&amp;task=assets_backup&amp;format=raw&amp;type=gzip" title="click here to download a full backup of your assets folder as a gzipped tarball"><?= @text('Download a Backup') ?></a></span>				
				</div>
			</div>
		</div>
		
		<div id="help" class="ui-tabs-panel ui-tabs-hide off">
			<?= @template('help'); ?>
		</div>
	</div>

	<div class="clear">&nbsp;</div>
	<?php if($cfg_pref->shelf_position == 2){ @template('admin::com.configurator.includes.layout.shelf'); } ?>
	<?php if($cfg_pref->show_footer == 1){ @template('admin::com.configurator.includes.shelf_footer'); } ?>					
						
</div>
<?php
if($cfg_pref->bottom_save >= 1){ ?>
<div id="bottom-save"<?php echo bs_class($cfg_pref->bottom_save); ?> style="display:none;"><a href="#" title="you can configure how this save bar is displayed in the configurator preferences"><?= @text('Save your settings') ?></a></div>
<?php } ?>
<input type="hidden" name="option" value="<?php echo JRequest::getCmd('option', 'com_configurator'); ?>"/>
<input type="hidden" name="t" value="morph"/>
<input type="hidden" name="task" value="" />
<input type="hidden" name="action" value="apply" />
</form>

<div id="getting-started" style="display:none;"></div>
<div id="preferences-screen" style="display:none;"><?= @template('admin::com.configurator.includes.preferences'); ?></div>
<div id="keyboard-screen" style="display:none;"></div>
<div class="toolguides" style="display:none;"></div>
<? } ?>