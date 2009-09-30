<div id="backup-manager">
    <h2>Database Backups</h2>
    <p>Below is a list of database backups that are automatically by Configurator. Please use this tool with caution.</p>
		<?php 
			$db = JFactory::getDBO();
			$query = $db->setQuery("select param_value from #__configurator where param_name = 'themelet';");
			$curr_themelet = $db->loadResult($query);
			$files = JFolder::files(JPATH_ROOT.'/morph_assets/backups/db/', '', false);
			if(!empty($files)){ ?>
				<table cellpadding="0" cellspacing="0" border="0" id="backup-list" class="table">
			        <tr>
			            <th class="filename">File Name</th>
			            <th>Size</th>
			            <th>Date</th>
			            <th>Type</th>
			            <th>Download</th>
			            <th>Delete</th>
			            <th>Restore</th>
					</tr>
				<?php
				foreach($files as $file){
					if ($file != "." && $file != ".." && $file != ".DS_Store") { 
						$splitfile = explode('_', $file);
						switch($splitfile[1]){
							case 'full-database':
							$type = 'Full Database';
							break;
							case 'themelet-settings':
							$type = 'Themelet Settings';
							break;
							case 'configurator-preferences':
							$type = 'Configurator Preferences';
							break;
							case 'configurator-settings':
							$type = 'Configurator Settings';
							break;
						}
						if(array_key_exists(3, $splitfile)) :
							$date = date('d M y', str_replace('.sql.gz', '', $splitfile[3]));
							$name = $splitfile[2];
						else:
							$date = date('d M y', str_replace('.sql.gz', '', $splitfile[2]));
							$name = '';
						endif;
							
					?>
						<tr>
						    <td class="filename"><?php echo $file; ?></td>
						    <td><?php echo formatBytes(filesize(JPATH_ROOT.'/morph_assets/backups/db/'.$file)); ?></td>
						    <td><?php echo $date; ?></td>
						    <td><?php echo $type; ?></td>
						    <td><a action="download" name="<?php echo $file; ?>" href="#" title="Download <?php echo $file; ?>"><span>Download</span></a></td>
						    <td><a action="delete" name="<?php echo $file; ?>" href="#" title="Delete <?php echo $file; ?>"><span>Delete</span></a></td>
						    <td><?php if($splitfile[1] == 'themelet-settings' && $name == $curr_themelet || $splitfile[1] !== 'themelet-settings'){ ?>
						    	<a action="restore" name="<?php echo $file; ?>" href="#" title="Restore <?php echo $file; ?>"><span>Restore</span></a>
						    <?php } ?></td>
						</tr>
					<?php }
				}
			}else{ ?>
				<div class="no-assets">There are currently no database backups.</div>
			<?php }
		?>
	</table>
</div>