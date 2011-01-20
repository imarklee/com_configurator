<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined('_JEXEC') or die('Restricted access');

class ComConfiguratorDatabaseTableTemplatesettings extends KDatabaseTableDefault
{
	/**
	 * Joomla DBO object
	 *
	 * @TODO temporary legacy
	 *
	 * @var object
	 */
	protected $_db;


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

	/**
	 * Constructor
	 *
	 * @param 	object 	An optional KConfig object with configuration options
	 */
	public function __construct(KConfig $config)
	{
		$config->name				= 'configurator';
		$config->identity_column	= 'id';

		parent::__construct($config);

		//@TODO temporary fix
		$this->_db = JFactory::getDBO();

		return $this;
    	//@TODO this code is from the joomla version, change to nooku equivalent to support menu item settings
    	$app		  = JFactory::getApplication();
		if($app->isAdmin())
		{
			$itemid		  = $app->getUserState('configurator');
			$this->__itemid = $itemid > 0 ? $itemid : false;
		}
		else
		{
			$this->__itemid = JRequest::getInt('Itemid');
		}
		
    	return parent::__construct('#__configurator', 'id', $db);
    }
    
    public function loadByKey()
    {
        if( !isset($this->template_name) || !isset($this->param_name) ) return null;
        $template = $this->__itemid ? $this->__itemid . '.' . $this->template_name : $this->template_name;
        $template = strtolower($template);
        $this->_db->setQuery("SELECT id FROM #__configurator WHERE `template_name` = '{$template}' AND `param_name` = '{$this->param_name}' LIMIT 1");
        $this->load( $this->_db->loadResult() );
    }
    
    public function getItem()
    {
		if(!isset($this->param_name) ) return (object) array();
		$template = $this->__itemid ? $this->__itemid . '.' . $this->template_name : $this->template_name;
		$template = strtolower($template);
		$this->_db->setQuery("SELECT * FROM #__configurator WHERE `template_name` = '{$template}' AND `param_name` = '{$this->param_name}'");
		$this->setProperties($this->_db->loadAssoc());

    	return $this;
    }
    
    public function getMenuItems()
    {
		//$template = $this->__itemid ? $this->__itemid . '.' . $this->template_name : $this->template_name;
		$this->_db->setQuery("SELECT DISTINCT CAST(`template_name` AS SIGNED) AS itemid FROM #__configurator WHERE `template_name` LIKE '%.%'");
		$items = $this->_db->loadResultArray();

    	return $items;
    }
    
    public function resetMenuItems()
    {
		//$template = $this->__itemid ? $this->__itemid . '.' . $this->template_name : $this->template_name;
		$this->_db->setQuery("SELECT DISTINCT CAST(`template_name` AS SIGNED) AS itemid FROM #__configurator WHERE `template_name` LIKE '%.%'");
		$count = count($this->_db->loadResultArray());

		$this->_db->execute("DELETE FROM #__configurator WHERE `template_name` LIKE '%.%'");

    	return $count;
    }
    
    public function getParams()
    {
		if(!isset($this->template_name) ) return array();
		$template = $this->__itemid ? $this->__itemid . '.' . $this->template_name : $this->template_name;
		$template = strtolower($template);
		$query="SELECT * FROM #__configurator AS t WHERE t.template_name='{$template}'";
		$this->_db->setQuery( $query );
		
		if($this->__itemid)
		{
			$override = $this->_db->loadAssocList('param_name');
			$query="SELECT * FROM #__configurator AS t WHERE t.template_name='morph'";
			$this->_db->setQuery( $query );
			return array_merge($this->_db->loadAssocList('param_name'), $override);
		}
		
		return $this->_db->loadAssocList('param_name');
    }
    
    public function getActiveMenuitemParams()
    {
    	if(!$this->__itemid) return array();
    	$template = $this->__itemid . '.' . $this->template_name;
    	$template = strtolower($template);
    	$query="SELECT param_name FROM #__configurator AS t WHERE t.template_name='{$template}'";
    	$this->_db->setQuery( $query );
    	return (array) $this->_db->loadResultArray();
    }
    
    public function getConfigs()
    {
    	if(!isset($this->template_name) ) return array();
    	$template = $this->__itemid ? $this->__itemid . '.' . $this->template_name : $this->template_name;
    	$template = strtolower($template);
    	$query="SELECT * FROM #__configurator AS t WHERE t.template_name='{$template}'";
    	$this->_db->setQuery( $query );
    	$override = (array) $this->_db->loadObjectList('param_name');
    	$query="SELECT * FROM #__configurator AS t WHERE t.template_name='morph'";
    	$this->_db->setQuery( $query );
    	//$fallback = $this->_db->loadObjectList('param_name');
    	//return $override ? $override : $this->_db->loadObjectList('param_name');
    	return array_merge($this->_db->loadObjectList('param_name'), $override);
    }
    
    public function store()
    {
    	$template = end(explode('.', $this->template_name));
    	$this->template = $this->__itemid ? $this->__itemid . '.' . $template : $template;
    	
    	// Avoid duplicates
    	$this->_db->setQuery("SELECT COUNT(*) FROM #__configurator WHERE `template_name` = '{$this->template}' AND `param_name` = '{$this->param_name}'");
    	$count = (int)$this->_db->loadResult();
    	if($count > 1)
    	{
    		$this->_db->execute("DELETE FROM #__configurator WHERE `template_name` = '{$this->template}' AND `param_name` = '{$this->param_name}' AND `id` != '{$this->id}'");
    	}
    	
    	if($this->__itemid)
    	{
    		$active_items = JRequest::getVar( 'menuitem_active', null, 'post', 'array' );
			if(!array_key_exists($this->param_name, $active_items)) return parent::delete();
		}

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