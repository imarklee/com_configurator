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
	
	<table id="recycle-list" border="0" cellpadding="0" cellspacing="0">
	    <?php if(!empty($lists['recycle'])){ ?>
		<thead>
		    <tr>
    			<th class="th-name">File name</th>
    			<th class="th-type">Type</th>
    			<th class="th-installed">Size</th>
    			<th class="th-restore">Restore</th>
    			<th class="th-delete">Delete</th>
			</tr>
		</thead>
		<tbody>
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
			<tr>
				<td class="item-name">
				    <?php echo $recycle_file; ?>
				</td>
				<td class="item-type">
				    <?php echo $ftype; ?>
				</td>
				<td class="item-size">
				    <?php echo $recycle_size; ?>
				</td>
				<td class="item-restore">
				    <a action="restore" name="<?php echo $recycle; ?>" ftype="<?php echo $ftype; ?>" href="#" title="Restore <?php echo $recycle; ?>"><span>Restore</span></a>
				</td>
				<td class="item-delete">
				    <a action="delete" name="<?php echo $recycle; ?>" ftype="<?php echo $ftype; ?>" href="#" title="Delete <?php echo $recycle; ?>"><span>Delete</span></a>
				</td>
			</tr>
		<?php } ?>
		</tbody>
		</table>
		<?php }else{ ?>
			<div class="no-assets">
				The Recycle Bin is empty.
			</div>
		<?php }	?>
	<!--<p class="assets-location">Your recycle are located in: <strong>"<?php echo $recycle_dir; ?>"</strong>.</p>-->
	</div>
</div>