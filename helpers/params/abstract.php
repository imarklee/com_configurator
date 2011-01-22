<?php

abstract class ComConfiguratorHelperParamAbstract {
    
    /**
     * Path to xml file
     *
     * @var string
     */
    protected $_path = null;
    
    /**
     * The complete xml document
     *
     * @var SimpleXMLElement
     */
    protected $_xml;
    
    /**
     * An key/value array over the configuration values
     *
     * @var Array
     */
    protected $_data = array();
    
    /**
     * Initialise morphXMLParams, and if a path is passed with it, prepare the data list
     *
     * @param $path
     */
	public function __construct($path = false)
	{
		$this->_path = $path;
		
		if($this->_path && file_exists($this->_path))
		{
			$this->loadFile();
		}
	}
	
	/**
	 * Load the xml file, and create the list
	 *
	 * @param $path
	 * @return Array
	 */
	public function loadFile()
	{
        $path = $this->_path;
        $this->_xml  = file_exists($path) ? simplexml_load_file($path) : new SimpleXMLElement;
        
        // If the xml don't have the <params> tag, escape
        if(!$this->_xml->params) return;
        
        foreach($this->_xml->params as $params)
        {
	        foreach($params->children() as $param)
	        {
	        	if(isset($param['name'])) $this->_data[(string)$param['name']] = (string)$param['default'];
	        }
        }
        
        return $this->getData();
    }
    
    /**
     * Sets the data
     *
     * @param $data
     * @return $this
     */
    public function setData($data)
    {
    	$this->_data = (array)$data;
    	return $this;
    }
    
    /**
     * Gets the data
     *
     * @return array
     */
    public function getData()
    {
    	return $this->_data;
    }
    
    /**
     * Set the SimpleXMLElement
     *
     * @param $xml
     * @return $this
     */
    public function setXml(SimpleXMLElement $xml)
    {
    	$this->_xml = $xml;
    	return $this;
    }
    
    /**
     * Gets the SimpleXMLElement object
     *
     * @return SimpleXMLElement
     */
    public function getXml()
    {
    	return $this->_xml;
    }
    
    /**
     * Sets the path
     *
     * @param $path
     * @return $this
     */
    public function setPath($path)
    {
    	if($path && file_exists($path)) $this->_path = $path;
    	return $this;
    }
    
    /**
     * Gets the path to the xml, returns false if the file does not exist
     *
     * @return string|false
     */
    public function getPath()
    {
    	if($this->_path && file_exists($this->_path)) return $this->_path;
    	return false;
    }   
}