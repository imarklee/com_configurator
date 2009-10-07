<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class TOOLBAR_morph
{
	
	function _DEFAULT()
	{
	
		//function getoption(){ return $_GET['task']; } 
		JToolBarHelper::title(  JText::_( 'Configurator' ), 'configurator' );
		if($_REQUEST['task'] == 'manage'){
			$bar = JToolBar::getInstance( 'toolbar' );
			if(ConfiguratorController::checkUser()){
				$bar->appendButton( 'Custom', '<a href="#" class="toolbar">'.JText::_('Save').'</a>', 'apply' );
				$bar->appendButton( 'Custom', '<a href="#" class="toolbar">'.JText::_('Fullscreen').'</a>', 'fullscreen' );
				$bar->appendButton( 'Custom', '<a href="#" class="toolbar">'.JText::_('Preferences ').'</a>', 'preferences' );
				$bar->appendButton( 'Custom', '<a href="#" class="toolbar">'.JText::_('Feedback').'</a>', 'report-bug-link' );
			}else{
				$bar->appendButton( 'Custom', '<a href="#" class="toolbar">'.JText::_('Report Bug').'</a>', 'report-bug-email-link' );
			}
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