<?php
$logo_dir = JPATH_ROOT . DS . 'templates' . DS . 'morph' . DS . 'assets' . DS . 'logos';
$logo_url = JURI::root() . DS . 'templates' . DS . 'morph' . DS . 'assets' . DS . 'logos';
if(is_dir($logo_dir)) {
	$lists['logos'] = JFolder::folders( $logo_dir );
	print_r($lists['logos']);
} else {
	$lists['logos'] = null;
}
?>

<div id="logos-switch" class="switch">
	<h2>Logos</h2>
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
    		
    		echo $logo;
			if( $themelet !== $params->get('themelet') ) { $themelet_class = 'tl-inactive'; } else { $themelet_class = 'tl-active'; }
		?>	
		<li>
			<h3>logo.jpg</h3>
			<div class="image-container">
				<div style="background-image: url(images/logos/logo.png);">&nbsp;</div>
			</div>
			<ul class="logo-summary">
				<li class="tl-installed"><strong>File size: </strong>26kb</li>
				<li class="tl-current"><strong>Width: </strong>200px</li>
				<li class="tl-date"><strong>Height: </strong>150px</li>
			</ul>
			<ul class="buttons">
				<li class="btn-activate"><a href="#" title="Activate themelet">Activate</a></li>
				<li class="btn-delete"><a href="#" title="Delete themelet">Delete</a></li>
				<li class="btn-preview"><a href="#" title="Preview themelet">Preview</a></li>
			</ul>
		</li>
		<?php } ?>
	</ul>
	<p class="assets-location">Your logos are located in: <strong>"<?php echo $logo_dir; ?>"</strong>.</p>
</div>