<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

/**
 * ComConfiguratorViewHelp
 *
 * The help view, displaying the livedocs
 *
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorViewHelpHtml extends ComDefaultViewHtml
{
	/**
	 * Display function, renders the view, parsing the template layout
	 *
	 * @return view output
	 */
	public function display()
	{
		KFactory::get($this->getToolbar())
			->reset()
			->setTitle('Configurator > <span>LiveDocs</span>')
			->setIcon('configurator-help')
			->append(KFactory::get('admin::com.configurator.toolbar.button.help', array(
				'text' => 'Back',
				'id'   => 'configurator',
				'link' => JRoute::_('?option=com_configurator&view=configuration')
			)));
	
		$document 	= JFactory::getDocument();
		$csspath 	= JURI::root() . 'administrator/components/com_configurator/css/';
	
		$document->addStyleSheet($csspath . 'toplinks.css');
		$document->addStyleSheet($csspath . 'help-docs.css');

		return parent::display();
	}
}