<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2009 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined( '_JEXEC' ) or die( 'Restricted access' );
/**
* Configurator parameters handler
* @package Configurator
*/
class configuratorParameters extends JParameter {
    /** @var object */
    var $_params     = null;
    /** @var string The raw params string */
    var $_raw         = null;
    /** @var string Path to the xml setup file */
    var $_path         = null;
    /** @var string The type of setup file */
    var $_type         = null;
    /** @var object The xml params element */
    var $_xmlElem     = null;
    /** @var object Custom node to be injected */
    var $_custom_nodes = null;
    
    var $_current_param = null;
    
    var $_param_op_count = null;
    
    var $_param_options = null;
    
    var $_html = null;
/**
* Constructor
* @param string The raw parms text
* @param string Path to the xml setup file
* @var string The type of setup file
*/
    function configuratorParameters( $text, $path='', $type='template' ) {
        $this->_params     = $this->parse( $text );
        $this->_raw     = $text;
        $this->_path     = $path;
        $this->_type     = $type;
        $this->_param_op_count = 0;
        $this->_param_options = array();
    }

    /**
     * Returns the params array
     * @return object
     */
    function toObject() {
        return $this->_params;
    }

    /**
     * Returns a named array of the parameters
     * @return object
     */
    function toArray() {
        return mosObjectToArray( $this->_params );
    }

/**
* @param string The name of the param
* @param string The value of the parameter
* @return string The set value
*/
    function set( $key, $value='' ) {
        $this->_params->$key = $value;
        return $value;
    }
/**
* Sets a default value if not alreay assigned
* @param string The name of the param
* @param string The value of the parameter
* @return string The set value
*/
    function def( $key, $value='' ) {
        return $this->set( $key, $this->get( $key, $value ) );
    }
/**
* @param string The name of the param
* @param mixed The default value if not found
* @return string
*/
    function get( $key, $default='' ) {
        if (isset( $this->_params->$key )) {
            return $this->_params->$key === '' ? $default : $this->_params->$key;
        } else {
            return $default;
        }
    }
/**
* Parse an .ini string, based on phpDocumentor phpDocumentor_parse_ini_file function
* @param mixed The ini string or array of lines
* @param boolean add an associative index for each section [in brackets]
* @return object
*/
    function parse( $txt, $process_sections = false, $asArray = false ) {
        if (is_string( $txt )) {
            $lines = explode( "\n", $txt );
        } else if (is_array( $txt )) {
            $lines = $txt;
        } else {
            $lines = array();
        }
        $obj = $asArray ? array() : new stdClass();

        $sec_name = '';
        $unparsed = 0;
        if (!$lines) {
            return $obj;
        }
        foreach ($lines as $line) {
            // ignore comments
            if ($line && $line[0] == ';') {
                continue;
            }
            $line = trim( $line );

            if ($line == '') {
                continue;
            }
            if ($line && $line[0] == '[' && $line[strlen($line) - 1] == ']') {
                $sec_name = substr( $line, 1, strlen($line) - 2 );
                if ($process_sections) {
                    if ($asArray) {
                        $obj[$sec_name] = array();
                    } else {
                        $obj->$sec_name = new stdClass();
                    }
                }
            } else {
                if ($pos = strpos( $line, '=' )) {
                    $property = trim( substr( $line, 0, $pos ) );

                    if (substr($property, 0, 1) == '"' && substr($property, -1) == '"') {
                        $property = stripcslashes(substr($property,1,count($property) - 2));
                    }
                    $value = trim( substr( $line, $pos + 1 ) );
                    if ($value == 'false') {
                        $value = false;
                    }
                    if ($value == 'true') {
                        $value = true;
                    }
                    if (substr( $value, 0, 1 ) == '"' && substr( $value, -1 ) == '"') {
                        $value = stripcslashes( substr( $value, 1, count( $value ) - 2 ) );
                    }

                    if ($process_sections) {
                        $value = str_replace( '\n', "\n", $value );
                        if ($sec_name != '') {
                            if ($asArray) {
                                $obj[$sec_name][$property] = $value;
                            } else {
                                $obj->$sec_name->$property = $value;
                            }
                        } else {
                            if ($asArray) {
                                $obj[$property] = $value;
                            } else {
                                $obj->$property = $value;
                            }
                        }
                    } else {
                        $value = str_replace( '\n', "\n", $value );
                        if ($asArray) {
                            $obj[$property] = $value;
                        } else {
                            $obj->$property = $value;
                        }
                    }
                } else {
                    if ($line && trim($line[0]) == ';') {
                        continue;
                    }
                    if ($process_sections) {
                        $property = '__invalid' . $unparsed++ . '__';
                        if ($process_sections) {
                            if ($sec_name != '') {
                                if ($asArray) {
                                    $obj[$sec_name][$property] = trim($line);
                                } else {
                                    $obj->$sec_name->$property = trim($line);
                                }
                            } else {
                                if ($asArray) {
                                    $obj[$property] = trim($line);
                                } else {
                                    $obj->$property = trim($line);
                                }
                            }
                        } else {
                            if ($asArray) {
                                $obj[$property] = trim($line);
                            } else {
                                $obj->$property = trim($line);
                            }
                        }
                    }
                }
            }
        }
        return $obj;
    }
    
