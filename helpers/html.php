<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

/**
 * ComConfiguratorHelperHtml
 *
 * Helper for rendering html, like the params
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
class ComConfiguratorHelperHtml extends KTemplateHelperAbstract
{
	/**
	 * Renders a params group
	 *
	 * @param  array	Configuration array
	 * @return string	Html
	 */
	public function params($config = array())
	{
		$config = new KConfig($config);

		$config->append(array(
			'name'		=> 'general',
			'params'	=> false
		))->append(array(
			'group'		=> $config->name . 'data'
		));
		
		$array = $config->params->renderToArray($config->name, $config->group);
		if(!is_array($array)) return;
		
		$html	= '';
		$params = array();
		foreach ($array as $value){
			$params[] = $value;
		}
	
		$x = count($params);	
		for($i=0; $i < $x; $i++){
		
			$heading = $params[$i][5];
		
			if(!preg_match('/heading/i', $heading)){
				$class = ( ($i % 2) ? 'class="row alt"' : 'class="row"');
			}else{
				$class = 'class="row-heading"';
			}
		
			for($n = 0; $n < 2; $n++){
				$html .= "\t\t\t".$params[$i][$n]."\n";
			}
		}
		return $html;
	}
}