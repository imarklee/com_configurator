<?php
function innerLayouts($id){
	error_reporting(E_ALL ^ E_NOTICE);
	include JPATH_ROOT.'/templates/morph/core/InnerLayout.php';
	$select_option = array(
		'Select Inner Default',
		'50/50 Split',
		'66/33 Split',
		'33/66 Split',
		'75/25 Split',
		'25/75 Split'
	);
	$select = '<select id="'.$id.'">';
	foreach($innerPageSuffix as $key => $val){
		$select .= '<option value="'.$key.'">'.$select_option[$key].'</option>';
	}
	$select .= '</select>';
	return $select;
}
function outerLayouts($id){
	include JPATH_ROOT.'/templates/morph/core/OuterLayout.php';
	$select_option = array(
		'Select Outer Default',
		'160px left',
		'180px left',
		'300px left',
		'180px right',
		'240px right',
		'300px right',
		'Not Avail',
		'200px left',
		'200px right'
	);
	$select = '<select id="'.$id.'">';
	foreach($outerPageSuffix as $key => $val){
		$select .= '<option value="'.$key.'">'.$select_option[$key].'</option>';
	}
	$select .= '</select>';
	return $select;
}
?>

<div id="components-tab" class="ui-tabs-panel">
	<div id="components-options" class="options-panel">
		<h3>Component Defaults</h3>
		<ol class="forms">
			<?php
			$db = JFactory::getDBO();
			$query = $db->setQuery("select * from #__components where parent = '0' ;");
			$res = $db->loadAssocList($query);
			foreach($res as $r){ 
				$rlab = strtolower(str_replace(' ', '-', $r['name'])); ?>
				<li><label id="components<?php echo $rlab; ?>-lbl" class="to-label" for="<?php echo $rlab; ?>">	
				<?php echo $r['name']; ?></label>
				<?php echo innerLayouts($rlab);?>
				<?php echo outerLayouts($rlab);?>
				</li>
			<?php } ?>
		</ol>
	</div>
	<div id="components-info" class="info-panel">
	<p>Feed me content ;)</p>
	</div>
</div>


