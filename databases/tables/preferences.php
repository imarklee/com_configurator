<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined('_JEXEC') or die('Restricted access');

class ComConfiguratorDatabaseTablePreferences extends KDatabaseTableDefault
{
	public function __construct(KConfig $config)
	{
		parent::__construct($config);

		
		//Column maps causing syntax errors on the following test:
		//$table	= KFactory::get('admin::com.configurator.database.table.preferences');
		//$table->select(array('pref_name' => 'show_intros'))->setData(array('pref_value' => 0))->save();
		//@TODO this might be a bug in nooku framework
		/*$this->_column_map = array_merge(
			$this->_column_map,
			array(
				'name'		=> 'pref_name',
				'value'		=> 'pref_value'
			)
		);*/
    }
}