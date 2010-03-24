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
	$query = $db->setQuery("SELECT param_value FROM #__configurator WHERE param_name = 'load_mootools_$option';");
	$value = $db->loadResult($query);
	
//	$xml = & JFactory::getXMLParser('Simple');
//	$xml->loadFile($app->getPath('com_xml', $option));

	$node = new JSimpleXMLElement('param');
//	$node->addAttribute('tooltip', 'inline');
	$node->addChild('option', array('value' => 1))->setData('Yes');
	$node->addChild('option', array('value' => 0))->setData('No');

	echo JElementItoggle::fetchTooltip($name, null /*htmlspecialchars($xml->description)*/, &$node, 'mootoolscompat', 'load_mootools_'.$option);
	echo JElementItoggle::fetchElement('load_mootools_'.$option, $value, &$node, 'mootoolscompat');
}
// do not show these options
$restricted = array('com_configurator', 'com_jce', 'com_masscontent', 'com_ninjaxplorer', 'com_jupdateman');
?>

<div id="mootools-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="mootools-options" class="options-panel">
		<h3>Toggle which of your installed components to load Mootools on</h3>
		<ol class="forms">
			<?php
			foreach($restricted as &$option) $option = "'".$option."'";
			$db = JFactory::getDBO();
			$query = $db->setQuery('select c.id, c.name, c.link, c.option' .
							' FROM #__components AS c' .
							' WHERE c.link <> "" AND parent = 0 AND enabled = 1 AND c.option NOT IN ('.implode(', ', $restricted).')' .
							' ORDER BY c.name');
			array_walk($db->loadAssocList($query), 'mootools', JFactory::getApplication()); ?>
		</ol>
	</div>
	<div id="mootools-info" class="info-panel">
		<h3>Selective loading of Mootools</h3>
		<p class="teaser">Some Joomla extensions are built using the Mootools javascript library, which is included with Joomla by default. Due to the size of the library (75kb) 
		and the fact that Morph is built using jQuery, we prevent the Mootools file from loading to make your site as fast loading as possible. This feature lets you enable Mootools 
		for specific components that require it.</p>
		<p>This means that you no longer need to load Mootools globally through out your site and individual cache files will be created to ensure that only what is needed is ever loaded.</p>
	</div>
</div>