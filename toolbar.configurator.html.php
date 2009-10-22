<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2009 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined( '_JEXEC' ) or die( 'Restricted access' );
class toolbar_morph {
	function manage_toolbar(){
		JToolBarHelper::title(  JText::_( 'Configurator > <span>Manage</span>' ), 'configurator' );
		$bar = JToolBar::getInstance( 'toolbar' );
		if(ConfiguratorController::checkUser()){
			$bar->appendButton( 'Custom', '<a href="#" class="toolbar">'.JText::_('Save').'</a>', 'apply' );
			$bar->appendButton( 'Custom', '<a href="#" class="toolbar">'.JText::_('Fullscreen').'</a>', 'fullscreen' );
			$bar->appendButton( 'Custom', '<a href="#" class="toolbar">'.JText::_('Preferences ').'</a>', 'preferences' );
			$bar->appendButton( 'Custom', '<a href="#" class="toolbar">'.JText::_('Feedback').'</a>', 'report-bug-link' );
			$bar->appendButton( 'Custom', '<a href="#" class="toolbar">'.JText::_('Credits').'</a>', 'credits-link' );
			$bar->appendButton( 'Custom', '<a href="'.JURI::root().'administrator/index.php?option=com_configurator&task=help" class="toolbar">'.JText::_('Help').'</a>', 'help-link' );
		}else{
			$bar->appendButton( 'Custom', '<a href="#" class="toolbar">'.JText::_('Report Bug').'</a>', 'report-bug-email-link' );
		}
	}

	function help_toolbar(){
		JToolBarHelper::title(  JText::_( 'Configurator > <span>LiveDocs</span>' ), 'configurator-help' );
		
		$bar = JToolBar::getInstance( 'toolbar' );
		$bar->appendButton( 'Custom', '<a href="'.JURI::root().'administrator/index.php?option=com_configurator&task=manage" class="toolbar">'.JText::_('Back').'</a>', 'configurator' );
	}
}
?>