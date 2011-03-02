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
 * ComConfiguratorHelperBrowser
 *
 * Helper for getting user agent data, like platform (mac, win) and ctrl/cmd key
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorHelperBrowser
{
	/**
	 * Gets the platform keyword, useful for css classes
	 *
	 * @return string The keyword, e.g. 'mac'
	 */
	public static function getPlatform()
	{
		$agent = $_SERVER['HTTP_USER_AGENT'];
		$os = "unknown";
		
		if (preg_match("/win/i", $agent)) $os = "windows";
	    elseif (preg_match("/mac/i", $agent)) $os = "mac";
	    elseif (preg_match("/linux/i", $agent)) $os = "linux";
	    elseif (preg_match("/OS\/2/i", $agent)) $os = "OS/2";
	    elseif (preg_match("/BeOS/i", $agent)) $os = "beos";
		        
		return $os;
	}
	
	/**
	 * Turns filesizes into human readable text
	 *
	 * @param int $bytes
	 * @param int $precision	rounding precision
	 * @return string
	 */
	public static function getKeyboardKey()
	{
		$os = self::getPlatform();
		if($os == 'mac') $key = '&#x2318;';
		else $key = 'Ctrl';
		return $key;
	}
}