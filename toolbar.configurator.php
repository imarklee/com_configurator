<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once(JApplicationHelper::getPath( 'toolbar_html' ));
switch ($task){
	case 'manage' 	: toolbar_morph::manage_toolbar(); break;
	case 'help'		: toolbar_morph::help_toolbar(); break;
	default			: toolbar_morph::manage_toolbar(); break;
}
?>