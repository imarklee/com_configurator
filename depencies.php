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
JLoader::register('JView', JPATH_LIBRARIES.'/joomla/application/component/view.php');
//JLoader::register('HTML_configurator_admin', JApplicationHelper::getPath('admin_html'));
JLoader::register('ComConfiguratorDefines', JPATH_ADMINISTRATOR.'/components/com_configurator/defines.php');
JLoader::register('ComConfiguratorHelperUtilities', JPATH_ADMINISTRATOR.'/components/com_configurator/helpers/utilities.php');
JLoader::register('ComConfiguratorToolbarHtml', JPATH_ADMINISTRATOR.'/components/com_configurator/toolbar.configurator.html.php');

// Controllers
JLoader::register('ComConfiguratorControllerAbstract', JPATH_ADMINISTRATOR.'/components/com_configurator/controllers/abstract.php');
JLoader::register('ComConfiguratorControllerDispatch', JPATH_ADMINISTRATOR.'/components/com_configurator/controllers/dispatch.php');
JLoader::register('ComConfiguratorControllerDefault', JPATH_ADMINISTRATOR.'/components/com_configurator/controllers/default.php');

// Morph classes
JLoader::register('MBrowser', JPATH_ROOT.'/templates/morph/core/browser.php');