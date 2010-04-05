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
    
    /**
     * The menu item id, if one
     *
     * @var int|boolean
     */
    protected $__itemid;
    
    public function __construct($db)
    {
    	$app		  = JFactory::getApplication();
    	$itemid		  = $app->getUserState('configurator');
		$this->__itemid = $itemid > 0 ? $itemid : false;

    	return parent::__construct('#__configurator', 'id', $db);
    }
    
    public function loadByKey()
    {
        if( !isset($this->template_name) || !isset($this->param_name) ) return null;
        $template = $this->__itemid ? $this->__itemid . '.' . $this->template_name : $this->template_name;
        $this->_db->setQuery("SELECT id FROM #__configurator WHERE `template_name` = '{$template}' AND `param_name` = '{$this->param_name}' LIMIT 1");
        $this->load( $this->_db->loadResult() );
    }
    
    public function getItem()
    {
		if(!isset($this->param_name) ) return (object) array();
		$template = $this->__itemid ? $this->__itemid . '.' . $this->template_name : $this->template_name;
		$this->_db->setQuery("SELECT * FROM #__configurator WHERE `template_name` = '{$template}' AND `param_name` = '{$this->param_name}'");
		$this->setProperties($this->_db->loadAssoc());

    	return $this;
    }
    
    public function getParams()
    {
		if(!isset($this->template_name) ) return array();
		$template = $this->__itemid ? $this->__itemid . '.' . $this->template_name : $this->template_name;
		$query="SELECT * FROM #__configurator AS t WHERE t.template_name='{$template}'";
		$this->_db->setQuery( $query );
		return $this->_db->loadAssocList('param_name');
    }
    
    public function store()
    {
    	$template = end(explode('.', $this->template_name));
    	$this->template = $this->__itemid ? $this->__itemid . '.' . $template : $template;
    	return parent::store();
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