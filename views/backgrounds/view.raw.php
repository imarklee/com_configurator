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
class ComConfiguratorViewBackgrounds extends JView
{
	/**
	 * Display function, renders the view, parsing the template layout
	 *
	 * @param  $tpl	string	The template layout.	optional
	 * @return view output
	 */
	public function display($tpl = null)
	{
		$this->background_dir = JPATH_ROOT.'/morph_assets/backgrounds';
		$this->background_url = JURI::root() . 'morph_assets/backgrounds';
		if(is_dir($this->background_dir)) {
			$this->lists['backgrounds'] = JFolder::files( $this->background_dir );
		} else {
			$this->lists['backgrounds'] = null;
		}
		$db=& JFactory::getDBO();
		$query = "SELECT param_value FROM `#__configurator` WHERE `param_name` = 'bg_image' ";
		$db->setQuery( $query );
		$this->activebg = $db->loadResult();

		return parent::display($tpl);
	}
}