<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class TableConfiguratorPreferences extends JTable {
    
    var $id = null;
    var $custom_name = null;
    var $custom_value = null;

    function TableConfiguratorCustomCode($db) { parent::__construct('#__configurator_customcode', 'id', $db); }
    
    function loadByKey() {
        if(!isset($this->pref_name) ) return null;
        $this->_db->setQuery("SELECT id FROM #__configurator_customcode WHERE `custom_name` = '{$this->custom_name}' LIMIT 1");
        $this->load( $this->_db->loadResult() );   
    }
        
}
?>