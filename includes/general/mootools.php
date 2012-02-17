<?php defined('_JEXEC') or die('Restricted access');
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

function mootools($extension, $index, $app)
{
	$restricted = array('com_configurator', 'com_jce', 'com_masscontent', 'com_ninjaxplorer', 'com_extplorer', 'com_jupdateman');
	if(in_array($extension['option'], $restricted)) return;
	extract($extension);
	
	$table = JTable::getInstance('ConfiguratorTemplateSettings', 'Table');
	
	$value = $table->param('load_mootools_'.$option)->getItem()->value;
	
//	$xml = & JFactory::getXMLParser('Simple');
//	$xml->loadFile($app->getPath('com_xml', $option));

	$node = new JSimpleXMLElement('param');
//	$node->addAttribute('tooltip', 'inline');
	$node->addChild('option', array('value' => 1))->setData('Yes');
	$node->addChild('option', array('value' => 0))->setData('No');

	//@TODO start added by Vivek 1st Feb
	if(JVERSION >= '1.6.0')
	echo JElementItoggle::fetchTooltip($title, null /*htmlspecialchars($xml->description)*/, $node, 'mootoolscompat', 'load_mootools_'.$option);
	else
	echo JElementItoggle::fetchTooltip($name, null /*htmlspecialchars($xml->description)*/, $node, 'mootoolscompat', 'load_mootools_'.$option);
	//@TODO end added by Vivek 1st Feb
	echo JElementItoggle::fetchElement('load_mootools_'.$option, $value, $node, 'mootoolscompat');
}
?>

<div id="mootools-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="mootools-options" class="options-panel">
		<h3>Toggle which of your installed components to load Mootools on</h3>
		<ol class="forms">
			<?php
			$options = array();
			$db = JFactory::getDBO();
			//foreach($restricted as $r) $options[] = "'".$r."'";
			//@TODO start added by Vivek
			if(JVERSION >= '1.6.0')
			{	
				//@TODO start added by Vivek 1st Feb
				$query = $db->setQuery('SELECT m.id, m.title, m.alias, m.link, m.parent_id, m.img, e.element AS `option` FROM jos_menu AS m LEFT JOIN jos_extensions AS e ON m.component_id = e.extension_id WHERE m.client_id = 1 AND e.enabled = 1 AND m.id > 1 AND m.parent_id=1 ORDER BY m.lft');
				//@TODO end added by Vivek 1st Feb
				/*$query = $db->setQuery('select c.extension_id AS `id`, c.name, c.element AS `option`,c.element AS `link` ' .
							' FROM #__extensions AS c' .
							" WHERE c.client_id =1 AND c.enabled = 1 AND c.type='component'".
							' ORDER BY c.name');*/
				$res = $db->loadAssocList();
			}else{
				$query = $db->setQuery('select c.id, c.name, c.link, c.option' .
							' FROM #__components AS c' .
							' WHERE c.link <> "" AND parent = 0 AND enabled = 1' .
							' ORDER BY c.name');
				$res = $db->loadAssocList($query);
			}
			//@TODO end added by Vivek
			array_walk($res, 'mootools', JFactory::getApplication()); ?>
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
