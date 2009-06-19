<?php
$background_dir = JPATH_ROOT . DS . 'templates' . DS . 'morph' . DS . 'assets' . DS . 'backgrounds';
$background_url = JURI::root() . DS . 'templates' . DS . 'morph' . DS . 'assets' . DS . 'backgrounds';
if(is_dir($background_dir)) {
	$lists['backgrounds'] = JFolder::files( $background_dir );
} else {
	$lists['backgrounds'] = null;
}
?>
<div id="backgrounds-switch" class="switch">
	<h2>Backgrounds</h2>
	<a href="#" class="switch_thumb">Switch View</a>
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
		?>	
		<li>
			<h3><?php echo $background; ?></h3>
			<div class="image-container">
				<div style="background-image: url(<?php echo $background_src; ?>);">&nbsp;</div>
			</div>
			<ul class="background-summary">
				<li class="tl-installed"><strong>File size: </strong><?php echo $background_size; ?></li>
				<li class="tl-current"><strong>Width: </strong><?php echo $background_width; ?>px</li>
				<li class="tl-date"><strong>Height: </strong><?php echo $background_height; ?>px</li>
			</ul>
			<ul class="buttons">
				<li class="btn-activate"><a href="#" title="Activate background">Activate</a></li>
				<li class="btn-delete"><a href="#" title="Delete background">Delete</a></li>
				<li class="btn-preview"><a href="<?php echo $background_src; ?>" title="Preview background">Preview</a></li>
			</ul>
		</li>
		<?php } ?>
	</ul>
	<p class="assets-location">Your backgrounds are located in: <strong>"<?php echo $background_dir; ?>"</strong>.</p>
</div>