<?php
$logo_dir = JPATH_ROOT . DS . 'templates' . DS . 'morph' . DS . 'assets' . DS . 'logos';
$logo_url = JURI::root() . DS . 'templates' . DS . 'morph' . DS . 'assets' . DS . 'logos';
if(is_dir($logo_dir)) {
	$lists['logos'] = JFolder::files( $logo_dir );
	unset($lists['logos'][0]);
	$lists['logos'] = array_values($lists['logos']);
} else {
	$lists['logos'] = null;
}
?>

<div id="assets-logos" class="ui-tabs-hide">
	<div id="logos-switch" class="switch">
		<h2>Logos</h2>
		<p class="assets-location">Your logos are located in: <strong>"<?php echo $logo_dir; ?>"</strong>.</p>
		<a href="#" class="switch_thumb">Switch View</a>
	</div>
	
	<div id="logos-list" class="assets-layout <?php if(isset($_COOKIE['logos-view']) && $_COOKIE['logos-view'] == 'list') { echo 'list-view'; } else { echo 'thumb-view'; } ?>">
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
				//if( $themelet !== $params->get('themelet') ) { $themelet_class = 'tl-inactive'; } else { $themelet_class = 'tl-active'; }
				$logo_src = $logo_url.DS.$logo;
				$logo_size = getimagesize($logo_dir.DS.$logo);
				$logo_width =  $logo_size[0];
				$logo_height =  $logo_size[1];
				$logo_size = formatBytes(filesize($logo_dir.DS.$logo));
			?>	
			<li>
				<h3><?php echo $logo; ?></h3>
				<div class="image-container">
					<div style="background-image: url(<?php echo $logo_src; ?>);">&nbsp;</div>
				</div>
				<ul class="logo-summary">
					<li class="tl-installed"><strong>File size: </strong><?php echo $logo_size; ?></li>
					<li class="tl-current"><strong>Width: </strong><?php echo $logo_width; ?>px</li>
					<li class="tl-date"><strong>Height: </strong><?php echo $logo_height; ?>px</li>
				</ul>
				<ul class="buttons">
					<li class="btn-activate"><a href="#" title="Activate Logo">Activate</a></li>
					<li class="btn-delete"><a href="#" title="Delete Logo">Delete</a></li>
					<li class="btn-preview"><a class="assets-logo-preview" href="<?php echo $logo_src; ?>" title="Preview Logo">Preview</a></li>
				</ul>
			</li>
			<?php } ?>
		</ul>
	</div>
</div>