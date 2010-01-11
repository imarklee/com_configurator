<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2009 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

function innerLayouts($id){
	include JPATH_ROOT.''.'/'.'templates'.'/'.'morph'.'/'.'core'.'/'.'InnerLayout.php';
	$select_option = array('default' => 'Inner Default',
		'None',
		'50% Right',
		'33% Right',
		'25% Right',
		'200px Left',
		'200px Right'
	);
	
	$db = JFactory::getDBO();
	$query = $db->setQuery("select param_value from #__configurator where param_name = 'id_".$id."';");
	$res = $db->loadResult($query);
	
	$select = '<select id="id_'.$id.'" name="components_inner[id_'.str_replace('-', '_', $id).']">';
		if($res !== NULL && $res == 'default' || $res == NULL){ $select .= '<option value="default" selected="selected">Inner Default</option>'; } 
		else { $select .= '<option value="default">Inner Default</option>'; }
		
		foreach($innerPageSuffix as $key => $val){
			if($res !== NULL && $res !== 'default' && $res == $key){ $selected = ' selected="selected"'; }else{ $selected = ''; }
			$select .= '<option value="'.$key.'"'. $selected .'>'.$select_option[$key].'</option>';
		}
	$select .= '</select>';
	return $select;
}
function outerLayouts($id){
	include JPATH_ROOT.''.'/'.'templates'.'/'.'morph'.'/'.'core'.'/'.'OuterLayout.php';
	$select_option = array(
		'None',
		'160px Left',
		'180px Left',
		'300px Left',
		'180px Right',
		'240px Right',
		'300px Right',
		'200px Left',
		'200px Right'
	);
	
	$db = JFactory::getDBO();
	$query = $db->setQuery("select param_value from #__configurator where param_name = 'od_".$id."';");
	$res = $db->loadResult($query);
	
	$select = '<select id="od_'.$id.'" name="components_outer[od_'.str_replace('-', '_', $id).']">';
		if($res !== NULL && $res == 'default' || $res == NULL){ $select .= '<option value="default" selected="selected">Outer Default</option>'; }
		else { $select .= '<option value="default">Outer Default</option>'; }
		
		foreach($outerPageSuffix as $key => $val){
			if($res !== NULL && $res !== 'default' && $res == $key){ $selected = ' selected="selected"'; }else{ $selected = ''; }
			$select .= '<option value="'.$key.'"'. $selected .'>'.$select_option[$key].'</option>';
		}
	$select .= '</select>';
	return $select;
}
// do not show these options
$restricted = array('com_configurator', 'com_jce', 'com_masscontent', 'com_ninjaxplorer', 'com_jupdateman');
?>

<div id="components-tab" class="ui-tabs-hide ui-tabs-panel">
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
				if(!in_array($r['option'], $restricted)){
					$rlab = strtolower(str_replace(' ', '-', $r['name'])); ?>
					<li><label id="components<?php echo $rlab; ?>-lbl" class="to-label" for="<?php echo $rlab; ?>">	
					<?php echo $r['name']; ?></label>
					<?php echo innerLayouts($r['option']);?>
					<?php echo outerLayouts($r['option']);?>
					</li>
			<?php }
			} ?>
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