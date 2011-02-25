<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

/**
 * ComConfiguratorViewInstall
 *
 * Installer steps ajax, used only during install
 *
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorViewHelpRaw extends ComDefaultViewHtml
{
	/**
	 * Return the views output
	 * @TODO this is a very temporary fix
	 *
	 * @return string 	The output of the view
	 */
	public function display()
	{
		$layout = JPATH_ROOT . '/administrator/components/com_configurator/installer/help/'.$this->getLayout().'.php';
	
		if(!file_exists($layout)) return parent::display();
	
		//Load the template object
		$this->output = $this->getTemplate()
				->loadPath($layout, $this->_data)
				->render(true);
						
		return parent::display();
	}
}