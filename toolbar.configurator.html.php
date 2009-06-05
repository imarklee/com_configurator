<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class TOOLBAR_morph
{
	function _DEFAULT()
	{
		JToolBarHelper::title(  JText::_( 'Configurator' ), 'configurator' );
	}

	function _EDIT($edit)
	{
		JToolBarHelper::title(  JText::_( 'Configure Morph' ), 'configurator' );
		JToolBarHelper::save();
		JToolBarHelper::apply();
		if ($edit) {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		} else {
			JToolBarHelper::cancel();
		}
	}
}
?>