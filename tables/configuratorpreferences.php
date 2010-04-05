<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2009 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

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