    function insertEntities( $new_params_xml=null, $section='params' ) {
        if(!isset($new_params_xml)) return;
        $this->_custom_nodes = $new_params_xml;
    }
    
    // New parse functions.
    function startElementHandler($parser, $name, $attribs) {
        if($this->_in_params && $this->_section == 'param' && $name == 'option') {
            $this->_section = 'option';
            $this->_current_option->value = $attribs['value'];
        }
        if($this->_in_params && $name == 'param') {
            $this->_section = 'param';
            $this->_current_param->name = $attribs['name'];
            $this->_current_param->label = $attribs['label'];
            $this->_current_param->size = $attribs['size'];
            $this->_current_param->type = $attribs['type'];
            $this->_current_param->description = $attribs['description'];
            $this->_current_param->default = $attribs['default'];
        }
        if($name == 'params') $this->_in_params = true;
    }
    
    function endElementHandler($parser, $name) {
        if(!$this->_useTabs && $this->_current_param->type == 'tab' ) return;
        if($this->_in_params && $this->_section == 'option' && $name == 'option') {
            $this->_param_options[] = $this->_current_option;
            $this->_current_option = null;
            $this->_section = 'param';
        }
        if($this->_in_params && $this->_section == 'param' && $name == 'param') {
            $param = & $this->_current_param;
            $param->childNodes = & $this->_param_options;
            $this->_param_count++;
            $result = $this->renderParam( $param, 'params' );
            if( $param->type == 'tab' ) {
                $this->_html[] = $result[1];
            } else {
                $this->_html[] = '<tr>';

                $this->_html[] = '<td align="right" valign="top" class="param-label">' . $result[0] . '<span class="editlinktip">tip</span></td>';
                $this->_html[] = '<td class="param-input">' . $result[1] . '</td>';

                $this->_html[] = '</tr>';
            }
            $this->_section = null;
            $this->_current_param = null;
            $this->_param_options = array();
        }
        if( $name == "params" ) {
            $this->section = null;
            $this->_in_params = false;
        }
    }
                                            
    function characterDataHandler($parser, $cdata) {
        if($this->_in_params && $this->_section == 'option'){
            $this->_current_option->text = $cdata;
        }
    }
    
    
    
