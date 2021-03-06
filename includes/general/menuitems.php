<?php defined('_JEXEC') or die('Restricted access');
function menu_items_list()
{
	$name = 'menuitem';
	$value = null;
	$node = new JSimpleXMLElement('params');
	$control_name = 'params';
	$db =& JFactory::getDBO();

	//$menuType = $this->_parent->get('menu_type');
	$menuType = false;
	if (!empty($menuType)) {
		$where = ' WHERE menutype = '.$db->Quote($menuType);
	} else {
		$where = ' WHERE 1';
	}

	// load the list of menu types
	// TODO: move query to model
	$query = 'SELECT menutype, title' .
			' FROM #__menu_types' .
			' ORDER BY title';
	$db->setQuery( $query );
	$menuTypes = $db->loadObjectList();

	if ($state = $node->attributes('state')) {
		$where .= ' AND published = '.(int) $state;
	}

	// load the list of menu items
	// TODO: move query to model
	$query = 'SELECT id, parent, name, menutype, type' .
			' FROM #__menu' .
			$where .
			' ORDER BY menutype, parent, ordering'
			;

	$db->setQuery($query);
	$menuItems = $db->loadObjectList();

	// establish the hierarchy of the menu
	// TODO: use node model
	$children = array();

	if ($menuItems)
	{
		// first pass - collect children
		foreach ($menuItems as $v)
		{
			$pt 	= $v->parent;
			$list 	= @$children[$pt] ? $children[$pt] : array();
			array_push( $list, $v );
			$children[$pt] = $list;
		}
	}

	// second pass - get an indent list of the items
	$list = JHTML::_('menu.treerecurse', 0, '', array(), $children, 9999, 0, 0 );

	// assemble into menutype groups
	$n = count( $list );
	$groupedList = array();
	foreach ($list as $k => $v) {
		$groupedList[$v->menutype][] = &$list[$k];
	}

	// assemble menu items to the array
	$options 	= array();
	$options[]	= JHTML::_('select.option', '0', '- '.JText::_('Select Item').' -');

	foreach ($menuTypes as $type)
	{
		if ($menuType == '')
		{
			$options[]	= JHTML::_('select.option',  '-', '&nbsp;', 'value', 'text', true);
			$options[]	= JHTML::_('select.option',  $type->menutype, $type->title . ' - ' . JText::_( 'Top' ), 'value', 'text', true );
		}
		if (isset( $groupedList[$type->menutype] ))
		{
			$n = count( $groupedList[$type->menutype] );
			for ($i = 0; $i < $n; $i++)
			{
				$item = &$groupedList[$type->menutype][$i];
				
				//If menutype is changed but item is not saved yet, use the new type in the list
				if ( JRequest::getString('option', '', 'get') == 'com_menus' ) {
					$currentItemArray = JRequest::getVar('cid', array(0), '', 'array');
					$currentItemId = (int) $currentItemArray[0];
					$currentItemType = JRequest::getString('type', $item->type, 'get');
					if ( $currentItemId == $item->id && $currentItemType != $item->type) {
						$item->type = $currentItemType;
					}
				}
				
				$disable = strpos($node->attributes('disable'), $item->type) !== false ? true : false;
				$options[] = JHTML::_('select.option',  $item->id, '&nbsp;&nbsp;&nbsp;' .$item->treename, 'value', 'text', $disable );

			}
		}
	}

	$value = JFactory::getApplication()->getUserState('configurator');
	
	$table = JTable::getInstance('ConfiguratorTemplateSettings', 'Table');
	
	$menuitems = $table->getMenuItems();
	$search    = array();
	$replace   = array();
	foreach ($menuitems as $menuitem)
	{
		$search[]  = 'value="' . $menuitem . '"';
		$replace[] = 'value="' . $menuitem . '" class="have-configs"';
	}
	
	$subject = JHTML::_('select.genericlist',  $options, $name, 'class="inputbox"', 'value', 'text', $value, $control_name.$name);
	
	return str_replace($search, $replace, $subject);
}
?>

<div id="menuitems-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="menuitems-options" class="options-panel">
		<h3>Menu level customization</h3>
		<div class="inner">
		<p>Select a menu item to edit, then click the "<strong>Customize</strong>" button. This will reload the page and let you customize specific options for your selected menu item. Options need to be "unlocked" in order to override the default (simply click the lock icon to the right of the option and then make your change).</p>
		<?php echo menu_items_list() ?>
		<a href="#" class="save-and-reload btn-link">Customize</a>
		<a href="#" class="reset-menuitems btn-link">Reset</a>
		</div>
	</div>
	
	<div id="menuitems-info" class="info-panel">
		<h3>Set options per menu item.</h3>
		<p class="teaser">This feature lets you set alternate configurations on a per menu item level. Whether its displaying a different background color for each sections of your site, or switching your module chromes on different pages, this feature really takes Morph to a whole new level.</p>
		<p></p>
	</div>
</div>