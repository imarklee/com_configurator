<?php defined('_JEXEC') or die('Restricted access');
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

$path = JPATH_SITE.'/';
$urlpath = JURI::root();

$template_path	= $path . 'templates/morph/';
$themelet_path 	= $path . 'morph_assets/themelets/';
$component_path = $path . 'administrator/components/com_configurator/';

$template_urlpath 	= $urlpath . 'templates/morph/';
$themelet_urlpath 	= $urlpath . 'morph_assets/themelets/';
$component_urlpath 	= $urlpath . 'administrator/components/com_configurator/';

$template_xml = $template_path . 'templateDetails.xml';
$themelet_xml = $themelet_path . $params->get('themelet').'/themeletDetails.xml';
$component_xml = $component_path . 'configurator.xml';

$template_arr = (array) simplexml_load_file($template_xml);
$themelet_arr = (array) simplexml_load_file($themelet_xml) ? (array) simplexml_load_file($themelet_xml) : array('name' => 'No themelet', 'foldername' => 'none', 'version' => null, 'author' => null, 'authorUrl' => '#');
$component_arr = (array) simplexml_load_file($component_xml);

setcookie('current_themelet', $params->get('themelet'), 0, '/'); ?>

<div id="shelf" class="<?php if(!isset($_COOKIE['shelf']) || $_COOKIE['shelf'] == 'show'){ echo 'open'; }else{ echo 'closed'; } ?>">
	<div id="utilities">
		<ul>
			<?php $app = JFactory::getApplication() ?>
			<?php if(isset($_COOKIE['formChanges'])){ ?>
			<li class="changes">
			    <span class="shelf-notice"><?= @text('You have unsaved changes') ?></span>
			</li>
			<?php } ?>
			<li class="toggle-shelf">
			    <a href="#" <?php if(!isset($_COOKIE['shelf']) || $_COOKIE['shelf'] == 'show'){ echo 'toggle="show"'; }else{ echo 'toggle="hide"'; } ?> title="" id="toggle-shelf">
			    <?php if(!isset($_COOKIE['shelf']) || $_COOKIE['shelf'] == 'show'){ echo 'Hide Shelf'; }else{ echo 'Show Shelf'; } ?></a>
			</li>
		</ul>
	</div>
	<div id="shelf-contents">
		<div id="updates-summary">
			<h3><?= @text('Updates summary') ?></h3>
			<p class="updates-help">
				<a href="#" class="tt-inline updates-help-link" title="Help::Get help on the Configurator inline updating system"><?= @text('help') ?></a>
				<a href="#" class="tt-inline updates-refresh-link" title="Check for Updates::Check for updates on Configurator, Morph and installed themelet."><?= @text('check for updates') ?></a>
			</p>
				<dl>
					<dt name="com_configurator" type="shelf" id="us-configurator">Configurator</dt>
					<dd class="current"><span title="Your installed version is <?php echo $component_arr['version']; ?>. Click on the help link above for more information.">
					<?php echo $component_arr['version']; ?></span></dd>
					<dd class="latest">&nbsp;</dd>
					<dd class="icon">&nbsp;</dd>
	
					<dt name="morph" type="shelf" id="us-morph">Morph</dt>
					<dd class="current"><span title="Your installed version is <?php echo $template_arr['version']; ?>. Click on the help link above for more information.">
					<?php echo $template_arr['version']; ?></span></dd>
					<dd class="latest">&nbsp;</dd>
					<dd class="icon">&nbsp;</dd>
				
					<dt name="<?php echo $themelet_arr['foldername']; ?>" type="shelf" id="us-themelet"><?php echo $themelet_arr['name']; ?></dt>
					<dd class="current"><span title="Your installed version is <?php echo $themelet_arr['version']; ?>. Click on the help link above for more information.">
					<?php echo $themelet_arr['version']; ?></span></dd>
					<dd class="latest">&nbsp;</dd>
					<dd class="icon">&nbsp;</dd>						
				</dl>
		</div>  
		<div id="current-themelet">
			<h3>Current themelet</h3>
			<ul>
				<li class="ct-name"><span><?= @text('Name:') ?> </span><?php echo $themelet_arr['name']; ?></li>
				<li class="ct-author"><span><?= @text('Author:') ?> </span><a href="<?php echo $themelet_arr['authorUrl']; ?>" target="_blank" title="View all themelets by this provider"><?php echo $themelet_arr['author']; ?></a></li>
				<li class="ct-version"><span><?= @text('Version:') ?> </span><?php echo $themelet_arr['version']; ?></li>
				<li class="thumb ct-thumb"><span>&nbsp;</span>
				<img src="<?php echo $themelet_urlpath . $params->get('themelet'); ?>/themelet_thumb.png" width="108" height="72" align="middle" alt="<?php echo $themelet_arr['name']; ?>" />
				</li>
			</ul>
		</div>
		<div id="visual-refs">
			<h3><?= @text('Quick reference guides') ?> <span>(<a href="#" title="" id="keyboard-toggle"><?= @text('Keyboard Shortcuts') ?></a>)</span></h3>
			<ul class="buttons">
				<li><a class="info-link btn-link" href="gettingstarted.html" title="Morph Quick Start Guide"><?= @text('Quick Start') ?></a></li>
				<li><a class="modal-link-img btn-link" href="visual-blocks.html" title="Visual Reference: Building Blocks"><?= @text('Blocks Reference') ?></a></li>
				<li><a class="modal-link-img btn-link" href="visual-positions.html" title="Visual Reference: Module Positions"><?= @text('Module Positions') ?></a></li>
				<li><a class="modal-link btn-link" href="modfx.html" title="Introduction to ModuleFX"><?= @text('ModuleFX') ?></a></li>
				<li><a class="modal-link btn-link" href="pagefx.html" title="Introduction to PageFX"><?= @text('PageFX') ?></a></li>
				<li><a class="modal-link btn-link" href="menufx.html" title="Introduction to MenuFX"><?= @text('MenuFX') ?></a></li>
				<li><a class="modal-link btn-link" href="contentfx.html" title="Introduction to ContentFX"><?= @text('ContentFX') ?></a></li>
				<li><a class="modal-link btn-link" href="chromefx.html" title="Introduction to ChromeFX"><?= @text('ChromeFX') ?></a></li>
			</ul>
		</div>
	</div>
</div>