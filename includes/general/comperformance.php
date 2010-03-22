<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2009 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

function mootools($extension, $index, $app)
{
	extract($extension);
	
	$db = JFactory::getDBO();
	$query = $db->setQuery("select param_value from #__configurator where param_name = 'load_mootools_$option';");
	$value = $db->loadResult($query);
	
//	$xml = & JFactory::getXMLParser('Simple');
//	$xml->loadFile($app->getPath('com_xml', $option));

	$node = new JSimpleXMLElement('param');
//	$node->addAttribute('tooltip', 'inline');
	$node->addChild('option', array('value' => 1))->setData('Yes');
	$node->addChild('option', array('value' => 0))->setData('No');

	echo JElementItoggle::fetchTooltip($name, null /*htmlspecialchars($xml->description)*/, &$node, 'comperformance', 'load_mootools_'.$option);
	echo JElementItoggle::fetchElement('load_mootools_'.$option, $value, &$node, 'comperformance');
}
// do not show these options
$restricted = array('com_configurator', 'com_jce', 'com_masscontent', 'com_ninjaxplorer', 'com_jupdateman');
?>

<div id="comperformance-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="comperformance-options" class="options-panel">
		<h3>Customize the sidebar layouts for your installed components</h3>
		<ol class="forms">
			<?php
			$db = JFactory::getDBO();
			$query = $db->setQuery('select c.id, c.name, c.link, c.option' .
							' FROM #__components AS c' .
							' WHERE c.link <> "" AND parent = 0 AND enabled = 1' .
							' ORDER BY c.name');
			array_walk($db->loadAssocList($query), 'mootools', JFactory::getApplication()); ?>
		</ol>
	</div>
	<div id="comperformance-info" class="info-panel">
		<h3>Setting component default layouts</h3>
		<p class="teaser">These options allow you to set the default inner and outer layouts for each of your installed components.</p>
		
		<p>The term "inner &amp; outer layouts" refers to the widths and positions (left or right) of the templates two sidebars.</p>
		<p>The outer layout comes second (after the main content) in the templates source order and houses the <strong>splitleft</strong>, 
		<strong>topleft</strong>, <strong>left</strong> &amp; <strong>bottomleft</strong> module positions.</p>
		<p>The inner layout, or right sidebar, houses the <strong>splitright</strong>, 
		<strong>topright</strong>, <strong>right</strong> &amp; <strong>bottomright</strong> module positions.</p>
	</div>
</div>