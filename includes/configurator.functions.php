<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined('_JEXEC') or die('Restricted access');

function get_os(){
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$os = "unknown";
	
	if (preg_match("/win/i", $agent)) $os = "windows";
    elseif (preg_match("/mac/i", $agent)) $os = "mac";
    elseif (preg_match("/linux/i", $agent)) $os = "linux";
    elseif (preg_match("/OS\/2/i", $agent)) $os = "OS/2";
    elseif (preg_match("/BeOS/i", $agent)) $os = "beos";
        
return $os;
}
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
function whichKey($os){
	if($os == 'mac') $key = '&#x2318;';
	else $key = 'Ctrl';
	return $key;
}
function array_shuffle($array) {
    if (shuffle($array)) {
        return $array;
    } else {
        return FALSE;
    }
} 
function renderParams($array){

	foreach ($array as $value){
		$params[] = $value;
	}
	
	$x = count($params);	
	for($i=0; $i < $x; $i++){
	
		$heading = $params[$i][5];
	
		if(!preg_match('/heading/i', $heading)){
			$class = ( ($i % 2) ? 'class="row alt"' : 'class="row"');
		}else{
			$class = 'class="row-heading"';
		}
	
		for($n = 0; $n < 2; $n++){
			echo "\t\t\t".$params[$i][$n]."\n";
		}
	}
}

function decode_data($data){
	return (array)unserialize(str_replace('\\', '', urldecode($data)));
}

function pageURL() {
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
return $pageURL;
}