<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JApplicationHelper::getPath( 'toolbar_html' ));
switch ($task)
{
	case 'add' : TOOLBAR_morph::_EDIT(false); break;
	case 'edit': TOOLBAR_morph::_EDIT(true); break;
	default: TOOLBAR_morph::_DEFAULT(); break;
}
?>