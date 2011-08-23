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
 * ComConfiguratorToolbarHtml
 *
 * Toolbar html class, for rendering the help toolbar, and manage toolbar
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorToolbarHtml extends JToolBar
{
	/**
	 * Toolbar instance
	 *
	 * @var JToolBar
	 */
	protected $_toolbar;

	/**
	 * Constructs the toolbar, and if an value is passed, render the toolbar
	 *
	 * @param  string $toolbar 				The toolbar to render
	 * @return ComConfiguratorToolbarHtml	The toolbar instance
	 */
	public function __construct($toolbar = false)
	{

		$this->_toolbar = parent::getInstance();

		if($toolbar)
		{
			$render = 'render' . $toolbar . 'Toolbar';
			if(method_exists($this, $render)) return $this->$render();
		}

		return parent::__construct($toolbar);
	}
	
	/**
	 * Renders the main toolbar
	 *
	 * Toolbar buttons changes based on the user status
	 *
	 * @return void
	 */
	public function renderManageToolbar()
	{
		JToolBarHelper::title( JText::_( 'Configurator > <span>Manage</span>' ), 'configurator' );

		$this
				->appendButton('apply', 'Save')
				->appendButton('fullscreen', 'Fullscreen')
				->appendButton('preferences', 'Preferences ')
				->appendButton('report-bug-link', 'Feedback')
				->appendButton('credits-link', 'Credits')
				->appendButton('help-link', 'Help');
	}

	/**
	 * Renders the help toolbar
	 *
	 * Renders just a back button atm
	 *
	 * @return void
	 */
	public function renderHelpToolbar()
	{
		JToolBarHelper::title( JText::_( 'Configurator > <span>LiveDocs</span>' ), 'configurator-help' );

		$this->appendButton('configurator', 'Back', JRoute::_('?option=com_configurator&view=configuration'));
	}

	/**
	 * Appends a toolbar button
	 *
	 * @param  $action	string	The button action
	 * @param  $title	string	The button title, will be optional in the future
	 * @param  $link	string	Button link, optional
	 * @return ComConfiguratorToolbarHtml
	 */
	public function appendButton($action, $title, $link = '#')
	{
		$this->getToolbar()->appendButton('Custom', '<a href="'.$link.'" class="toolbar">'.JText::_($title).'</a>', $action);

		return $this;
	}

	/**
	 * Gets the toolbar instance
	 *
	 * @return JToolBar
	 */
	public function getToolbar()
	{
		return $this->_toolbar;
	}
}