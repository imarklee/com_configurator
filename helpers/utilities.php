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

		//die('<pre>'.print_r($xml, true).'</pre>');
	}
}