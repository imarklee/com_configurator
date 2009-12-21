<?php
$template_dir = JPATH_SITE.DS.'templates'.DS.'morph';
$themelet_dir = JPATH_SITE.DS.'morph_assets'.DS.'themelets';

$template_files = JFolder::files($template_dir);
$themelets = JFolder::folders($themelet_dir);

$template_is_editable = array('component.php', 'error.php', 'offline.php');
$themelet_is_editable = array('custom.php', 'custom.js.php', 'custom.css.php', 'script.php');
?>
<div id="editor-wrap">
	<h2>Code Editor</h2>
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
					<?php 
					foreach($themelets as $themelet){
						$themelet_files = JFolder::files($themelet_dir.DS.$themelet, '', true, false, array('.git'));
						$themelet_proper = ucwords(str_replace('-', ' ', $themelet));
						echo '<optgroup label="'.$themelet_proper.' files">';
						if(!empty($themelet_files)){
							foreach($themelet_files as $file){
								if(in_array($file, $themelet_is_editable)){
									$file_name = str_replace(array('.js.php', '.css.php', 'script.php', '.php'), array(' javascript', ' css','custom footer code' , ' php'), $file);
									echo '<option value="themelet/'.$themelet.'/'.$file.'">'.$file_name.'</option>';
								}
							}
						}
						echo '</optgroup>';
					}
					?>
    	        </select>
	        </span>
	    </li>
		<li class="editor-controls"><a action="cancel" href="#" class="btn-link">Cancel</a></li>
		<li class="editor-controls"><a action="save" href="#" class="btn-link">Save</a></li>    
		<li class="editor-controls"><a action="apply" href="#" class="btn-link">Apply</a></li>
		<li><div id="editor-notification"><span>saving</span><img src="../administrator/components/com_configurator/images/ajax-loader.gif" height="31" width="31" /></div></li>
	</ul>
    <div id="editor">
        <textarea name="editor" id="custom-code" rows="20" cols="113" style="display:none;"></textarea>
		<div id="select-info">
			<p>To begin editing a file, select a file from the menu above.</p>
		</div>
    </div>
</div>