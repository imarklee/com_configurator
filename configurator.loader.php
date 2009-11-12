<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2009 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined('_JEXEC') or die('Restricted access');
$morph_component_path = dirname(__FILE__) . DS . '..'.DS.'..'.DS.'..'.DS.'components'.DS.'com_configurator';
if( file_exists( $morph_component_path . DS . "morph.common.php" ) ) include_once ($morph_component_path . DS . "morph.common.php");
if( file_exists( $morph_component_path . DS . "morph.class.php" ) ) include_once ($morph_component_path . DS . "morph.class.php");

class configuratorLoader {
  
  function configuratorLoader( $template=null ) {
      $database = &JFactory::getDBO();
      
      if( !isset( $template ) ) return;
      // Check if the Configurator DB table exists
      $database->setQuery( "SHOW TABLES LIKE '%configurator'" );
      $morph_installed = $database->loadResult();
      $default_params = array();
      if ( isset( $morph_installed ) ) {
          // Load any saved settings.
          $query = "SELECT * FROM #__configurator WHERE `template_name` = '{$template}'";
          $database->setQuery( $query );
          $params = $database->loadObjectList();
      } else {
          // Morph not installed or DB missing.
          $params = array();
      }
      
      // Get the parameters and their default values from the XML file.
      
      //$xml_params = getTemplateParamList( dirname(__FILE__).DS.'morphDetails.xml', TRUE );
      if( isset($morph_installed) ) {
          $xml_params = getTemplateParamList( dirname(__FILE__).DS.'morphDetails.xml', TRUE );
          // Convert to a associative array.
          foreach ($xml_params as $param) {
              $param = explode( '=', $param );
              $default_params[$param[0]] = $param[1];
          }
      } else {
          // Morph not installed.
          $temp_params = new morphXMLParams(dirname(__FILE__).DS.'morphDetails.xml');
          $xml_params = $temp_params->getTemplateParamList(TRUE);
          foreach ($xml_params as $param) {
              $param = explode( '=', $param );
              $default_params[$param[0]] = $param[1];
          }
      }
      
      // Replace default settings with any settings found in the DB.
      foreach( (array) $params as $param ) {
          $default_params[$param->param_name] = $param->param_value;
      }
      // Create class members dynamically to be used by template.
      foreach( $default_params as $key => $value ) {
          $this->$key = $value;
      }
  }
  
  function get($param_name=null) {
      if(!isset($param_name)) return null;
      return $this->$param_name;
  }
  
}

if(function_exists('getTemplateName') && false) $TATAMI = new configuratorLoader( getTemplateName( dirname(__FILE__).DS.'morphDetails.xml' ) );
else {
    $temp_xml = JFactory::getXMLParser('Simple');
    $temp_xml->loadFile( dirname(__FILE__).DS.'morphDetails.xml' );
    $temp_doc = &$temp_xml->document;
    $temp_name = &$temp_doc->getElementByPath('name');
    $TATAMI = new morphLoader( $temp_name->data() );
}

if(!class_exists('morphXMLParams')) {
    class morphXMLParams {
        
        var $_xml_file = null;
        var $_return_val = null;
        var $_in_params_section = null;
        var $_include_values = null;
        
        function morphXMLParams( $xml_file=null ) {
            $this->_xml_file = $xml_file;
            $this->_return_val = array();
            $this->_in_params_section = false;
        }
        
        function startElementHandler($parser, $name, $attribs) {
            if($this->_in_params_section && $name == 'param') $this->_return_val[] = ( $this->_include_values ) ? $attribs['name'].'=' . ( isset($attribs['default'])?$attribs['default']:'' ) : $attribs['name'];
            if( $name == 'params' ) $this->_in_params_section = true;
        }
        
        function endElementHandler($parser, $name) {
            if( $name == 'params' ) $this->_in_params_section = false;
        }
        
        function characterDataHandler($parser, $cdata) {
        }
        
        function getTemplateParamList( $include_values=FALSE ) {
            if( !isset( $this->_xml_file ) || ( strlen( $this->_xml_file ) < 1 ) ) return NULL;
            $this->_include_values = $include_values;
            $xml_parser = xml_parser_create();
            xml_set_object( $xml_parser, $this );
            xml_parser_set_option($xml_parser,XML_OPTION_CASE_FOLDING,0);
            xml_set_element_handler($xml_parser, 'startElementHandler','endElementHandler');
            xml_set_character_data_handler($xml_parser, 'characterDataHandler');
            if(!($fp = fopen($this->_xml_file,'r'))) return null;
            while( $data = fread($fp, 4096) ) {
                if(!xml_parse($xml_parser, $data, feof($fp))) die("xml error: " . xml_error_string(xml_get_error_code($xml_parser)));
            }
            xml_parser_free($xml_parser);
            
            return $this->_return_val;
        }
        
        
    }
}
  
?>