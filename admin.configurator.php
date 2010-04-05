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

// Prepare the tables
JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_configurator/tables');

// Require the base controller
require_once (JPATH_COMPONENT_ADMINISTRATOR.'/controller.php');
require_once (JApplicationHelper::getPath('admin_html'));
require_once (JApplicationHelper::getPath('class'));

if (file_exists(JPATH_COMPONENT_ADMINISTRATOR.'/'."language".'/'.$mainframe->get('language') . ".php" ) ) {
    include_once (JPATH_COMPONENT_ADMINISTRATOR.'/'."language".'/'.$mainframe->get('language') . ".php");
} else {
    include_once (JPATH_COMPONENT_ADMINISTRATOR.'/'."language".'/'."english.php");
}

include_once (JPATH_COMPONENT_ADMINISTRATOR.'/'."configuration.php");

// Create the controller
$classname  = 'ConfiguratorController';
$controller = new $classname( );
// Perform the Request task
$controller->execute( JRequest::getVar('task') );
// Redirect if set by the controller
$controller->redirect();
?>