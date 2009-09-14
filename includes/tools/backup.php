<div id="backup-manager">
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
			$files = JFolder::files(JPATH_ROOT.'/morph_assets/backups/db/', '', false);
			foreach($files as $file){
				if ($file != "." && $file != ".." && $file != ".DS_Store") { ?>
					<tr>
					    <td class="filename"><?php echo $file; ?></td>
					    <td><?php echo filesize(JPATH_ROOT.'/morph_assets/backups/db/'.$file); ?></td>
					    <td>12 Sept 09</td>
					    <td>Full Database</td>
					    <td><a name="<?php echo $file; ?>" href="#" title="Download <?php echo $file; ?>"><span>Download</span></a></td>
					    <td><a name="<?php echo $file; ?>" href="#" title="Delete <?php echo $file; ?>"><span>Delete</span></a></td>
					    <td><a name="<?php echo $file; ?>" href="#" title="Restore <?php echo $file; ?>"><span>Restore</span></a></td>
					</tr>
				<?php }
			}
		?>
	</table>
</div>