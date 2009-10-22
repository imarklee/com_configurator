<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2009 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined('_JEXEC') or die('Restricted access');

function getTemplateParamList( $xmlfile, $include_values=FALSE ) {
    
    if( !isset( $xmlfile ) || ( strlen( $xmlfile ) < 1 ) ) return NULL;
    $xml_data = new morphXMLParams( $xmlfile );
    return $xml_data->getTemplateParamList($include_values);
}

function getPresetParamList( $xmlfile, $preset_name ) {
    $xml_presets = new morphXMLPresets( $xmlfile );
    return $xml_presets->getPresetParamList( $preset_name );
}

function getTemplateName( $xml_file=NULL ) {
    
    $in_name = false;
    $return_val = null;
    $temp_el = new morphXMLLoader($xml_file);
    $temp_data = $temp_el->getParamDefaults();
    return $temp_el->name;
    
    function startElementHandler($parser, $name, $attribs) {
        global $in_name;
        if( $name == 'name' ) $in_name = true;
    }
    
    function endElementHandler($parser, $name) {
        global $in_name;
        if( $name == 'name' ) $in_name = false;
    }
    
    function characterDataHandler($parser, $cdata) {
        global $in_name;
        if($in_name) $return_val = trim($cdata);
    }
    
    $xml_parser = xml_parser_create();
    
    xml_parser_set_option($xml_parser,XML_OPTION_CASE_FOLDING,0);
    xml_set_element_handler($xml_parser, 'startElementHandler','endElementHandler');
    xml_set_character_data_handler($xml_parser, 'characterDataHandler');
    if(!($fp = fopen($xml_file,'r'))) return null;
    while( $data = fread($fp, 4096) ) {
        if(!xml_parse($xml_parser, $data, feof($fp))) die("xml error: " . xml_error_string(xml_get_error_code($xml_parser)));
    }
    xml_parser_free($xml_parser);
    return $return_val;
}

?>
