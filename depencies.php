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
die('<pre>'.var_export(get_class_methods('JArchive'), true).'</pre>');