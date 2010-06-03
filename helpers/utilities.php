<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

/**
 * ComConfiguratorHelperUtilities
 *
 * Helper class full of utility functions
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorHelperUtilities extends JObject
{
	/**
	 * Cleans up deprecated files
	 *
	 * @return void
	 */
	public static function installCleanup()
	{
		$xml = simplexml_load_file(ComConfiguratorDefines::getManifestPath());

		if(!isset($xml->deleted)) return;

		foreach($xml->deleted->children() as $type => $asset)
		{
			$class  = 'J' . $type;
			$exists = array($class, 'exists');
			$delete = array($class, 'delete');
			$asset  = array(JPATH_ADMINISTRATOR.'/components/com_configurator/'.(string)$asset);
			$result = call_user_func_array($exists, $asset);
			if(call_user_func_array($exists, $asset)) call_user_func_array($delete, $asset);
		}
	}
	
	/**
	 * Turns filesizes into human readable text
	 *
	 * @param int $bytes
	 * @param int $precision	rounding precision
	 * @return string
	 */
	public static function formatBytes($bytes, $precision = 2)
	{
		$units = array('b', 'kb', 'mb', 'gb', 'tb');

		$bytes = max($bytes, 0);
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);

		$bytes /= pow(1024, $pow);

		return round($bytes, $precision) . $units[$pow];
	}
}