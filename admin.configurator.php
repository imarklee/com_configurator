<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2009 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Register depencies
require_once JPATH_COMPONENT_ADMINISTRATOR . '/depencies.php';

// Prepare the tables
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.'/tables');

require_once JApplicationHelper::getPath('admin_html');
require_once JApplicationHelper::getPath('class');

$language = JFactory::getLanguage();
$language = JPATH_COMPONENT_ADMINISTRATOR.'/language/'.$language->getBackwardLang().'.php';

if(file_exists($language))	include_once $language;
else 						include_once JPATH_COMPONENT_ADMINISTRATOR.'/language/english.php';

// Create the controller
$controller = new ConfiguratorController();
// Perform the Request task
$controller->execute( JRequest::getVar('task') );
// Redirect if set by the controller
$controller->redirect();