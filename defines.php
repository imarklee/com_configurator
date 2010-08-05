<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined('_JEXEC') or die('Restricted access');

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
	 * Configurator version
	 *
	 * @var version string
	 */
	protected static $_version;

	/**
	 * Path to configurator manifest
	 *
	 * @var dir
	 */
	protected static $_manifest_path;

	/**
	 * Gets the Configurator version
	 *
	 * @return dir
	 */
	public static function getVersion()
	{
		if(!isset(self::$_version)) {
			self::$_version = (string) simplexml_load_file(self::getManifestPath())->version;
		}

		return self::$_version;
	}

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