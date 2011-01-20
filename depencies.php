<?php
/**
 * Takes care of registering all the needed classes in a lazy load approach to avoid overhead
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */

defined('_JEXEC') or die('Restricted access');

JLoader::register('JFile', JPATH_LIBRARIES.'/joomla/filesystem/file.php');
JLoader::register('JFolder', JPATH_LIBRARIES.'/joomla/filesystem/folder.php');
JLoader::register('JPath', JPATH_LIBRARIES.'/joomla/filesystem/path.php');
JLoader::register('JArchive', JPATH_LIBRARIES.'/joomla/filesystem/archive.php');
JLoader::register('JController', JPATH_LIBRARIES.'/joomla/application/component/controller.php');
JLoader::register('JView', JPATH_LIBRARIES.'/joomla/application/component/view.php');
// Morph classes
JLoader::register('MBrowser', JPATH_ADMINISTRATOR.'/components/com_configurator/includes/browser.php');