<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined('_JEXEC') or die('Restricted access');

function bs_class($bs_op){
	$bs_class = '';
	switch($bs_op){
		case '1':$bs_class = ' class="always"';break;
		case '2':$bs_class = ' class="unsaved"';break;
		case '3':$bs_class = ' class="topsave"';break;
		case '4':$bs_class = ' class="unsaved_topsave"';break;
	}
return $bs_class;
}
function array_shuffle($array) {
    if (shuffle($array)) {
        return $array;
    } else {
        return FALSE;
    }
} 
function decode_data($data){
	return (array)unserialize(str_replace('\\', '', urldecode($data)));
}