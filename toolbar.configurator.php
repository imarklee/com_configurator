<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2009 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once(JApplicationHelper::getPath( 'toolbar_html' ));
switch ($task){
	case 'manage' 	: toolbar_morph::manage_toolbar(); break;
	case 'help'		: toolbar_morph::help_toolbar(); break;
	default			: toolbar_morph::manage_toolbar(); break;
}
?>