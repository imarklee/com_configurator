<?php
/**
 * Takes care of registering all the needed classes in a lazy load approach to avoid overhead
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */

JLoader::register('JFile', JPATH_LIBRARIES.'/joomla/filesystem/file.php');
//die('<pre>'.var_export(get_class_methods('JFolder'), true).'</pre>');