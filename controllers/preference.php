<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

/**
 * ComConfiguratorControllerPreference
 *
 * Deals with configurator preferences
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorControllerPreference extends ComConfiguratorControllerDefault
{
	protected function _actionSaveprefs(KCommandContext $context)
	{
		$table	= KFactory::get('admin::com.configurator.database.table.preferences');
		$data	= $context->data->cfg;

		foreach($data as $key => $value)
		{
			$table->select(array('pref_name' => $key))->setData(array('pref_value' => $value))->save();
		}

		$this->_redirect = KRequest::url();
	}
}