<?php 


?>

<div id="backgrounds-switch" class="switch">
	<h2>Backgrounds</h2>
	<a href="#" class="switch_thumb">Switch View</a>
</div>

<div id="backgrounds-list" class="assets-layout <?php if(isset($_COOKIE['backgrounds-view']) && $_COOKIE['logos-view'] == 'list') { echo 'list-view'; } else { echo 'thumb-view'; } ?>">
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
		<li>
			<h3>mycustombg.jpg</h3>
			<div class="image-container">
				<div style="background-image: url(images/backgrounds/bg1.gif);">&nbsp;</div>
			</div>
			<ul class="background-summary">
				<li class="tl-installed"><strong>File size: </strong>24kb</li>
				<li class="tl-current"><strong>Width: </strong>100px</li>
				<li class="tl-date"><strong>Height: </strong>20px</li>
			</ul>
			<ul class="buttons">
				<li class="btn-activate"><a href="#" title="Activate themelet">Activate</a></li>
				<li class="btn-delete"><a href="#" title="Delete themelet">Delete</a></li>
				<li class="btn-preview"><a href="#" title="Preview themelet">Preview</a></li>
			</ul>
		</li>
	</ul>
	<p class="assets-location">Your backgrounds are located in: <strong>"public_html/assets/backgrounds"</strong>.</p>
</div>