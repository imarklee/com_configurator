<?php
function innerLayouts(){
	return '<select>
		<option value="">Select Inner Layout</option>
	</select>';
}
function outerLayouts(){
	return '<select>
		<option value="">Select Outer Layout</option>
	</select>';
}
?>

<div id="components-tab" class="ui-tabs-panel">
	<div id="components-options" class="options-panel">
		<h3>Component Defaults</h3>
		<ol class="forms">
			<?php
			$db = JFactory::getDBO();
			$query = $db->setQuery("select * from #__components where admin_menu_link !='' ;");
			$res = $db->loadAssocList($query);
			foreach($res as $r){ 
				$rlab = strtolower(str_replace(' ', '-', $r['name'])); ?>
				<li><label id="components<?php echo $rlab; ?>-lbl" class="to-label" for="<?php echo $rlab; ?>">	
				<?php echo $r['name']; ?></label>
				<?php echo innerLayouts();?>
				<?php echo outerLayouts();?>
				</li>
			<?php } ?>
		</ol>
	</div>
	<div id="components-info" class="info-panel">
	<p>Feed me content ;)</p>
	</div>
</div>


