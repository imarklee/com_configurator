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
 * ComConfiguratorViewInstall
 *
 * The installer view, used to display the installer steps
 *
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorViewInstall extends JView
{
	public function __construct($config = array())
	{
		$config['template_path'] = JPATH_ROOT . '/administrator/components/com_configurator/installer';

		parent::__construct($config);
	}
}