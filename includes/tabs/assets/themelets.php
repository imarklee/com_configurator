<?php
$themelet_dir = JPATH_ROOT . DS . 'templates' . DS . 'morph' . DS . 'assets' . DS . 'themelets';
$themeler_url = JURI::root() . DS . 'templates' . DS . 'morph' . DS . 'assets' . DS . 'themelets';
if(is_dir($themelet_dir)) {
	$lists['themelets'] = JFolder::folders( $themelet_dir );
} else {
	$lists['themelets'] = null;
}
?>
<div id="assets-themelets">
	<div id="themelet-switch" class="switch">
		<h2>Manage your assets: <strong>Themelets</strong></h2>
		<p><a href="#" class="themelet-link btn-link">Customize themelet</a>&nbsp;&nbsp;<a href="#" class="upload-themelet btn-link">Upload a new themelet</a>&nbsp;&nbsp;<a href="#" class="switch-view">Switch View</a></p>
	</div>
	
	<div id="themelets-list" class="assets-layout <?php if(isset($_COOKIE['themelets-view']) && $_COOKIE['themelets-view'] == 'list') { echo 'list-view'; } else { setcookie('themelets_view', 'thumb',60*60*24*30, '/'); echo 'thumb-view'; } ?>">
		<ul id="themelets-headers" class="assets-headers">
			<li class="th-name">Themelet Name</li>
			<li class="th-installed">Installed Version</li>
			<li class="th-current">Current Version</li>
			<li class="th-date">Date Added</li>
			<li class="th-activate">Activate</li>
			<li class="th-delete">Delete</li>
			<li class="th-preview">Preview</li>
		</ul>
		
		<ul class="assets-list">
			<?php
	    	foreach ($lists['themelets'] as $themelet){
	    		$themelet_uc = ucwords(str_replace('-', ' ', $themelet));
				$themelet_xml = $themelet_dir . DS . $themelet . DS . 'themeletDetails.xml';
				$themelet_params = xml2array($themelet_xml);
				$themelet_arr = $themelet_params['install'];
				if( $themelet !== $params->get('themelet') ) { $themelet_class = 'tl-inactive'; } else { $themelet_class = 'tl-active'; }
			?>	
				
			<li class="<?php echo $themelet_class; ?>">
				<h3><?php echo $themelet_uc; ?></h3>
				<img src="<?php echo $themelet_url . $themelet . DS .'themelet_thumb.png'; ?>" width="200" height="133" border="0" alt="themelet thumbnail">
				<ul class="themelet-summary <?php echo $themelet_arr['foldername']; ?>">
					<li class="tl-installed"><strong>Installed version: </strong><?php echo $themelet_arr['version']; ?></li>
					<li class="tl-current"><strong>Current version: </strong></li>
					<li class="tl-date"><strong>Last update: </strong><?php echo $themelet_arr['creationDate']; ?></li>
				</ul>
				<ul class="buttons">
					<li class="btn-activate"><a href="#" title="Activate themelet">Activate</a></li>
					<li class="btn-delete"><a href="#" title="Delete themelet">Delete</a></li>
					<li class="btn-preview"><a href="<?php echo $themelet_url . $themelet . DS .'themelet_thumb.png'; ?>" title="Preview themelet">Preview</a></li>
				</ul>
			</li>	
				 
			<?php } ?>
		</ul>
		<!--<p class="assets-location">Your themelets are located in: <strong>"<?php echo $themelet_dir; ?>"</strong>.</p>-->
	</div>
</div>