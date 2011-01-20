<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined('_JEXEC') or die('Restricted access');

$logo_dir = JPATH_ROOT.'/morph_assets/logos';
$logo_url = JURI::root().'/morph_assets/logos';
if(is_dir($logo_dir)) {
	$lists['logos'] = JFolder::files( $logo_dir );
} else {
	$lists['logos'] = null;
}

$activelogo = JTable::getInstance('ConfiguratorTemplateSettings', 'Table')->param('logo_image')->getItem()->value;
?>
<div id="assets-logos">
	<div id="logos-switch" class="switch">
		<h2>Manage your assets: <strong>Logos</strong></h2>
		<p><a href="#" class="logo-tab btn-link">Customize logo settings</a>&nbsp;&nbsp;<a href="#" class="upload-logo btn-link">Upload a new logo</a>&nbsp;&nbsp;<a href="#" class="switch-view">Switch View</a></p>
	</div>
	<div id="logos-list" class="assets-layout <?php if(isset($_COOKIE['logos-view']) && $_COOKIE['logos-view'] == 'list') { echo 'list-view'; } else { echo 'thumb-view'; } ?>">
		<?php if(!empty($lists['logos'])){ ?>
		<ul id="logos-headers" class="assets-headers">
			<li class="th-name">File name</li>
			<li class="th-installed">Size</li>
			<li class="th-current">Width</li>
			<li class="th-date">Height</li>
			<li class="th-activate">Activate</li>
			<li class="th-delete">Delete</li>
			<li class="th-preview">Preview</li>
		</ul>
		<ul class="assets-list">
			<?php 
				foreach ($lists['logos'] as $logo){
				$logo_src = $logo_url.'/'.$logo;
				$logo_size = getimagesize($logo_dir.'/'.$logo);
				$logo_width =  $logo_size[0];
				$logo_height =  $logo_size[1];
				$logo_size = KFactory::get('admin::com.configurator.helper.utilities')->formatBytes(filesize($logo_dir.'/'.$logo));
				
				if( $logo !== $activelogo ) { $logo_class = 'tl-inactive'; } else { $logo_class = 'tl-active'; }
			?>	
			<li class="logo-item <?php echo $logo_class; ?>">
				<div class="assets-inner">
				<h3><?php echo $logo; ?></h3>
				<div class="image-container">
					<div style="background-image: url('<?php echo $logo_src; ?>');">&nbsp;</div>
				</div>
				<ul class="logo-summary assets-summary">
					<li class="tl-installed"><strong>File size: </strong><?php echo $logo_size; ?></li>
					<li class="tl-current"><strong>Width: </strong><?php echo $logo_width; ?>px</li>
					<li class="tl-date"><strong>Height: </strong><?php echo $logo_height; ?>px</li>
				</ul>
			    <h4>Options for this file:</h4>
				<ul class="buttons">
					<li class="btn-activate"><a name="<?php echo $logo; ?>" href="#" title="Activate <?php echo $logo; ?>"><span>Activate</span></a></li>
					<li class="btn-delete"><a name="<?php echo $logo; ?>" href="#" title="Delete <?php echo $logo; ?>"><span>Delete</span></a></li>
					<li class="btn-preview"><a class="assets-logo-preview" href="<?php echo $logo_src; ?>" title="Preview Logo"><span>Preview</span></a></li>
				</ul>
				</div>
			</li>
		<?php } ?>
		</ul>
		<?php }else{ ?>
		<div class="no-assets">
			There are currently no logos in your assets folder. <a href="#" class="upload-logo">Upload a logo?</a>
		</div>
		<?php }	?>
	<!--<p class="assets-location">Your logos are located in: <strong>"<?php echo $logo_dir; ?>"</strong>.</p>-->
	</div>
</div>