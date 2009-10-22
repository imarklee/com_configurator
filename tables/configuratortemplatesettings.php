<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2009 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined( '_JEXEC' ) or die( 'Restricted access' );
class TableConfiguratorTemplateSettings extends JTable {
    
    var $id = null;
    var $template_name = null;
    var $param_name = null;
    var $param_value = null;
    var $source = null;
    var $published = null;
    
    function TableConfiguratorTemplateSettings(&$db) { parent::__construct('#__configurator', 'id', $db); }
    
    function loadByKey() {
        if( !isset($this->template_name) || !isset($this->param_name) ) return null;
        $this->_db->setQuery("SELECT id FROM #__configurator WHERE `template_name` = '{$this->template_name}' AND `param_name` = '{$this->param_name}' LIMIT 1");
        $this->load( $this->_db->loadResult() );   
    }
        
}
?>