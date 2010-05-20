<?php
/**
 * Takes care of registering all the needed classes in a lazy load approach to avoid overhead
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */

JLoader::register('JFile', JPATH_LIBRARIES.'/joomla/filesystem/file.php');
JLoader::register('JFolder', JPATH_LIBRARIES.'/joomla/filesystem/folder.php');
JLoader::register('JPath', JPATH_LIBRARIES.'/joomla/filesystem/path.php');
JLoader::register('JArchive', JPATH_LIBRARIES.'/joomla/filesystem/archive.php');
JLoader::register('JController', JPATH_LIBRARIES.'/joomla/application/component/controller.php');
JLoader::register('ConfiguratorController', JPATH_ADMINISTRATOR.'/components/com_configurator/controller.php');
//JLoader::register('HTML_configurator_admin', JApplicationHelper::getPath('admin_html'));
JLoader::register('ComConfiguratorDefines', JPATH_ADMINISTRATOR.'/components/com_configurator/defines.php');
JLoader::register('ComConfiguratorHelperUtilities', JPATH_ADMINISTRATOR.'/components/com_configurator/helpers/utilities.php');
JLoader::register('ComConfiguratorToolbarHtml', JApplicationHelper::getPath('toolbar_html'));