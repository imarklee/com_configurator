<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

/**
 * ComConfiguratorControllerDispatch
 *
 * Dispatches Configurator, executing a controller task and then redirects it
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
 class ComConfiguratorControllerDispatch extends ComConfiguratorControllerAbstract
 {
 	/**
 	 * Constructs, and if a task is passed, execute it
 	 *
 	 * @param  $task optional
 	 */
 	public function __construct($task = false)
 	{
 		if(!$task) return parent::__construct();

 		// Create the controller
 		$controller = new ComConfiguratorControllerDefault();
 		
 		// Perform the Request task
 		$controller->execute($task);
 		// Redirect if set by the controller
 		$controller->redirect();
 	}
 }