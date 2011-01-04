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
 * ComConfiguratorModelConfigurations
 *
 * Big fat model with most of our business logic
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorModelConfigurations extends KModelTable
{
	/**
	 * Constructor
     *
     * @param 	object 	An optional KConfig object with configuration options
	 */
	public function __construct(KConfig $config)
	{
		parent::__construct($config);

		// Set the static states
		$this->_state
			->insert('template'    , 'cmd', 'morph');
	}
	
	/**
	 * Builds a WHERE clause for the query
	 */
	protected function _buildQueryWhere(KDatabaseQuery $query)
	{
		parent::_buildQueryWhere($query);
		
		$query->where('tbl.template_name', '=', $this->_state->template);
	}

	 /**
     * Override getItem to call getList
     *
     * We don't have singular and plural views for configurations.
     * So we need to forward getItem() calls to getList()
     *
     * @return KDatabaseRowset
     */
    public function getItem()
    {
        return $this->getList();
    }
}