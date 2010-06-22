<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Register depencies
require_once JPATH_COMPONENT_ADMINISTRATOR . '/depencies.php';

// Prepare the tables
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.'/tables');

require_once JApplicationHelper::getPath('class');

//@TODO upgrade to the native INI format asap!
include_once JPATH_COMPONENT_ADMINISTRATOR.'/language/english.php';

//If missing a view var, redirect to one.
//Koowa does this automatically, so we can remove this code later
if(!JRequest::getCmd('view') && !JRequest::getCmd('task') && !ComConfiguratorControllerAbstract::isAjax())
{
	$app = JFactory::getApplication();
	$uri = clone JFactory::getURI();
	$uri->setVar('view', 'configuration');
	$app->redirect($uri->toString());
	
}

// Dispatch Configurator
new ComConfiguratorControllerDispatch(JRequest::getCmd('task', 'default'));