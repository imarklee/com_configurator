<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2009 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/
?>
<form action="index.php" method="post" name="adminForm" id="templateform" enctype="multipart/form-data">    	
<div id="cfg" class="container_16<?php if($cfg_pref->shelf_position == 0){ ?> noshelf<?php } if($cfg_pref->shelf_position == 1){ ?> shelftop<?php } if($cfg_pref->shelf_position == 2){ ?> shelfbtm<?php } if($cfg_pref->show_footer == 0 ){ ?> nofooter<?php } if($cfg_pref->show_footer == 1 ){ ?> footer<?php } if($cfg_pref->show_branding == 0){ ?> nobranding<?php } if($cfg_pref->show_branding == 1){ ?> branding<?php } ?>">
	
	<?php if($cfg_pref->show_branding == 1){include dirname(__FILE__) . ''.DS.'top.php'; } ?>
	<?php if($cfg_pref->shelf_position == 1){include dirname(__FILE__) . ''.DS.'shelf.php'; } ?>

	<div class="clear spacer">&nbsp;</div>

	<div id="tabs" class="ui-tabs ui-widget ui-widget-content <?php echo $cfg_pref->settings_effect; ?>">
		<ul class="primary ui-tabs-nav ui-helper-reset ui-helper-clearfix">
			<li class="site-icon ui-tabs-selected"><a href="#site">General</a></li>
			<li class="themelet-icon"><a href="#customize">Customize</a></li>
			<li class="blocks-icon"><a href="#blocks">Building Blocks</a></li>
			<li class="plugins-icon"><a href="#plugins">Plugins</a></li>
			<li class="tools-icon"><a href="#tools">Tools</a></li>
			<li class="assets-icon"><a href="#assets">Your Assets</a></li>
			<li class="help-icon last"><a href="#help">Help</a></li>
		</ul>
		<div id="site" class="ui-tabs-panel">
			<div id="site-tabs" class="subtabs">
				<?php if ($cfg_pref->show_intros == 1 || isset($_COOKIE['site-desc'])) { include dirname(__FILE__).DS.'..'.DS.'general'.DS.'desc-site.php'; } ?>
				<ul class="ui-helper-clearfix ui-tabs-nav">
					<li class="icon-general ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a href="#general-tab">General</a></li>
					<!--<li class="icon-progressive"><a href="#progressive-tab">Progressive Enhancements</a></li>-->
					<li class="icon-performance"><a href="#performance-tab">Performance</a></li>
					<li class="icon-debugging"><a href="#debugging-tab">Debugging</a></li>
                    <li class="icon-components"><a href="#components-tab">Component Layouts</a></li>
				</ul>
				<?php include dirname(__FILE__).DS.'..'.DS.'general'.DS.'general.php' ?>
				<?php //include dirname(__FILE__).DS.'..'.DS.'general'.DS.'progressive.php' ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'general'.DS.'performance.php' ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'general'.DS.'debugging.php' ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'general'.DS.'components.php'?>
			</div>
		</div>

		<div id="customize" class="ui-tabs-panel ui-tabs-hide">
			<div id="customize-tabs" class="subtabs">
				<?php if ($cfg_pref->show_intros == 1 || isset($_COOKIE['themelet-desc'])) { include dirname(__FILE__).DS.'..'.DS.'customize'.DS.'desc-customize.php'; } ?>
				<ul class="ui-helper-clearfix ui-tabs-nav">
					<li class="ui-tabs-selected icon-colors"><a href="#colors-tab">Color Settings</a></li>
					<li class="icon-logos"><a href="#logos-tab">Logo Settings</a></li>
					<li class="icon-backgrounds"><a href="#backgrounds-tab">Background Settings</a></li>
					<li class="icon-menus"><a href="#menus-tab">Menu Settings</a></li>
					<li class="icon-iphone"><a href="#iphone-tab">iPhone Compatibility</a></li>
				</ul>
				<?php include dirname(__FILE__).DS.'..'.DS.'customize'.DS.'colors.php' ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'customize'.DS.'logos.php' ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'customize'.DS.'backgrounds.php' ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'customize'.DS.'menus.php' ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'customize'.DS.'iphone.php' ?>
			</div>
		</div>

		<div id="blocks" class="ui-tabs-panel ui-tabs-hide">
			<div id="blocks-tabs" class="subtabs">
				<?php if ($cfg_pref->show_intros == 1 || isset($_COOKIE['blocks-desc'])) { include dirname(__FILE__).DS.'..'.DS.'blocks'.DS.'desc-blocks.php'; } ?>
				<ul class="ui-helper-clearfix ui-tabs-nav">
					<li class="icon-toolbar ui-tabs-selected"><a href="#toolbar-tab">Toolbar</a></li>
					<li class="icon-mainhead"><a href="#mainhead-tab">Main Header</a></li>
					<li class="icon-subhead"><a href="#subhead-tab">Sub Header</a></li>
					<li class="icon-topnav"><a href="#topnav-tab">Top Menu</a></li>
					<li class="icon-oshelves"><a href="#outer-shelves-tab">Outer Shelves</a></li>
					<li class="icon-ishelves"><a href="#inner-shelves-tab">Inner Shelves</a></li>
					<li class="icon-main"><a href="#main-tab">Main Content</a></li>
					<li class="icon-sidebars"><a href="#outer-sidebar-tab">Outer Sidebar</a></li>
					<li class="icon-sidebars"><a href="#inner-sidebar-tab">Inner Sidebar</a></li>
					<li class="icon-insets"><a href="#insets-tab">Insets</a></li>
					<li class="icon-footer"><a href="#footer-tab">Footer</a></li>
				</ul>
				<?php include dirname(__FILE__).DS.'..'.DS.'blocks'.DS.'toolbar.php' ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'blocks'.DS.'mainhead.php' ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'blocks'.DS.'subhead.php' ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'blocks'.DS.'topnav.php' ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'blocks'.DS.'outer-shelves.php' ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'blocks'.DS.'inner-shelves.php' ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'blocks'.DS.'inset.php' ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'blocks'.DS.'main.php' ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'blocks'.DS.'outer-sidebar.php' ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'blocks'.DS.'inner-sidebar.php' ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'blocks'.DS.'footer.php' ?>
			</div>
		</div>

		<div id="plugins" class="ui-tabs-panel ui-tabs-hide">
			<div id="plugins-tabs" class="subtabs">
				<?php if ($cfg_pref->show_intros == 1 || isset($_COOKIE['plugins-desc'])) { include dirname(__FILE__).DS.'..'.DS.'plugins'.DS.'desc-plugins.php'; } ?>
				<ul class="ui-helper-clearfix ui-tabs-nav">
					<li class="icon-toolbar ui-tabs-selected"><a href="#captify-tab">Fancy Captions</a></li>
					<li class="icon-lazyload"><a href="#lazyload-tab">Lazyload Images</a></li>
					<li class="icon-lazyload"><a href="#lightbox-tab">TopUp Lightbox</a></li>
				</ul>
				<?php include dirname(__FILE__).DS.'..'.DS.'plugins'.DS.'captify.php' ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'plugins'.DS.'lazyload.php' ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'plugins'.DS.'lightbox.php' ?>
			</div>
		</div>

		<div id="tools" class="ui-tabs-panel ui-tabs-hide">
			<div id="tools-tabs" class="subtabs">
				<?php if ($cfg_pref->show_intros == 1 || isset($_COOKIE['tools-desc'])) { include dirname(__FILE__).DS.'../tools/desc-tools.php'; } ?>
				<ul class="ui-helper-clearfix ui-tabs-nav">
					<li class="icon-installer"><a href="#tools-installer">Universal Installer</a></li>
					<li class="icon-db"><a href="#database-manager">Import / Export</a></li>
					<li class="icon-reset"><a href="#reset-settings">Reset Settings</a></li>
					<li class="icon-editor"><a href="#file-editor">File Editor</a></li>
					<li class="icon-editor"><a href="#editor-wrap">Code Editor</a></li>
					<li class="icon-modules"><a href="#module-migrator">Sidebar Modules</a></li>
				</ul>
				<?php include dirname(__FILE__).DS.'..'.DS.'tools'.DS.'uploader.php'; ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'tools'.DS.'database.php'; ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'tools'.DS.'reset.php'; ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'tools'.DS.'editor.php'; ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'tools'.DS.'editor-static.php'; ?>
				<?php include dirname(__FILE__).DS.'..'.DS.'tools'.DS.'modules.php'; ?>
			</div>
		</div>

		<div id="assets" class="ui-tabs-panel ui-tabs-hide">
			<div id="assets-tabs" class="subtabs">
				<?php if ($cfg_pref->show_intros == 1 || isset($_COOKIE['assets-desc'])) { include dirname(__FILE__).DS.'..'.DS.'assets'.DS.'desc-assets.php'; } ?>
				<ul class="ui-helper-clearfix">
					<li class="icon-themelets"><a href="../administrator/index.php?option=com_configurator&amp;task=show_assets&amp;a=themelets&amp;format=raw" title="assets tab themelets">Themelets</a></li>
					<li class="icon-logos"><a href="../administrator/index.php?option=com_configurator&amp;task=show_assets&amp;a=logos&amp;format=raw" title="assets tab logos">Logos</a></li>
					<li class="icon-backgrounds"><a href="../administrator/index.php?option=com_configurator&amp;task=show_assets&amp;a=backgrounds&amp;format=raw" title="assets tab backgrounds">Backgrounds</a></li>
					<li class="icon-iphone"><a href="../administrator/index.php?option=com_configurator&amp;task=show_assets&amp;a=iphone&amp;format=raw" title="assets tab iphone">iPhone</a></li>
					<li class="icon-backupmgr"><a href="../administrator/index.php?option=com_configurator&amp;task=show_assets&amp;a=backup&amp;format=raw" title="assets tab backups">Backups</a></li>
					<li class="icon-recycle"><a href="../administrator/index.php?option=com_configurator&amp;task=show_assets&amp;a=recycle&amp;format=raw" title="assets tab recycle bin">Recycle Bin</a></li>
				</ul>
				<div class="icon-backup"> 
					<span><a href="../administrator/index.php?option=com_configurator&amp;task=assets_backup&amp;format=raw&amp;type=gzip" title="click here to download a full backup of your assets folder as a gzipped tarball">Download a Backup</a></span>				
				</div>
			</div>
		</div>
			
		<div id="help" class="ui-tabs-panel ui-tabs-hide off">
			<?php include dirname(__FILE__).DS.'..'.DS.'help'.DS.'help.php'; ?>
		</div>
	</div>

	<div class="clear">&nbsp;</div>
	<?php if($cfg_pref->shelf_position == 2){ include dirname(__FILE__).DS.'shelf.php'; } ?>
	<?php if($cfg_pref->show_footer == 1){ include dirname(__FILE__).DS.'footer.php'; } ?>					
						
</div>
<?php
if($cfg_pref->bottom_save >= 1){ ?>
<div id="bottom-save"<?php echo bs_class($cfg_pref->bottom_save); ?> style="display:none;"><a href="#" title="you can configure how this save bar is displayed in the configurator preferences">Save your settings</a></div>
<?php } ?>
<input type="hidden" name="option" value="<?php echo $option; ?>"/>
<input type="hidden" name="t" value="morph"/>
<input type="hidden" name="task" value="" />
</form>

<div id="getting-started" style="display:none;"></div>
<div id="preferences-screen" style="display:none;"><?php include dirname(__FILE__).DS.'preferences.php'; ?></div>
<div id="keyboard-screen" style="display:none;"></div>
<div class="toolguides" style="display:none;"></div>