    // new Render
    function render( $name='params' ) {
        global $mainframe;
        $old_er = error_reporting(E_ALL & ~ E_NOTICE);
        jimport('joomla.html.pane');
        JHTML::_('behavior.tooltip');
        if ($this->_path) {
            $this->_xmlElem = new morphXMLLoader($this->_path);
            $this->_data = $this->_xmlElem->getParamDefaults();
            
            if (isset($this->_xmlElem->name)) {
                $isParamsFile = $this->_xmlElem->is_morph;
                if ($isParamsFile) {
                    // TODO: Inject custom params.
                    
                    $this->_useTabs = $this->_xmlElem->use_tabs;
                }
            }
            
        }

        
        $goto_javascript = '<script language="JavaScript" type="text/javascript">
<!-- 
function makeCustom(form) {
form.preset.options[0].selected = true;
}
//-->
</script>';
        $mainframe->addCustomHeadTag( $goto_javascript );
        // Load custom JS file (morph.js) and CSS (morph.css) from template folder.
        $template         = $this->_xmlElem->name;
        $d = JPATH_SITE.'/templates/'.$template.'/morph.css';
        if(file_exists(JPATH_SITE.'/templates/'.$template.'/morph.css')) {
            $tag = '<link href="'.JURI::root().'templates/'.$template.'/morph.css" rel="stylesheet" type="text/css" />';
            $mainframe->addCustomHeadTag( $tag );
        }
        if(file_exists(JPATH_SITE.'/templates/'.$template.'/morph.js')) {
            $tag = '<script type="text/javascript" language="javascript" src="'.JURI::root().'templates/'.$template.'/morph.js"></script>';
            $mainframe->addCustomHeadTag( $tag );
        }
        $this->_html = array();
        $this->_html[] = '<table width="100%" id="morphParams" cellpadding="0" cellspacing="0">';

        $element =& $this->_xmlElem;

        if (!empty($element->description)) {
            // add the params description to the display
            $this->_html[] = '<tr><td colspan="2" class="paramTitle">' . $element->description . '</td></tr>';
        }

        //$params = mosParseParams( $row->params );
        $this->_methods = get_class_methods( get_class( $this ) );
        if($this->_useTabs) {
            $this->_html[] = '<tr><td>';
            //ob_start();
            //$this->_tabs = & JPane::getInstance('tabs');
            $this->_tabs = & JPane::getInstance($element->tab_type);
            $this->_html[] = $this->_tabs->startPane('morph');
            //$this->_html[] = ob_get_clean();
            $this->_tabOpen = false;
            
            $this->_param_count = 0;
            $xml_parser = xml_parser_create();
            xml_set_object( $xml_parser, $this );
            xml_parser_set_option($xml_parser,XML_OPTION_CASE_FOLDING,0);
            xml_set_element_handler($xml_parser, 'startElementHandler','endElementHandler');
            xml_set_character_data_handler($xml_parser, 'characterDataHandler');
            if(!($fp = fopen($this->_path,'r'))) return null;
            while( $data = fread($fp, 4096) ) {
                if(!xml_parse($xml_parser, $data, feof($fp))) die("xml error: " . xml_error_string(xml_get_error_code($xml_parser)) . " LINE:" . xml_get_current_line_number($xml_parser));
            }
            
            xml_parser_free($xml_parser);
            
            if(!empty($this->_custom_nodes)) { 
                $xml_parser = xml_parser_create();
                xml_set_object( $xml_parser, $this );
                xml_parser_set_option($xml_parser,XML_OPTION_CASE_FOLDING,0);
                xml_set_element_handler($xml_parser, 'startElementHandler','endElementHandler');
                xml_set_character_data_handler($xml_parser, 'characterDataHandler');
                if(!xml_parse($xml_parser, $this->_custom_nodes, TRUE)) die("custom xml error: " . xml_error_string(xml_get_error_code($xml_parser)) . " LINE:" . xml_get_current_line_number($xml_parser) . " COL:" . xml_get_current_column_number($xml_parser) . "<br />" . implode(',',$this->_html));
                xml_parser_free($xml_parser);
            }
            
            if($this->_tabOpen) {
                $this->_html[] = '</table><!-- END OF TAB LIST -->';
                //ob_start();
                $this->_html[] = $this->_tabs->endPanel();
                $this->_html[] = $this->_tabs->endPane();
                //$this->_html[] = ob_get_clean();
                $this->_tabOpen = false;
            }
            $this->_html[] = '</td></tr>';
            $this->_html[] = '</table>';
        } else {
            $this->_html[] = '<tr><td>';
            
            $this->_param_count = 0;
            $xml_parser = xml_parser_create();
            xml_set_object( $xml_parser, $this );
            xml_parser_set_option($xml_parser,XML_OPTION_CASE_FOLDING,0);
            xml_set_element_handler($xml_parser, 'startElementHandler','endElementHandler');
            xml_set_character_data_handler($xml_parser, 'characterDataHandler');
            if(!($fp = fopen($this->_path,'r'))) return null;
            while( $data = fread($fp, 4096) ) {
                if(!xml_parse($xml_parser, $data, feof($fp))) die("xml error: " . xml_error_string(xml_get_error_code($xml_parser)) . " LINE:" . xml_get_current_line_number($xml_parser));
            }
            
            xml_parser_free($xml_parser);
            
            if(!empty($this->_custom_nodes)) { 
                $xml_parser = xml_parser_create();
                xml_set_object( $xml_parser, $this );
                xml_parser_set_option($xml_parser,XML_OPTION_CASE_FOLDING,0);
                xml_set_element_handler($xml_parser, 'startElementHandler','endElementHandler');
                xml_set_character_data_handler($xml_parser, 'characterDataHandler');
                if(!xml_parse($xml_parser, $this->_custom_nodes, TRUE)) die("custom xml error: " . xml_error_string(xml_get_error_code($xml_parser)) . " LINE:" . xml_get_current_line_number($xml_parser) . " COL:" . xml_get_current_column_number($xml_parser) . "<br />" . implode(',',$this->_html));
                xml_parser_free($xml_parser);
            }
            
            $this->_html[] = '</td></tr>';
            $this->_html[] = '</table>';
        }
        if($this->_cp_count > 0) {
            //array_unshift($html,'<script language="JavaScript">cp1.writeDiv()</script>');
            array_unshift($this->_html,'<div id="colorPickerDiv" style="position:absolute;visibility:hidden;"> </div>');
        }
        if (count( $this->_param_count ) < 1) {
            $this->_html[] = "<tr><td colspan=\"2\"><i>" . _NO_PARAMS . "</i></td></tr>";
        }
        error_reporting( $old_er );
        return implode( "\n", $this->_html );
        
    }

