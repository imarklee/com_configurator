<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class TOOLBAR_morph
{
	
	function _DEFAULT()
	{
	
		//function getoption(){ return $_GET['task']; } 
		JToolBarHelper::title(  JText::_( 'Configurator' ), 'configurator' );
		if($_GET['task'] == 'manage'){
			JToolBarHelper::apply('applytemplate', 'Save');
			JToolBarHelper::back( 'Dashboard', 'index.php?option=com_configurator&task=dashboard' );
		}elseif($_GET['task'] == 'dashboard'){
			JToolBarHelper::back( 'Manage', 'index.php?option=com_configurator&task=manage' );
		}
	}

	function _EDIT($edit)
	{
		JToolBarHelper::title(  JText::_( 'Configure Morph' ), 'configurator' );
//		JToolBarHelper::save();
		JToolBarHelper::apply( JText::_( 'Save Settings' ), 'save');
		if ($edit) {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		} else {
			JToolBarHelper::cancel();
		}
	}
}
?>