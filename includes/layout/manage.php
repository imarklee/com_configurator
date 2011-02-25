<? defined('KOOWA') or die('Restricted access') ?>
<div id="browser-wrap" class="<?= $browser->name . ' ' . $browser->name.$browser->version; ?>">
<?php
	
// Show a specific template in editable mode.
if(isset($lists['err_messages'])) echo count($lists['err_messages'])?'<span style="color:#fff;background-color:#FF0000;font-weight:bold;">'.implode(',', $lists['err_messages']).'</span>':'';		

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
			<?= @tabs('site', 'admin::com.configurator.includes.general.', array(
				'general' => 'General',
				'performance' => 'Performance',
				'debugging' => 'Debugging',
				'components' => 'Component Layouts',
				'mootools' => 'Mootools Compatibility',
				//'jomsocial' => 'JomSocial Integration' //if($jomsocial_installed)
				//'menuitems' => 'Menu Items',
				'enhancements' => 'Core Enhancements'
			)) ?>
		</div>

		<div id="customize" class="ui-tabs-panel ui-tabs-hide">
			<?= @tabs('customize', 'admin::com.configurator.includes.customize.', array(
				'colors' => 'Color Settings',
				'logos' => 'Logo Settings',
				'backgrounds' => 'Background Settings',
				'fonts' => 'Custom Fonts',
				'iphone' => 'iPhone Compatibility'
			), $overlays->themelet) ?>
		</div>

		<div id="blocks" class="ui-tabs-panel ui-tabs-hide">
			<?= @tabs('blocks', 'admin::com.configurator.includes.blocks.', array(
				'toolbar' => 'Toolbar',
				'mainhead' => 'Masthead',
				'subhead' => 'Subhead',
				'topnav' => 'Topnav',
				'outer-shelves' => 'Outer Shelves',
				'inner-shelves' => 'Inner Shelves',
				'main' => 'Main Content',
				'outer-sidebar' => 'Outer Sidebar',
				'inner-sidebar' => 'Inner Sidebar',
				'insets' => 'Insets',
				'footer' => 'Footer'
			)) ?>
		</div>

		<div id="plugins" class="ui-tabs-panel ui-tabs-hide">
			<?= @tabs('plugins', 'admin::com.configurator.includes.plugins.', array(
				'captify' => 'Fancy Captions',
				'lightbox' => 'Lightbox',
				'preloader' => 'Preloader',
			)) ?>
		</div>

		<div id="tools" class="ui-tabs-panel ui-tabs-hide">
			<?= @tabs('tools', 'admin::com.configurator.includes.tools.', array(
				'uploader' => 'Universal Installer',
				'database' => 'Import / Export',
				'reset-settings' => 'Reset Settings',
				'editor-wrap' => 'Code Editor',
				'module-migrator' => 'Module Migrator',
			)) ?>
		</div>

		<div id="assets" class="ui-tabs-panel ui-tabs-hide">
			<div id="assets-tabs" class="subtabs">
				<?= $overlays->assets ?>
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
			<?= @template('help') ?>
		</div>
	</div>

	<div class="clear">&nbsp;</div>
	<? if($cfg_pref->shelf_position == 2) echo @template('admin::com.configurator.includes.layout.shelf') ?>
	<? if($cfg_pref->show_footer == 1) echo @template('admin::com.configurator.includes.shelf_footer') ?>					
						
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
<div id="preferences-screen" style="display:none;"><?= @template('admin::com.configurator.includes.preferences') ?></div>
<div id="keyboard-screen" style="display:none;"></div>
<div class="toolguides" style="display:none;"></div>
<? } ?>