    // END new Render
    
/**
* @param object A param tag node
* @param string The control name
* @return array Any array of the label, the form element and the tooltip
*/
    function renderParam( &$param, $control_name='params' ) {
        $result = array();

        //$name = $param->getAttribute( 'name' );
        $name = $param->name;
        
        //$label = $param->getAttribute( 'label' );
        $label = $param->label;

        //$value = $this->get( $name, $param->getAttribute( 'default' ) );
        $value = $this->get( $name, $param->default);
        //$description = $param->getAttribute( 'description' );
        $description = $param->description;

        $result[0] = $label ? $label : $name;

      
        $name = ($name == '@tab') ? $label : $name;
        //$type = $param->getAttribute( 'type' );
        $type = $param->type;

        if (in_array( '_form_' . $type, $this->_methods )) {
            $result[1] = call_user_func( array( &$this, '_form_' . $type ), $name, $value, $param, $control_name );
        } else {
            $result[1] = _HANDLER . ' = ' . $type;
        }

        if ( $description ) {
            $result[2] = JHTML::_( 'tooltip', $description, $result[0] );
            $result[2] = '';
        } else {
            $result[2] = '';
        }

        return $result;
    }
    /**
    * @param string The name of the form element
    * @param string The value of the element
    * @param object The xml element for the parameter
    * @param string The control name
    * @return string The html for the element
    */
    function _form_text( $name, $value, &$node, $control_name ) {
        //$size = $node->getAttribute( 'size' );
        $size = $node->size;

        return '<input type="text" name="'. $control_name .'['. $name .']" value="'. htmlspecialchars($value) .'" id="'.$name.'" class="text_area" size="'. $size .'" onchange="makeCustom(this.form)" />';
    }
    /**
    * @param string The name of the form element
    * @param string The value of the element
    * @param object The xml element for the parameter
    * @param string The control name
    * @return string The html for the element
    */
    function _form_list( $name, $value, &$node, $control_name ) {
        //$size = $node->getAttribute( 'size' );
        $size = $node->size;

        $options = array();
        foreach ($node->childNodes as $option) {
            //$val = $option->getAttribute( 'value' );
            $val = $option->value;
            //$text = $option->gettext();
            $text = $option->text;
            $options[] = JHTML::_('select.option', $val, $text);
        }

        return JHTML::_('select.genericlist', $options, ''. $control_name .'['. $name .']', 'id="'.$name.'" class="inputbox" onchange="makeCustom(this.form)"', 'value', 'text', $value );
    }
    /**
    * @param string The name of the form element
    * @param string The value of the element
    * @param object The xml element for the parameter
    * @param string The control name
    * @return string The html for the element
    */
    function _form_radio( $name, $value, &$node, $control_name ) {
        $options = array();
        foreach ($node->childNodes as $option) {
            //$val     = $option->getAttribute( 'value' );
            $val     = $option->value;
            //$text     = $option->gettext();
            $text     = $option->text;
            $options[] = JHTML::_('select.option', $val, $text );
        }

        return JHTML::_('select.radiolist', $options, ''. $control_name .'['. $name .']', 'id="'.$name.'" onclick="makeCustom(this.form)"', 'value','text', $value );
    }
    /**
    * @param string The name of the form element
    * @param string The value of the element
    * @param object The xml element for the parameter
    * @param string The control name
    * @return string The html for the element
    */
    function _form_filelist( $name, $value, &$node, $control_name ) {

        // path to images directory
        $path     = JPATH_ROOT . $node->getAttribute( 'directory' );
        $filter = $node->getAttribute( 'filter' );
        jimport('joomla.filesystem.folder');
        $files     = JFolder::files( $path, $filter );

        $options = array();
        foreach ($files as $file) {
            $options[] = JHTML::_('select.option', $file, $file );
        }
        if ( !$node->getAttribute( 'hide_none' ) ) {
            array_unshift( $options, JHTML::_('select.option', '-1', '- '. 'Do Not Use' .' -' ) );
        }
        if ( !$node->getAttribute( 'hide_default' ) ) {
            array_unshift( $options, JHTML::_('select.option', '', '- '. 'Use Default' .' -' ) );
        }

        return JHTML::_('select.genericlist', $options, ''. $control_name .'['. $name .']', 'id="'.$name.'" onchange="makeCustom(this.form)" class="inputbox"', 'value', 'text', $value, "param$name" );
    }
    /**
    * @param string The name of the form element
    * @param string The value of the element
    * @param object The xml element for the parameter
    * @param string The control name
    * @return string The html for the element
    */
    function _form_imagelist( $name, $value, &$node, $control_name ) {
        $node->setAttribute( 'filter', '\.png$|\.gif$|\.jpg$|\.bmp$|\.ico$' );
        return $this->_form_filelist( $name, $value, $node, $control_name );
    }
    /**
    * @param string The name of the form element
    * @param string The value of the element
    * @param object The xml element for the parameter
    * @param string The control name
    * @return string The html for the element
    */
    function _form_textarea( $name, $value, &$node, $control_name ) {
         $rows     = $node->rows;
         $cols     = $node->cols;
         // convert <br /> tags so they are not visible when editing
         $value     = str_replace( '<br />', "\n", $value );

         return '<textarea name="' .$control_name.'['. $name .']" cols="'. $cols .'" rows="'. $rows .'" onchange="makeCustom(this.form)" id="'.$name.'" class="text_area">'. htmlspecialchars($value) .'</textarea>';
    }

