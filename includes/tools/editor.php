<?php
$template_dir = JPATH_SITE.'/templates/morph';
$themelet_dir = JPATH_SITE.'/morph_assets/themelets';

$template_files = JFolder::files($template_dir);
$themelets = JFolder::folders($themelet_dir);

$template_is_editable = array('component.php', 'error.php', 'offline.php');
$themelet_is_editable = array('custom.php', 'custom.js.php', 'custom.css.php', 'script.php');
$files = array('custom.php' => 'custom php', 'custom.js.php' => 'custom js', 'custom.css.php' => 'custom css', 'script.php' => 'custom footer code');
?>
<div id="editor-wrap">
	<h2>Code Editor</h2>
	<div id="editor-desc">
		<p>The code editor is used to add your own custom css, javascript or php and will save your custom code in the database, protecting your changes from upgrades. If you find the editor sluggish, try disabling the syntax highlighting in the Configurator preferences.</p>
	</div>
	<ul>
		
	    <li class="file-list">
	        <span>
    	        <select name="editor-list" id="editor-list" size="1">
    	       		<option value="">select file to edit</option>
    	            <optgroup label="Template files">
						<?php 
						foreach($template_files as $file){
							if(in_array($file, $template_is_editable)){
								echo '<option value="template/morph/'.$file.'">'.$file.'</option>';
							}
						}
						?>
    	            </optgroup>
    	            <optgroup label="<?php echo ucwords(str_replace('-', ' ', $params->get('themelet'))) ?> files" class="active-themelet">
    	            	<?php 
    	            	foreach($files as $file => $title){
    	            		echo '<option value="themelet/'.$params->get('themelet').'/'.$file.'" class="active-themelet">'.$title.'</option>';
    	            	}
    	            	?>
    	            </optgroup>
					<?php 
					foreach($themelets as $themelet){
						if($params->get('themelet') == $themelet) continue;
						$themelet_proper = ucwords(str_replace('-', ' ', $themelet));
						echo '<optgroup label="'.$themelet_proper.' files">';
						foreach($files as $file => $title){
							echo '<option value="themelet/'.$themelet.'/'.$file.'">'.$title.'</option>';
						}
						echo '</optgroup>';
					}
					?>
    	        </select>
	        </span>
	    </li>
		<li class="editor-controls"><a action="cancel" href="#" class="btn-link">Cancel</a></li>
		<li class="editor-controls"><a action="apply" href="#" class="btn-link">Apply</a></li>
		<li class="editor-controls"><a action="save" href="#" class="btn-link">Save</a></li>
		<li><div id="editor-notification"><span>saving</span><img src="../administrator/components/com_configurator/images/ajax-loader.gif" height="31" width="31" /></div></li>
	</ul>
    <div id="editor">
        <textarea name="editor" id="custom-code" rows="20" cols="113" style="display:none;"></textarea>
		<div id="select-info">
			<p>To begin editing a file, select a file from the menu above.</p>
		</div>
    </div>
</div>