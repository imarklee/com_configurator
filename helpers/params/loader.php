<?php

class ComConfiguratorHelperParamLoader {
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
    
    function __construct( $xml_file=null ) {
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