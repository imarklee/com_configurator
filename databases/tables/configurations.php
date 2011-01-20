<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined('_JEXEC') or die('Restricted access');

class ComConfiguratorTableConfigurations extends KDatabaseTableDefault
{
	public function __construct(KConfig $config)
	{
		$config->name = $config->base = 'configurator';

		parent::__construct($config);

		$this->_column_map = array_merge(
			$this->_column_map,
			array(
				'template'	=> 'template_name',
				'name'		=> 'param_name',
				'value'		=> 'param_value',
				'enabled'	=> 'published'
			)
		);
    }
}