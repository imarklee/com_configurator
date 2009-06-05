<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

// Require the base controller
require_once (JPATH_COMPONENT_ADMINISTRATOR.DS.'controller.php');
require_once (JApplicationHelper::getPath('admin_html'));
require_once (JApplicationHelper::getPath('class'));

if (file_exists(JPATH_COMPONENT_ADMINISTRATOR . DS . "language" . DS . $mainframe->get('language') . ".php" ) ) {
    include_once (JPATH_COMPONENT_ADMINISTRATOR . DS . "language" . DS . $mainframe->get('language') . ".php");
} else {
    include_once (JPATH_COMPONENT_ADMINISTRATOR .DS . "language" . DS . "english.php");
}

include_once (JPATH_COMPONENT_ADMINISTRATOR . DS . "configuration.php");

// Create the controller
$classname  = 'ConfiguratorController';
$controller = new $classname( );
// Perform the Request task
$controller->execute( JRequest::getVar('task') );
// Redirect if set by the controller
$controller->redirect();
?>