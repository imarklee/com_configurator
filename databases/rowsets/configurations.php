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
 * ComConfiguratorDatabaseRowsetConfigurations
 *
 * A modified rowset object with custom setters and getters
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorDatabaseRowsetConfigurations extends KDatabaseRowsetDefault
{
	/**
	 * The configuration params
	 *
	 * @var array
	 */
	protected $_params = array();

	/**
     * Retrieve a param value from a row
     *
     * @param  	string 	The column name.
     * @return 	array 	An array of all the column values
     */
    public function __get($column)
    {
    	return $this->_params[$column];
    }

    /**
     * Set the value of all the columns
     *
     * @param  	string 	The column name.
     * @param  	mixed  	The value for the property.
     * @return 	void
     */
    public function __set($column, $value)
    {
    	foreach($this->_data as $param)
        {
        	if($param->name != $column) continue;
        	$this->_params[$column] = $param->value = $value;
        	break;
        }
   }
   
	/**
     * Test existence of a column
     *
     * @param  string  The column name.
     * @return boolean
     */
    public function __isset($column)
    {
    	return isset($this->_params[$column]);
    }
    
    /**
  	 * Set the rowset data based on a named array/hash
  	 *
  	 * @param   mixed 	Either and associative array, a KDatabaseRow object or object
  	 * @param   boolean If TRUE, update the modified information for each column being set.
  	 * 					Default TRUE
 	 * @return 	KDatabaseRowsetAbstract
  	 */
  	 public function setData( $data, $modified = true )
  	 {
  		//Get the data
  	 	if($data instanceof KDatabaseRowInterface) {
			$data = $data->getData();
		} else {
			$data = (array) $data;
		}

		foreach($data as $column => $value)
		{
			if(isset($this->$column)) $this->$column = $value;
		}
		
		$new = array();
		if(isset($data['template'])) $new['template'] = $data['template'];
		if(isset($data['enabled'])) $new['enabled'] = $data['enabled'];
		if(isset($data['source'])) $new['source'] = $data['source'];
		return parent::setData($new, $modified);
	}

	/**
	 * Add a row in the rowset
	 * 
	 * The row will be stored by it's identity_column if set or otherwise by
	 * it's object handle.
	 *
	 * @param  object 	A KDatabaseRow object to be inserted
	 * @return KDatabaseRowsetAbstract
	 */
	public function addRow(KDatabaseRowInterface $row)
	{
		$this->_params[$row->name] = $row->value;

		return parent::addRow($row);
	}
}