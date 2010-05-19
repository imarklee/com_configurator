<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

/**
 * ComConfiguratorDefines
 *
 * Information like the manifest path and such are stored here
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorDefines extends JObject
{
	/**
	 * Path to configurator manifest
	 *
	 * @var dir
	 */
	protected static $_manifest_path;

	/**
	 * Gets the path to the xml manifest
	 *
	 * @return dir
	 */
	public static function getManifestPath()
	{
		if(!isset(self::$_manifest_path)) {
			self::$_manifest_path = JPATH_ADMINISTRATOR . '/components/com_configurator/configurator.xml';
		}

		return self::$_manifest_path;
	}
}