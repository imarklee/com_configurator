<?php
$template_dir = JPATH_SITE.DS.'templates'.DS.'morph';
$themelet_dir = JPATH_SITE.DS.'morph_assets'.DS.'themelets';

$template_files = JFolder::files($template_dir);
$themelets = JFolder::folders($themelet_dir);

$template_is_editable = array('component.php', 'error.php', 'offline.php');
$themelet_is_editable = array('custom.php', 'custom.js.php', 'custom.css.php');
?>
<div id="file-editor">
	<h2>File Editor: Custom Files</h2>
	
	<?php 
	foreach($template_files as $file){
		if(in_array($file, $template_is_editable)){
			echo $file . '<br />';
		}
	}
	?>
	
	<h3>Themelet Files</h3>
	<p>Select a themelet to view/edit the custom files belonging to that themelet.</p>
	<ul>
	<?php 
	foreach($themelets as $themelet){
		$themelet_files = JFolder::files($themelet_dir.DS.$themelet, '', true, false, array('.git'));
		echo '<li>'.$themelet;
		if(!empty($themelet_files)){
			foreach($themelet_files as $file){
				if(in_array($file, $themelet_is_editable)){
					echo '<li>'.$file.'</li>';
				}
			}
		}
		echo '</li>';
	}
	?>
	
</div>