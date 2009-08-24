<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class TableConfiguratorPreferences extends JTable {
    
    var $id = null;
    var $pref_name = null;
    var $pref_value = null;

    function TableConfiguratorPreferences(&$db) { parent::__construct('#__configurator_preferences', 'id', $db); }
    
    function loadByKey() {
        if(!isset($this->pref_name) ) return null;
        $this->_db->setQuery("SELECT id FROM #__configurator_preferences WHERE `pref_name` = '{$this->pref_name}' LIMIT 1");
        $this->load( $this->_db->loadResult() );   
    }
        
}
?>