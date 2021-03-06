<?php defined('_JEXEC') or die('Restricted access');
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/
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
<form action="index.php?option=com_configurator&amp;view=configuration" method="post" name="adminForm" id="templateform" enctype="multipart/form-data">    	
<div id="cfg" class="container_16<?php if($cfg_pref->shelf_position == 0){ ?> noshelf<?php } if($cfg_pref->shelf_position == 1){ ?> shelftop<?php } if($cfg_pref->shelf_position == 2){ ?> shelfbtm<?php } if($cfg_pref->show_footer == 0 ){ ?> nofooter<?php } if($cfg_pref->show_footer == 1 ){ ?> footer<?php } if($cfg_pref->show_branding == 0){ ?> nobranding<?php } if($cfg_pref->show_branding == 1){ ?> branding<?php } ?><?php echo $menuitem_active ?>" data-active-menuitems="<?php echo implode(',', JTable::getInstance('ConfiguratorTemplateSettings', 'Table')->getActiveMenuitemParams()) ?>">
	
	<?php if($cfg_pref->show_branding == 1){include dirname(__FILE__) . '/top.php'; } ?>
	<?php if($cfg_pref->shelf_position == 1){include dirname(__FILE__) . '/shelf.php'; } ?>

	<div class="clear spacer">&nbsp;</div>

	<div id="tabs" class="ui-tabs ui-widget ui-widget-content <?php echo $cfg_pref->settings_effect; ?>">
		<ul class="primary ui-tabs-nav ui-helper-reset ui-helper-clearfix">
			<li class="site-icon ui-tabs-selected"><a href="#site">General</a></li>
			<li class="themelet-icon"><a href="#customize">Customize</a></li>
			<li class="blocks-icon"><a href="#blocks">Building Blocks</a></li>
			<li class="plugins-icon"><a href="#plugins">Plugins</a></li>
			<li class="tools-icon"><a href="#tools">Tools</a></li>
			<li class="assets-icon"><a href="#assets">Your Assets</a></li>
			<li class="help-icon last"><a href="#resources">Help</a></li>
		</ul>
		<div id="site" class="ui-tabs-panel">
			<div id="site-tabs" class="subtabs">
				<?php if ($cfg_pref->show_intros == 1 && !isset($_COOKIE['site-desc'])) include dirname(__FILE__).'/../general/desc-site.php' ?>
				<ul class="ui-helper-clearfix ui-tabs-nav">
					<li class="icon-general ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a href="#general-tab">General</a></li>
					<li class="icon-performance"><a href="#performance-tab">Performance</a></li>
					<li class="icon-debugging"><a href="#debugging-tab">Debugging</a></li>
                    <li class="icon-components"><a href="#components-tab">Component Layouts</a></li>
                    <li class="icon-comperformance"><a href="#mootools-tab">Mootools Compatibility</a></li>
                    <!--<?php if($jomsocial_installed == 1) { ?><li class="icon-jomsocial"><a href="#jomsocial-tab">JomSocial Integration</a></li><?php } ?>-->
                    <!--<li class="icon-menuitems"><a href="#menuitems-tab">Menu Items</a></li>-->
                    <li class="icon-enhancements"><a href="#enhancements-tab">Core Enhancements</a></li>
				</ul>
				<?php include dirname(__FILE__).'/../general/general.php' ?>
				<?php include dirname(__FILE__).'/../general/performance.php' ?>
				<?php include dirname(__FILE__).'/../general/debugging.php' ?>
				<?php include dirname(__FILE__).'/../general/components.php' ?>
				<?php include dirname(__FILE__).'/../general/mootools.php' ?>
				<!--<?php //if($jomsocial_installed == 1) include dirname(__FILE__).'/../general/jomsocial.php' ?>-->
				<?php include dirname(__FILE__).'/../general/menuitems.php' ?>
				<?php include dirname(__FILE__).'/../general/enhancements.php' ?>
			</div>
		</div>

		<div id="customize" class="ui-tabs-panel ui-tabs-hide">
			<div id="customize-tabs" class="subtabs">
				<?php if ($cfg_pref->show_intros == 1 && !isset($_COOKIE['themelet-desc'])) { include dirname(__FILE__).'/../customize/desc-customize.php'; } ?>
				<ul class="ui-helper-clearfix ui-tabs-nav">
					<li class="ui-tabs-selected icon-colors"><a href="#colors-tab">Color Settings</a></li>
					<li class="icon-logos"><a href="#logos-tab">Logo Settings</a></li>
					<li class="icon-backgrounds"><a href="#backgrounds-tab">Background Settings</a></li>
					<li class="ui-tabs-selected icon-fonts"><a href="#fonts-tab">Custom Fonts</a></li>
					<li class="icon-iphone"><a href="#iphone-tab">iPhone Compatibility</a></li>
				</ul>
				<?php include dirname(__FILE__).'/../customize/colors.php' ?>
				<?php include dirname(__FILE__).'/../customize/logos.php' ?>
				<?php include dirname(__FILE__).'/../customize/backgrounds.php' ?>
				<?php include dirname(__FILE__).'/../customize/fonts.php' ?>
				<?php include dirname(__FILE__).'/../customize/iphone.php' ?>
			</div>
		</div>

		<div id="blocks" class="ui-tabs-panel ui-tabs-hide">
			<div id="blocks-tabs" class="subtabs">
				<?php if ($cfg_pref->show_intros == 1 && !isset($_COOKIE['blocks-desc'])) { include dirname(__FILE__).'/../blocks/desc-blocks.php'; } ?>
				<ul class="ui-helper-clearfix ui-tabs-nav">
					<li class="icon-toolbar ui-tabs-selected"><a href="#toolbar-tab">Toolbar</a></li>
					<li class="icon-mainhead"><a href="#mainhead-tab">Masthead</a></li>
					<li class="icon-subhead"><a href="#subhead-tab">Subhead</a></li>
					<li class="icon-topnav"><a href="#topnav-tab">Topnav</a></li>
					<li class="icon-oshelves"><a href="#outer-shelves-tab">Outer Shelves</a></li>
					<li class="icon-ishelves"><a href="#inner-shelves-tab">Inner Shelves</a></li>
					<li class="icon-main"><a href="#main-tab">Main Content</a></li>
					<li class="icon-sidebars"><a href="#outer-sidebar-tab">Outer Sidebar</a></li>
					<li class="icon-sidebars"><a href="#inner-sidebar-tab">Inner Sidebar</a></li>
					<li class="icon-insets"><a href="#insets-tab">Insets</a></li>
					<li class="icon-footer"><a href="#footer-tab">Footer</a></li>
				</ul>
				<?php include dirname(__FILE__).'/../blocks/toolbar.php' ?>
				<?php include dirname(__FILE__).'/../blocks/mainhead.php' ?>
				<?php include dirname(__FILE__).'/../blocks/subhead.php' ?>
				<?php include dirname(__FILE__).'/../blocks/topnav.php' ?>
				<?php include dirname(__FILE__).'/../blocks/outer-shelves.php' ?>
				<?php include dirname(__FILE__).'/../blocks/inner-shelves.php' ?>
				<?php include dirname(__FILE__).'/../blocks/main.php' ?>
				<?php include dirname(__FILE__).'/../blocks/outer-sidebar.php' ?>
				<?php include dirname(__FILE__).'/../blocks/inner-sidebar.php' ?>
				<?php include dirname(__FILE__).'/../blocks/inset.php' ?>
				<?php include dirname(__FILE__).'/../blocks/footer.php' ?>
			</div>
		</div>

		<div id="plugins" class="ui-tabs-panel ui-tabs-hide">
			<div id="plugins-tabs" class="subtabs">
				<?php if ($cfg_pref->show_intros == 1 && !isset($_COOKIE['plugins-desc'])) { include dirname(__FILE__).'/../plugins/desc-plugins.php'; } ?>
				<ul class="ui-helper-clearfix ui-tabs-nav">
					<li class="icon-toolbar ui-tabs-selected"><a href="#captify-tab">Fancy Captions</a></li>
					<li class="icon-lightbox"><a href="#lightbox-tab">Lightbox</a></li>
					<li class="icon-preloader"><a href="#preloader-tab">Preloader</a></li>
					<li class="icon-megamenu"><a href="#megamenu-tab">Mega Shelf Menu</a></li>
				</ul>
				<?php include dirname(__FILE__).'/../plugins/captify.php' ?>
				<?php include dirname(__FILE__).'/../plugins/lightbox.php' ?>
				<?php include dirname(__FILE__).'/../plugins/preloader.php' ?>
				<?php include dirname(__FILE__).'/../plugins/megamenu.php' ?>
			</div>
		</div>

		<div id="tools" class="ui-tabs-panel ui-tabs-hide">
			<div id="tools-tabs" class="subtabs">
				<?php if ($cfg_pref->show_intros == 1 && !isset($_COOKIE['tools-desc'])) { include dirname(__FILE__).'/../tools/desc-tools.php'; } ?>
				<ul class="ui-helper-clearfix ui-tabs-nav">
					<li class="icon-installer"><a href="#tools-installer">Universal Installer</a></li>
					<li class="icon-db"><a href="#database-manager">Import / Export</a></li>
					<li class="icon-reset"><a href="#reset-settings">Reset Settings</a></li>
					<li class="icon-editor"><a href="#editor-wrap">Code Editor</a></li>
					<li class="icon-modules"><a href="#module-migrator">Module Migrator</a></li>
				</ul>
				<?php include dirname(__FILE__).'/../tools/uploader.php'; ?>
				<?php include dirname(__FILE__).'/../tools/database.php'; ?>
				<?php include dirname(__FILE__).'/../tools/reset.php'; ?>
				<?php include dirname(__FILE__).'/../tools/editor.php'; ?>
				<?php include dirname(__FILE__).'/../tools/modules.php'; ?>
			</div>
		</div>

		<div id="assets" class="ui-tabs-panel ui-tabs-hide">
			<div id="assets-tabs" class="subtabs">
				<?php if ($cfg_pref->show_intros == 1 && !isset($_COOKIE['assets-desc'])) include JPATH_COMPONENT_ADMINISTRATOR.'/views/help/tmpl/desc_assets.php' ?>
				<ul class="ui-helper-clearfix ui-tabs-nav">
					<li class="icon-themelets"><a href="<?php echo JRoute::_('?option=com_configurator&amp;view=themelets&amp;format=raw') ?>">Themelets</a></li>
					<li class="icon-logos"><a href="?option=com_configurator&amp;view=logos&amp;format=raw">Logos</a></li>
					<li class="icon-backgrounds"><a href="?option=com_configurator&amp;view=backgrounds&amp;format=raw">Backgrounds</a></li>
					<li class="icon-iphone"><a href="?option=com_configurator&amp;view=iphone&amp;format=raw">iPhone</a></li>
					<li class="icon-backupmgr"><a href="?option=com_configurator&amp;view=backups&amp;format=raw">Backups</a></li>
					<li class="icon-recycle"><a href="?option=com_configurator&amp;view=recycle&amp;format=raw">Recycle Bin</a></li>
				</ul>
				<div class="icon-backup"> 
					<span><a href="?option=com_configurator&amp;task=assets_backup&amp;format=raw&amp;type=gzip" title="click here to download a full backup of your assets folder as a gzipped tarball">Download a Backup</a></span>				
				</div>
			</div>
		</div>
		
		<div id="resources" class="ui-tabs-panel ui-tabs-hide off">
			<?php include dirname(__FILE__).'/../help/help.php'; ?>
		</div>
	</div>

	<div class="clear">&nbsp;</div>
	<?php if($cfg_pref->shelf_position == 2){ include dirname(__FILE__).'/shelf.php'; } ?>
	<?php if($cfg_pref->show_footer == 1){ include dirname(__FILE__).'/footer.php'; } ?>					
						
</div>
<?php
if($cfg_pref->bottom_save >= 1){ ?>
<div id="bottom-save"<?php echo bs_class($cfg_pref->bottom_save); ?> style="display:none;"><a href="#" title="you can configure how this save bar is displayed in the configurator preferences">Save your settings</a></div>
<?php } ?>
<input type="hidden" name="option" value="<?php echo JRequest::getCmd('option', 'com_configurator'); ?>"/>
<input type="hidden" name="t" value="morph"/>
<input type="hidden" name="task" value="" />
</form>

<div id="getting-started" style="display:none;"></div>
<div id="preferences-screen" style="display:none;"><?php include dirname(__FILE__).'/preferences.php'; ?></div>
<div id="keyboard-screen" style="display:none;"></div>
<div class="toolguides" style="display:none;"></div>