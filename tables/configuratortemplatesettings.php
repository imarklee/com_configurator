<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2009 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

class TableConfiguratorTemplateSettings extends JTable
{  
    public $id;
    public $template_name = 'morph';
    public $param_name;
    public $param_value;
    public $source;
    public $published;
    
    /**
     * Array over column map
     *
     * @var array
     */
    protected $__column_map = array(
    	'param'		=> 'param_name',
    	'value' 	=> 'param_value',
    	'template'	=> 'template_name'
    );
    
    public function __construct($db)
    {
    	return parent::__construct('#__configurator', 'id', $db);
    }
    
    public function loadByKey()
    {
        if( !isset($this->template_name) || !isset($this->param_name) ) return null;
        $this->_db->setQuery("SELECT id FROM #__configurator WHERE `template_name` = '{$this->template_name}' AND `param_name` = '{$this->param_name}' LIMIT 1");
        $this->load( $this->_db->loadResult() );
    }
    
    public function getItem()
    {
		if(!isset($this->param_name) ) return (object) array();
		$this->_db->setQuery("SELECT * FROM #__configurator WHERE `template_name` = '{$this->template_name}' AND `param_name` = '{$this->param_name}'");
		$this->setProperties($this->_db->loadAssoc());

    	return $this;
    }
    
    public function __call($key, $args)
    {
    	$this->$key = $args[0];
    	
    	return $this;
    }
    
    public function __get($key)
    {
    	return $this->{$this->__column_map[$key]};
    }
    
    public function __set($key, $val)
    {
		$this->{$this->__column_map[$key]} = $val;

		return $this;
    }
        
}