    /**
    * @param string The name of the form element
    * @param string The value of the element
    * @param object The xml element for the parameter
    * @param string The control name
    * @return string The html for the element
    */
    function _form_spacer( $name, $value, &$node, $control_name ) {
        if ( $value ) {
            return $value;
        } else {
            return '<hr class="'.$name.'" />';
        }
    }
    
    function _form_tab( $name, $value, &$node, $control_name ) {
        $return = '';
        if($this->_tabOpen) {
            $return .= '</table>';
            //ob_start();
            $return .= $this->_tabs->endPanel();
            //$return .= ob_get_clean();
            $this->_tabOpen = false;
        }
        //ob_start();
        $return .= $this->_tabs->startPanel($name, strtolower(str_replace(' ','_',$name)));
        //$return .= ob_get_clean();
        $return .= '<table>';
        $this->_tabOpen = true;
        return $return;
    }
    
    function _form_colorpicker($name, $value, &$node, $control_name ) {
        $this->_cp_count = (!isset($this->_cp_count))? 1:$this->_cp_count+1;
        $return = '<script language="JavaScript" type="text/javascript">var cp'.$this->_cp_count.' = new ColorPicker(\'window\');</script>';
        $return .= '<input type="text" name="'. $control_name .'['. $name .']" value="'. htmlspecialchars($value) .'" id="'.$name.'" class="text_area" size="'. $size .'" onchange="makeCustom(this.form)" />';
        $return .= '<a href="#" onclick="cp'.$this->_cp_count.'.select(document.getElementById(\''. $name .'\'),\'pick'.$this->_cp_count.'\');return false;" name="pick'.$this->_cp_count.'" id="pick'.$this->_cp_count.'" class="colorpicker" >[Choose]</a>';
        return $return;
    }

