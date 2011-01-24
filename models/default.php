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
 * ComConfiguratorModelDefault
 *
 * Our base abstract model, containing auto code soon to be replaced with Koowa
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorModelDefault extends ComConfiguratorModelAbstract
{
	/**
	 * Constructor
     *
     * @param 	object 	An optional KConfig object with configuration options
	 */
	public function __construct(KConfig $config)
	{
		parent::__construct($config);

		// Set the limit state to avoid exceptions
		$this->_state->insert('limit', 'int', 20);
	}
}