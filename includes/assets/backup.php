<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2009 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

?>
<div id="backup-manager">
    <h2>Backup Manager</h2>
    <p>Below is a list of backups that are automatically created by Configurator. Please use this tool with caution when restoring Database backups.</p>
		<?php 
			$db = JFactory::getDBO();
			$query = $db->setQuery("select param_value from #__configurator where param_name = 'themelet';");
			$curr_themelet = $db->loadResult($query);
			$files = JFolder::files(JPATH_ROOT.DS.'morph_assets'.DS.'backups', '', true, false);
			if(!empty($files)){ ?>
				<table cellpadding="0" cellspacing="0" border="0" id="backup-list" class="table">
			        <tr>
			            <th class="filename">File Name</th>
			            <th>Size</th>
			            <th>Date</th>
						<th>Time</th>
			            <th>Type</th>
			            <th>Action</th>
					</tr>
				<?php
				foreach($files as $file){

					if ($file != "." && $file != ".." && $file != ".DS_Store") { 
						$splitfile = explode('_', $file);
						switch($splitfile[0]){
							case 'db':
							$folder = 'db'.DS;
							break;
							case 'file':
							$folder = '';
							break;
						}
						
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
							case 'themelet':
							$type = 'Themelet Files';
							break;
							case 'template':
							$type = 'Template Files';
							break;
						}
						if(array_key_exists(3, $splitfile)) :
							$timestamp = str_replace(array('.sql.gz', '.gz'), '', $splitfile[3]);
							$date = date('d M y', $timestamp);
							$time = date('H:i', $timestamp);
							$name = $splitfile[2];
						else:
							$timestamp = str_replace(array('.sql.gz', '.gz'), '', $splitfile[2]);
							$date = date('d M y', $timestamp);
							$time = date('H:i', $timestamp);
							$name = '';
						endif;
						
							
					?>
						<tr class="<?php echo $splitfile[0] . ' ' . $splitfile[1]; ?>">
						    <td class="filename"><?php echo $file; ?></td>
						    <td><?php echo formatBytes(filesize(JPATH_ROOT.DS.'morph_assets'.DS.'backups'.DS.$folder.$file)); ?></td>
						    <td><?php echo $date; ?></td>
							<td><?php echo $time; ?></td>
						    <td><?php echo $type; ?></td>
						    <td>
								<a class="icon download" action="download" bu_type="<?php echo $splitfile[0]; ?>" name="<?php echo $file; ?>" href="#" title="Download <?php echo $file; ?>"><span>Download</span></a>
								<a class="icon delete" action="delete" bu_type="<?php echo $splitfile[0]; ?>" name="<?php echo $file; ?>" href="#" title="Delete <?php echo $file; ?>"><span>Delete</span></a>
						    	<?php if($splitfile[0] !== 'file' && $splitfile[1] == 'themelet-settings' && $name == $curr_themelet || $splitfile[0] !== 'file' && $splitfile[1] !== 'themelet-settings'){ ?>
						    		<a class="icon restore" action="restore" bu_type="<?php echo $splitfile[0]; ?>" name="<?php echo $file; ?>" href="#" title="Restore <?php echo $file; ?>"><span>Restore</span></a>
						    	<?php } ?>
							</td>
						</tr>
					<?php }
				}
			}else{ ?>
				<div class="no-assets">There are currently no database backups.</div>
			<?php }
		?>
	</table>
</div>