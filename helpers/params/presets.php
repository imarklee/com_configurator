<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

class ComConfiguratorHelperParamPresets extends ComConfiguratorHelperParamAbstract {
    
    /**
     * Get the presets, if it's the right preset
     *
     * @param $name
     * @return return type
     */
    public function getData($name)
    {
    	if($this->_xml->params->name == $name) return parent::getData();
    	return array();
    }
}