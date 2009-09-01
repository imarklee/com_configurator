<?php
$themelet_dir = JPATH_ROOT . DS . 'morph_assets' . DS . 'themelets';
$themelet_url = JURI::root().'morph_assets' . DS . 'themelets' . DS;
if(is_dir($themelet_dir)) {
	$lists['themelets'] = JFolder::folders( $themelet_dir );
} else {
	$lists['themelets'] = 'test';
}
?>
<div id="assets-themelets">
	<div id="themelet-switch" class="switch">
		<h2>Manage your assets: <strong>Themelets</strong></h2>
		<p><a href="#" class="themelet-tab btn-link">Customize themelet</a>&nbsp;&nbsp;<a href="#" class="upload-themelet btn-link">Upload a new themelet</a>&nbsp;&nbsp;<a href="#" class="switch-view">Switch View</a></p>
	</div>
	
	<div id="themelets-list" class="assets-layout <?php if(isset($_COOKIE['themelets-view']) && $_COOKIE['themelets-view'] == 'list') { echo 'list-view'; } else { setcookie('themelets_view', 'thumb',60*60*24*30, '/'); echo 'thumb-view'; } ?>">
		<?php if(!empty($lists['themelets'])){ ?>
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
				if(isset($_COOKIE['us_'.$themelet_arr['foldername']])){ 
					$cookie_val = split('##', $_COOKIE['us_'.$themelet_arr['foldername']]); 
					$us_version = $cookie_val[0];
					$us_updated = $cookie_val[1];
				}else{
					$us_version = '';
					$us_updated = '';
				}
				if( $themelet !== $params->get('themelet') ) { $themelet_class = 'tl-inactive'; } else { $themelet_class = 'tl-active'; }
			?>	
				
			<li class="themelet-item <?php echo $themelet_class; ?>">
				<div class="assets-inner">
				<h3><?php echo $themelet_uc; ?></h3>
				<img src="<?php echo $themelet_url . $themelet . DS .'themelet_thumb.png'; ?>" width="197" height="133" border="0" alt="themelet thumbnail">
				<ul class="themelet-summary assets-summary">
					<li class="tl-installed"><strong>Installed version: </strong><?php echo $themelet_arr['version']; ?></li>
					<li class="tl-current"><strong>Current version: </strong><?php echo $us_version; ?></li>
					<li class="tl-date"><strong>Last update: </strong><?php echo $us_updated; ?></li>
				</ul>
				<h4>Options for this file:</h4>
				<ul class="buttons">
					<li class="btn-activate"><a name="<?php echo $themelet_arr['foldername']; ?>" href="#" title="Activate <?php echo $themelet_uc; ?>"><span>Activate</span></a></li>
					<li class="btn-delete"><a name="<?php echo $themelet_arr['foldername']; ?>" href="#" title="Delete <?php echo $themelet_uc; ?>"><span>Delete</span></a></li>
					<li class="btn-preview"><a href="<?php echo $themelet_url . $themelet . DS .'themelet_thumb.png'; ?>" title="Preview <?php echo $themelet_uc; ?>"><span>Preview</span></a></li>
				</ul>
				</div>
			</li>	
			<?php }	
			} else { ?>
				
				<div class="no-assets">
					There are currently no themelets in your assets folder. <a href="#" class="upload-themelet">Upload a themelet?</a>
				</div>
					
				<?php }	?>
		</ul>
	</div>
</div>