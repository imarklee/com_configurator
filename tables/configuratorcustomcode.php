<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

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