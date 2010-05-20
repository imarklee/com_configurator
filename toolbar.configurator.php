<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Creates an instance of the toolbar, and renders it
 * 
 * @author Stian Didriksen <stian@prothemer.com>
 */
new ComConfiguratorToolbarHtml(JRequest::getCmd('task') == 'help' ? 'Help' : 'Manage');