<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined('_JEXEC') or die('Restricted access');

function getTemplateParamList( $file = false )
{
    if( !$file ) return array();
    $xml = new morphXMLParams( $file );
    return $xml->getData();
}

function getPresetParamList( $file, $name ) {
    $xml = new morphXMLPresets( $file );
    return $xml->getData( $name );
}

function getTemplateName( $file )
{
	return (string) simplexml_load_file($file)->params->name;
}