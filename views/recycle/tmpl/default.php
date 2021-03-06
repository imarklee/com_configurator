<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined('_JEXEC') or die('Restricted access');

$recycle_dir = JPATH_ROOT.'/morph_recycle_bin';
$recycle_url = JURI::root().'morph_recycle_bin';
$ftype = '';
$lists['recycle'] = array();
if(is_dir($recycle_dir)) {
	$lists['recycle'] = JFolder::files($recycle_dir, '', false, false, array('DS_Store') );
	foreach(JFolder::folders($recycle_dir, '') as $folder){
		$lists['recycle'][] = $folder;
	}
}

$size = '';
$db = JFactory::getDBO();
$query = "SELECT `pref_value` FROM `#__configurator_preferences` WHERE `pref_name` = 'recycle_threshold';";
$db->setQuery($query);
$limit = ($db->loadResult() * 1024) * 1024;

// threshold warning
foreach ($lists['recycle'] as $recycle){
	$recycle_size = filesize($recycle_dir.'/'.$recycle);
	$size += $recycle_size;
}
$total_remaining = round(($limit - $size) * 100 / max($limit, 1), 0);
if($total_remaining <= 10){ ?>
<div id="threshold-warning">
	<p>Warning: Your Recycle Bin threshold is about to be reached. Please delete individual items or empty the Recycle Bin.</p>
</div>
<?php } ?>

<div id="assets-recycle">
	<div id="recycle-switch" class="switch">
		<h2>Recycle Bin</h2>
		<p><a action="empty" href="#" class="empty-recycle btn-link">Empty Recycle Bin</a></p>
	</div>
	
	<?php if(!empty($lists['recycle'])){ ?>
	<table id="recycle-list" border="0" cellpadding="0" cellspacing="0">
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
				if(is_dir($recycle_dir.'/'.$recycle)){
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
				$recycle_src = $recycle_url.'/'.$recycle;
				$recycle_size = ComConfiguratorHelperUtilities::formatBytes(filesize($recycle_dir.'/'.$recycle));
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
		<tr>
			<td class="summary" rowspan="2" colspan="3">Summary</td>
			<td><strong>Total Usage</strong></td>
			<td><strong>Remaining</strong></td>
		</tr>
		<tr>
			<td><?php echo ComConfiguratorHelperUtilities::formatBytes($size); ?> / <?php echo round($size * 100 / $limit, 0); ?>%</td>
			<td><?php echo ComConfiguratorHelperUtilities::formatBytes(($limit - $size)); ?> / <?php echo round(($limit - $size) * 100 / $limit, 0); ?>%</td>
		</tr>
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