    /**
    * special handling for textarea param
    */
    function textareaHandling( &$txt ) {
        $total = count( $txt );
        for( $i=0; $i < $total; $i++ ) {
            if ( strstr( $txt[$i], "\n" ) ) {
                $txt[$i] = str_replace( "\n", '<br />', $txt[$i] );
            }
        }
        $txt = implode( "\n", $txt );

        return $txt;
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
    
    var $preset_list = null;
    
    function morphXMLLoader( $xml_file=null ) {
        $this->_xml_file = $xml_file;
        $this->_data = array();
        $this->is_morph = false;
        $this->use_favicons = false;
        $this->use_tabs = false;
        $this->tab_type = 'Tabs';
        $this->is_counter = false;
        $this->preset_list = array();
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
        if($name == 'presets') {
            $this->_section = 'presets';
            return;
        }
        
        if($name == 'param' && $this->_section == 'params') {
            $this->_data[$attribs['name']] = isset($attribs['default'])?$attribs['default']:'';
        }
        
        if($name == 'preset' && $this->_section == 'presets') {
            $this->preset_list[] = $attribs['name'];
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
    
    function getParamDefaults() {
        if(!isset($this->_xml_file)) return null;
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
        return $this->_data;
    }
    
    function getPresetCount() {
        if(!isset($this->_xml_file)) return null;
        $this->is_counter = true;
        $this->total = 0;
        $this->_section = 'preset';
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
        return $this->total;
    }
}

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

class morphXMLPresets {
    var $_xml_file = null;
    var $_return_val = null;
    var $_in_presets_section = null;
    var $_in_preset = null;
    var $_preset_name = null;
    
    function morphXMLPresets( $xml_file=null ) {
        $this->_xml_file = $xml_file;
        $this->_return_val = array();
        $this->_in_presets_section = false;
        $this->_in_preset = false;
    }
    
    function startElementHandler($parser, $name, $attribs) {
        if( $this->_in_presets_section && $name == 'preset' && $attribs['name'] == $this->_preset_name) {
            $this->_in_preset = true;
        }
        if($this->_in_presets_section && $name == 'param' && $this->_in_preset) $this->_return_val[] = $attribs['name'].'='.$attribs['default'];
        if( $name = 'presets' ) $this->_in_presets_section = true;
    }
    
    function endElementHandler($parser, $name) {
        if( $name == 'presets' ) $this->_in_presets_section = false;
        if( $name == 'preset' && $this->_in_preset ) $this->_in_preset = false;
    }
    
    function characterDataHandler($parser, $cdata) {
    }
    
    function getPresetParamList( $preset_name ) {
        if( !isset( $this->_xml_file ) || ( strlen( $this->_xml_file ) < 1 ) || (!isset($preset_name)) || (strlen($preset_name) < 1) ) return NULL;
        $this->_preset_name = $preset_name;
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
?>
