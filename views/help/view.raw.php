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
 * ComConfiguratorViewHelp
 *
 * The help view, displaying the help steps during install mainly
 *
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorViewHelp extends JView
{
	public function __construct($config = array())
	{
		parent::__construct($config);
		
		// This is mainly for the installer ajax help screens
		$this->addTemplatePath(JPATH_ROOT . '/administrator/components/com_configurator/installer/help');
	}
}