<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined('_JEXEC') or die('Restricted access');
$morph_component_path = dirname(__FILE__).'/../../../components/com_configurator';
if( file_exists( $morph_component_path.'/'."morph.common.php" ) ) include_once ($morph_component_path.'/'."morph.common.php");
if( file_exists( $morph_component_path.'/'."morph.class.php" ) ) include_once ($morph_component_path.'/'."morph.class.php");

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
      
      if( isset($morph_installed) ) {
          $xml_params = ComConfiguratorHelperUtilities::getTemplateParamList( dirname(__FILE__).'/morphDetails.xml', TRUE );
          // Convert to a associative array.
          foreach ($xml_params as $key => $value) {
              $default_params[$key] = $balue;
          }
      } else {
          // Morph not installed.
          $temp_params = new morphXMLParams(dirname(__FILE__).'/morphDetails.xml');
          $xml_params = $temp_params->getTemplateParamList(TRUE);
          foreach ($xml_params as $key => $value) {
              $default_params[$key] = $value;
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

if(function_exists('getTemplateName') && false) $TATAMI = new configuratorLoader( getTemplateName( dirname(__FILE__).'/morphDetails.xml' ) );
else {
    $temp_xml = JFactory::getXMLParser('Simple');
    $temp_xml->loadFile( dirname(__FILE__).'/morphDetails.xml' );
    $temp_doc = &$temp_xml->document;
    $temp_name = &$temp_doc->getElementByPath('name');
    $TATAMI = new morphLoader( $temp_name->data() );
}