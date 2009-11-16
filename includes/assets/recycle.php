<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2009 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

$recycle_dir = JPATH_ROOT.DS.'morph_recycle_bin';
$recycle_url = JURI::root().'morph_recycle_bin';
$ftype = '';
if(is_dir($recycle_dir)) {
	$lists['recycle'] = JFolder::files($recycle_dir, '', false, false, array('.DS_Store') );
	foreach(JFolder::folders($recycle_dir, '') as $folder){
		$lists['recycle'][] = $folder;
	}
} else {
	$lists['recycle'] = '';
}
?>
<div id="assets-recycle">
	<div id="recycle-switch" class="switch">
		<h2>Recycle Bin</h2>
		<p><a action="empty" href="#" class="empty-recycle btn-link">Empty Recycle Bin</a></p>
	</div>
	
	<div id="recycle-list" class="assets-layout <?php if(isset($_COOKIE['recycle-view']) && $_COOKIE['recycle-view'] == 'list') { echo 'thumb-view'; } else { echo 'list-view'; } ?>">
	    <?php if(!empty($lists['recycle'])){ ?>
		<ul id="recycle-headers" class="assets-headers">
			<li class="th-name">File name</li>
			<li class="th-installed">Size</li>
			<li class="th-restore">Restore</li>
			<li class="th-delete">Delete</li>
		</ul>
		<ul class="assets-list">
			<?php
			foreach ($lists['recycle'] as $recycle){
				if(is_dir($recycle_dir.DS.$recycle)){
					$ftype = 'themelet';
				}else{
					if(preg_match('/db_/i', $recycle)){
						$ftype = 'db';
					}
					if(preg_match('/file_/i', $recycle)){
						$ftype = 'file';
					}
					if(preg_match('/\.[jpg|png|gif|jpeg]/i', $recycle)){
						$split = explode('_', $recycle);
						$ftype = $split[0];
					}
				}
				$recycle_src = $recycle_url.DS.$recycle;
				$recycle_size = formatBytes(filesize($recycle_dir.DS.$recycle));
				$recycle_file = str_replace(array('logo_', 'bg_', 'iphone_'), '', $recycle);
				
			?>	
			<li class="recycle-item">
				<div class="assets-inner">
				<h3><?php echo $recycle_file; ?></h3>
				<div class="image-container">
					<div style="background-image: url('<?php echo $recycle_src; ?>');">&nbsp;</div>
				</div>
				<ul class="recycle-summary assets-summary">
					<li class="tl-installed"><strong>File size: </strong><?php echo $recycle_size; ?></li>
				</ul>
				<h4>Options for this file:</h4>
				<ul class="buttons">
					<li class="btn-restore"><a action="restore" name="<?php echo $recycle; ?>" ftype="<?php echo $ftype; ?>" href="#" title="Restore <?php echo $recycle; ?>"><span>Restore</span></a></li>
					<li class="btn-delete"><a action="delete" name="<?php echo $recycle; ?>" ftype="<?php echo $ftype; ?>" href="#" title="Delete <?php echo $recycle; ?>"><span>Delete</span></a></li>
				</ul>
				</div>
			</li>
		<?php } ?>
		</ul>
		<?php }else{ ?>
			<div class="no-assets">
				The Recycle Bin is empty.
			</div>
		<?php }	?>
	<!--<p class="assets-location">Your recycle are located in: <strong>"<?php echo $recycle_dir; ?>"</strong>.</p>-->
	</div>
</div>