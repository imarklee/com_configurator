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

		if(!isset($xml->deprecated)) return;

		foreach($xml->deprecated->children() as $type => $asset)
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
	
	/**
	 * Gets a list over template parameters
	 *
	 * @author Stian Didriksen <stian@prothemer.com>
	 * @param $file	  path to morph or themelet xml file
	 * @return array  xml data
	 */
	public static function getTemplateParamList( $file = false )
	{
		if( !$file ) return array();
		$xml = new morphXMLParams( $file );
		return $xml->getData();
	}
	
	/**
	 * Resets installer state
	 *
	 * @author Stian Didriksen <stian@prothemer.com>
	 */
	public static function resetInstallState()
	{
		$app = JFactory::getApplication();
		
		$app->setUserState('configurator.install', false);
	}
	
	/**
	 * Sets installer state
	 *
	 * @author Stian Didriksen <stian@prothemer.com>
	 * @param  $key		the key
	 * @param  $val		the state value
	 */
	public static function setInstallState($key, $val)
	{
		$app = JFactory::getApplication();
		
		$state = $app->getUserState('configurator.install');
		$state[$key] = $val;
		$app->setUserState('configurator.install', $state);
	}
	
	/**
	 * Gets installer state
	 *
	 * @author Stian Didriksen <stian@prothemer.com>
	 * @param  $key		the key
	 */
	public static function getInstallState($key)
	{
		$app = JFactory::getApplication();
		
		$state = $app->getUserState('configurator.install');
		return isset($state[$key]) ? $state[$key] : false;
	}
}