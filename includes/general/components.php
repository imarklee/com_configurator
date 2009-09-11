<?php
function innerLayouts($id){
	error_reporting(E_ALL ^ E_NOTICE);
	include JPATH_ROOT.'/templates/morph/core/InnerLayout.php';
	$select_option = array(
		'Inner default',
		'50/50 Split',
		'66/33 Split',
		'33/66 Split',
		'75/25 Split',
		'25/75 Split'
	);
	$select = '<select id="'.$id.'" name="components_inner[id_'.str_replace('-', '_', $id).']">';
	foreach($innerPageSuffix as $key => $val){
		$select .= '<option value="'.$key.'">'.$select_option[$key].'</option>';
	}
	$select .= '</select>';
	return $select;
}
function outerLayouts($id){
	include JPATH_ROOT.'/templates/morph/core/OuterLayout.php';
	$select_option = array(
		'Outer default',
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
	$select = '<select id="'.$id.'" name="components_outer[od_'.str_replace('-', '_', $id).']">';
	foreach($outerPageSuffix as $key => $val){
		$select .= '<option value="'.$key.'">'.$select_option[$key].'</option>';
	}
	$select .= '</select>';
	return $select;
}
?>

<div id="components-tab" class="ui-tabs-panel">
	<div id="components-options" class="options-panel">
		<h3>Customize the sidebar layouts for your installed components</h3>
		<ol class="forms">
			<?php
			$db = JFactory::getDBO();
			$query = $db->setQuery('select c.id, c.name, c.link, c.option' .
							' FROM #__components AS c' .
							' WHERE c.link <> "" AND parent = 0' .
							' ORDER BY c.name');
			$res = $db->loadAssocList($query);
			foreach($res as $r){ 
				$rlab = strtolower(str_replace(' ', '-', $r['name'])); ?>
				<li><label id="components<?php echo $rlab; ?>-lbl" class="to-label" for="<?php echo $rlab; ?>">	
				<?php echo $r['name']; ?></label>
				<?php echo innerLayouts($r['option']);?>
				<?php echo outerLayouts($r['option']);?>
				</li>
			<?php } ?>
		</ol>
	</div>
	<div id="components-info" class="info-panel">
		<h3>Setting component default layouts</h3>
		<p class="teaser">These options allow you to set the default inner and outer layouts for each of your installed components.</p>
		
		<p>The term "inner &amp; outer layouts" refers to the widths and positions (left or right) of the templates two sidebars.</p>
		<p>The outer layout comes second (after the main content) in the templates source order and houses the <strong>splitleft</strong>, 
		<strong>topleft</strong>, <strong>left</strong> &amp; <strong>bottomleft</strong> module positions.</p>
		<p>The inner layout, or right sidebar, houses the <strong>splitright</strong>, 
		<strong>topright</strong>, <strong>right</strong> &amp; <strong>bottomright</strong> module positions.</p>
	</div>
</div>


