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
 * ComConfiguratorModelCustomfile
 *
 * Model that handles custom code
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorModelCustomfiles extends KModelTable
{
	/**
	 * Constructor
     *
     * @param 	object 	An optional KConfig object with configuration options
	 */
	public function __construct(KConfig $config)
	{
		parent::__construct($config);

		// Set the limit state to avoid exceptions
		$this->_state
					->insert('file', 'filename', null, true)
					->insert('type', 'cmd')
					->insert('parent', 'cmd');
	}

	protected function _buildQueryWhere(KDatabaseQuery $query)
	{
		parent::_buildQueryWhere($query);
	
		if($this->_state->type)
		{
			$query->where('tbl.type', '=', $this->_state->type);
		}
		
		if($this->_state->parent)
		{
			$query->where('tbl.parent_name', '=', $this->_state->parent);
		}
	}
}