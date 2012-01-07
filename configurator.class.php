<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined( '_JEXEC' ) or die( 'Restricted access' );
//@TODO start changed by manoj
//important We have moved class "configuratorParameters" from this file to 2 separate files as included below
if(JVERSION >= '1.6.0')
	require_once(JPATH_ADMINISTRATOR.'/components/com_configurator/j17params.php');
else
	require_once(JPATH_ADMINISTRATOR.'/components/com_configurator/j15params.php');
//@TODO end changed by manoj

abstract class abstractXMLParams {
    
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

class morphXMLLoader {
    var $_xml_file = null;
    
    var $_data = null;
    
    var $_section = null;
    
    var $is_morph = null;
    
    var $name = null;
    
    var $description = null;
    
    var $creationdate = null;
    
    var $use_favicons = null;
    
    var $use_tabs = null;
    
    var $tab_type = null;
    
    var $is_counter = null;
    
    function morphXMLLoader( $xml_file=null ) {
        $this->_xml_file = $xml_file;
        $this->_data = array();
        $this->is_morph = false;
        $this->use_favicons = false;
        $this->use_tabs = false;
        $this->tab_type = 'Tabs';
        $this->is_counter = false;
    }
    
    function startElementHandler($parser, $name, $attribs) {
        if($this->is_counter && isset($this->_section)) {
            if($name == $this->_section) $this->total++;
            return;
        }
        if( $name == 'morph' && $attribs['type'] == 'template' ) $this->is_morph = true;
        if( $name == 'name' ) $this->_section = 'name';
        if( strtolower($name) == 'creationdate' ) $this->_section = 'creationdate';
        if( $name == 'favicons' ) $this->_section = 'favicons';
        If( $name == 'tabs' ) {
            $this->_section = 'tabs';
            $this->tab_type = isset($attribs['type'])?$attribs['type']:'Tabs';
        }
        if($name == 'params') {
            $this->_section = 'params';
            return;
        }
        
        if($name == 'param' && $this->_section == 'params') {
            $this->_data[$attribs['name']] = isset($attribs['default'])?$attribs['default']:'';
        }
        
        if($name == 'description') $this->_section = 'description';
    }
    
    function endElementHandler($parser, $name) {
        if( $this->_section == strtolower($name) && !$this->is_counter ) $this->_section = null;
    }
    
    function characterDataHandler($parser, $cdata) {
        if( $this->is_counter ) return;
        if( $this->_section == 'name' ) $this->name = $cdata;
        if( $this->_section == 'creationdate' ) $this->creationdate = $cdata;
        if( $this->_section == 'favicons' && strtolower($cdata) == 'yes' ) $this->use_favicons = true;
        if( $this->_section == 'tabs' && strtolower($cdata) == 'yes' ) $this->use_tabs = true;
        if( $this->_section == 'description' ) $this->description = trim($cdata);
    }
    
    function getParamDefaults()
    {
        if(!isset($this->_xml_file)) return null;
        $xml_parser = xml_parser_create();
        xml_set_object( $xml_parser, $this );
        xml_parser_set_option($xml_parser,XML_OPTION_CASE_FOLDING,0);
        xml_set_element_handler($xml_parser, 'startElementHandler','endElementHandler');
        xml_set_character_data_handler($xml_parser, 'characterDataHandler');
        jimport('joomla.filesystem.file');
        $data = JFile::read($this->_xml_file);
        if(!xml_parse($xml_parser, $data)) die("xml error: " . xml_error_string(xml_get_error_code($xml_parser)));
        xml_parser_free($xml_parser);
        return $this->_data;
    }
}

class morphXMLParams extends abstractXMLParams {}

class morphXMLPresets extends abstractXMLParams {
    
    /**
     * Get the presets, if it's the right preset
     *
     * @param $name
     * @return return type
     */
    public function getData($name)
    {
    	if($this->_xml->params->name == $name) return parent::getData();
    	return array();
    }
}
