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
class ComConfiguratorViewHelp extends JView
{
	/**
	 * Display function, renders the view, parsing the template layout
	 *
	 * @param  $tpl	string	The template layout.	optional
	 * @return view output
	 */
	public function display($tpl = null)
	{
		$document 	= JFactory::getDocument();
		$option 	= JRequest::getVar('option');
		$csspath 	= JURI::root() . 'administrator/components/com_configurator/css/';
		$jspath 	= JURI::root() . 'administrator/components/com_configurator/js/';
		//$document->addScript($jspath . 'jquery.js');
		//$document->addScript($jspath . 'livedocs.js');
	
		$document->addStyleSheet($csspath . 'toplinks.css');
		$document->addStyleSheet($csspath . 'help-docs.css');

		return parent::display($tpl);
	}
}