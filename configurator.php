<?php
defined ('_JEXEC') or die('Direct Access to this location is not allowed.');

if (file_exists($mosConfig_absolute_path . "/components/$option/language/" . $mosConfig_lang . ".php")) {
    include ($mosConfig_absolute_path . "/components/$option/language/" . $mosConfig_lang . ".php");
} else {
    include ($mosConfig_absolute_path . "/components/$option/language/english.php");
}

include ($mosConfig_absolute_path . "/components/$option/configuration.php");

require_once ($mainframe->getPath('front_html'));
require_once ($mainframe->getPath('class'));

$mainframe->setPageTitle("Morph by Prothemer");

$page=mosGetParam($_REQUEST, 'page');
$task=mosGetParam($_REQUEST, 'task');

switch ($task) { default: break; }
switch ($page) { default: break; }
?>