<div id="backup-manager">
	<div id="backup-list" class="assets-layout list-view">
		<ul id="backgrounds-headers" class="assets-headers">
			<li class="th-name">File name</li>
			<li class="th-installed">Size</li>
			<li class="th-date">Date</li>
			<li class="th-type">Type</li>
		</ul>
		<ul class="assets-list">
			<?php 
				$files = JFolder::files(JPATH_ROOT.'/morph_assets/backups/db/', '', false);
				foreach($files as $file){
					if ($file != "." && $file != ".." && $file != ".DS_Store") { ?>
						<li class="backup-item">
							<div class="assets-inner">
							<h3><?php echo $file; ?></h3>
							<ul class="background-summary assets-summary">
								<li class="tl-size"><strong>File size: </strong><?php echo filesize(JPATH_ROOT.'/morph_assets/backups/db/'.$file); ?></li>
								<li class="tl-ype"><strong>Type: </strong>Morph</li>
							</ul>
							<h4>Options for this file:</h4>
							<ul class="buttons">
								<li class="btn-activate"><a name="<?php echo $file; ?>" href="#" title="Download <?php echo $file; ?>"><span>Download</span></a></li>
								<li class="btn-delete"><a name="<?php echo $file; ?>" href="#" title="Delete <?php echo $file; ?>"><span>Delete</span></a></li>
								<li class="btn-preview"><a name="<?php echo $file; ?>" href="#" title="Restore <?php echo $file; ?>"><span>Restore</span></a></li>
							</ul>
							</div>
						</li>
					<?php }
				}
			?>
		</ul>
	</div>
</div>