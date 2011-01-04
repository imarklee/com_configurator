<?php
class ComConfiguratorToolbarDefault extends KToolbarAbstract
{
	/**
	 * Render the toolbar
	 *
	 * @TODO this is all just for legacy with all the JS that still expect the toolbar to have the #toolbar id, instead of #toolbar-configuration
	 *
	 * @throws KToolbarException When the button could not be found
	 * @return	string	HTML
	 */
	public function render()
	{
		$id		= 'toolbar-'.$this->getName();
		$html = array ();

		// Start toolbar div
		$html[] = '<div class="toolbar" id="toolbar">';
		$html[] = '<table class="toolbar"><tr>';

		// Render each button in the toolbar
		foreach ($this->_buttons as $button)
		{
			if(!($button instanceof KToolbarButtonInterface))
			{
				$app		= $this->_identifier->application;
				$package	= $this->_identifier->package;
				$button = KFactory::tmp($app.'::com.'.$package.'.toolbar.button.'.$button);
			}

			$button->setParent($this);
			$html[] = $button->render();
		}

		// End toolbar div
		$html[] = '</tr></table>';
		$html[] = '</div>';

		return implode(PHP_EOL, $html);
	}
}