<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined('_JEXEC') or die('Restricted access');

$iphone_dir = JPATH_ROOT.'/morph_assets/iphone';
$iphone_url = JURI::root().'morph_assets/iphone';
if(is_dir($iphone_dir)) {
	$lists['iphone'] = JFolder::files( $iphone_dir );
} else {
	$lists['iphone'] = '';
}
?>
<div id="assets-iphone">
	<div id="iphone-switch" class="switch">
		<h2>Manage your assets: <strong>iPhone</strong></h2>
		<p><a href="#" class="upload-iphone btn-link">Upload iPhone media</a>&nbsp;&nbsp;<a href="#" class="switch-view">Switch View</a></p>
	</div>
	
	<div id="iphone-list" class="assets-layout <?php if(isset($_COOKIE['iphone-view']) && $_COOKIE['iphone-view'] == 'list') { echo 'list-view'; } else { echo 'thumb-view'; } ?>">
	    <?php if(!empty($lists['iphone'])){ ?>
		<ul id="iphone-headers" class="assets-headers">
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
			foreach ($lists['iphone'] as $iphone){
				//if( $iphone !== $params->get('iphone') ) { $iphone_class = 'tl-inactive'; } else { $iphone_class = 'tl-active'; }
				$iphone_src = $iphone_url.'/'.$iphone;
				$iphone_size = getimagesize($iphone_dir.'/'.$iphone);
				$iphone_width =  $iphone_size[0];
				$iphone_height =  $iphone_size[1];
				$iphone_size = ComConfiguratorHelperUtilities::formatBytes(filesize($iphone_dir.'/'.$iphone));
				
				if( $iphone !== $activebg ) { $bg_class = 'tl-inactive'; } else { $bg_class = 'tl-active'; }
			?>	
			<li class="iphone-item <?php echo $bg_class; ?>">
				<div class="assets-inner">
				<h3><?php echo $iphone; ?></h3>
				<div class="image-container">
					<div style="background-image: url('<?php echo $iphone_src; ?>');">&nbsp;</div>
				</div>
				<ul class="iphone-summary assets-summary">
					<li class="tl-installed"><strong>File size: </strong><?php echo $iphone_size; ?></li>
					<li class="tl-current"><strong>Width: </strong><?php echo $iphone_width; ?>px</li>
					<li class="tl-date"><strong>Height: </strong><?php echo $iphone_height; ?>px</li>
				</ul>
				<h4>Options for this file:</h4>
				<ul class="buttons">
					<li class="btn-activate"><a name="<?php echo $iphone; ?>" href="#" title="Activate <?php echo $iphone; ?>"><span>Activate</span></a></li>
					<li class="btn-delete"><a name="<?php echo $iphone; ?>" href="#" title="Delete <?php echo $iphone; ?>"><span>Delete</span></a></li>
					<li class="btn-preview"><a href="<?php echo $iphone_src; ?>" title="Preview <?php echo $iphone; ?>"><span>Preview</span></a></li>
				</ul>
				</div>
			</li>
		<?php } ?>
		</ul>
		<?php }else{ ?>
			<div class="no-assets">
				There is currently no iPhone media in your assets folder. <a href="#" class="upload-iphone">Upload iPhone media?</a>
			</div>
		<?php }	?>
	<!--<p class="assets-location">Your iphone are located in: <strong>"<?php echo $iphone_dir; ?>"</strong>.</p>-->
	</div>
</div>