<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

/**
 * ComConfiguratorViewBackgrounds
 *
 * Shows a list over background assets
 *
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorViewBackgroundsHtml extends ComDefaultViewHtml
{
	/**
	 * Display function, renders the view, parsing the template layout
	 *
	 * @return view output
	 */
	public function display($tpl = null)
	{
		$background_dir = JPATH_ROOT.'/morph_assets/backgrounds';
		$this->assign('background_dir', $background_dir);
		$this->assign('background_url', JURI::root() . 'morph_assets/backgrounds');
		if(JFolder::exits($background_dir)) {
			$this->assign('lists', array('backgrounds' => JFolder::files( $background_dir )));
		} else {
			$this->assign('lists', array('backgrounds' => null));
		}
		$db=& JFactory::getDBO();
		$query = "SELECT param_value FROM `#__configurator` WHERE `param_name` = 'bg_image' ";
		$db->setQuery( $query );
		$this->assign('activebg', $db->loadResult());

		return parent::display();
	}
}