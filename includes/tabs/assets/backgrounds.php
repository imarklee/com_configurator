<?php
$background_dir = JPATH_ROOT . DS . 'templates' . DS . 'morph' . DS . 'assets' . DS . 'backgrounds';
$background_url = JURI::root() . DS . 'templates' . DS . 'morph' . DS . 'assets' . DS . 'backgrounds';
if(is_dir($background_dir)) {
	$lists['backgrounds'] = JFolder::files( $background_dir );
	unset($lists['backgrounds'][0]);
	$lists['backgrounds'] = array_values($lists['backgrounds']);
} else {
	$lists['backgrounds'] = null;
}
$db=& JFactory::getDBO();
$query = "SELECT param_value FROM `#__configurator` WHERE `param_name` = 'bg_image' ";
$db->setQuery( $query );
$activebg = $db->loadResult();
?>
<div id="assets-backgrounds" class="ui-tabs-hide">
	<div id="backgrounds-switch" class="switch">
		<h2>Manage your assets: <strong>Backgrounds</strong></h2>
		<p><a href="#" class="backgrounds-tab btn-link">Customize background settings</a>&nbsp;&nbsp;<a href="#" class="upload-bg btn-link">Upload a new background</a>&nbsp;&nbsp;<a href="#" class="switch-view">Switch View</a></p>
	</div>
	
	<div id="backgrounds-list" class="assets-layout <?php if(isset($_COOKIE['backgrounds-view']) && $_COOKIE['backgrounds-view'] == 'list') { echo 'list-view'; } else { echo 'thumb-view'; } ?>">
		<ul id="backgrounds-headers" class="assets-headers">
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
			foreach ($lists['backgrounds'] as $background){
				//if( $themelet !== $params->get('themelet') ) { $themelet_class = 'tl-inactive'; } else { $themelet_class = 'tl-active'; }
				$background_src = $background_url.DS.$background;
				$background_size = getimagesize($background_dir.DS.$background);
				$background_width =  $background_size[0];
				$background_height =  $background_size[1];
				$background_size = formatBytes(filesize($background_dir.DS.$background));
				
				if( $background !== $activebg ) { $bg_class = 'tl-inactive'; } else { $bg_class = 'tl-active'; }
			?>	
			<li class="background-item <?php echo $bg_class; ?>">
				<div class="assets-inner">
				<h3><?php echo $background; ?></h3>
				<div class="image-container">
					<div style="background-image: url(<?php echo $background_src; ?>);">&nbsp;</div>
				</div>
				<ul class="background-summary <?php echo $background; ?>">
					<li class="tl-installed"><strong>File size: </strong><?php echo $background_size; ?></li>
					<li class="tl-current"><strong>Width: </strong><?php echo $background_width; ?>px</li>
					<li class="tl-date"><strong>Height: </strong><?php echo $background_height; ?>px</li>
				</ul>
				<ul class="buttons">
					<li class="btn-activate"><a name="<?php echo $background; ?>" href="#" title="Activate <?php echo $background; ?>"><span>Activate</span></a></li>
					<li class="btn-delete"><a name="<?php echo $background; ?>" href="#" title="Delete <?php echo $background; ?>"><span>Delete</span></a></li>
					<li class="btn-preview"><a href="<?php echo $background_src; ?>" title="Preview <?php echo $background; ?>"><span>Preview</span></a></li>
				</ul>
				</div>
			</li>
			<?php } ?>
		</ul>
	<!--<p class="assets-location">Your backgrounds are located in: <strong>"<?php echo $background_dir; ?>"</strong>.</p>-->
	</div>
</div>