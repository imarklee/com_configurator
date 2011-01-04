<?php

class ComConfiguratorToolbarButtonDefault extends KToolbarButtonAbstract
{
    /**
     * Initializes the options for the object
     *
     * Called from {@link __construct()} as a first step of object instantiation.
     *
     * @param 	object 	An optional KConfig object with configuration options
     * @return  void
     */
    protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'link' => '#',
        ));

        parent::_initialize($config);
    }
    
    /**
     * @TODO this is all just for legacy for the css and js that can't handle the empty span inside the button
     */
    public function render()
	{
		$text	= JText::_($this->_options->text);

		$link   = $this->getLink();
		$href   = !empty($link) ? 'href="'.JRoute::_($link).'"' : '';

		$onclick =  $this->getOnClick();
		$onclick = !empty($onclick) ? 'onclick="'. $onclick.'"' : '';

		$html 	= array ();
		$html[]	= '<td class="button" id="'.$this->getId().'">';
		$html[]	= '<a '.$href.' '.$onclick.' class="toolbar">';
		$html[]	= $text;
		$html[]	= '</a>';
		$html[]	= '</td>';

		return implode(PHP_EOL, $html);
	}

	public function getLink()
	{
		return $this->_options->link;
	}

	public function getOnClick()
	{
		return '';
	}

	public function getId()
	{
		return 'toolbar-'.$this->_options->id;
	}
}