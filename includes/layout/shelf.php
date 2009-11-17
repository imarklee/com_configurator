<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2009 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

$path = JPATH_SITE . DS;
$urlpath = JURI::root();

$template_path	= $path . 'templates'.DS.'morph'.DS;
$themelet_path 	= $path . 'morph_assets'.DS.'themelets'.DS;
$component_path = $path . 'administrator'.DS.'components'.DS.'com_configurator'.DS;

$template_urlpath 	= $urlpath . 'templates'.DS.'morph'.DS;
$themelet_urlpath 	= $urlpath . 'morph_assets'.DS.'themelets'.DS;
$component_urlpath 	= $urlpath . 'administrator'.DS.'components'.DS.'com_configurator'.DS;

$template_xml = $template_path . 'templateDetails.xml';
$themelet_xml = $themelet_path . $params->get('themelet').DS.'themeletDetails.xml';
$component_xml = $component_path . 'configurator.xml';

$template_details = xml2array($template_xml);
$themelet_details = xml2array($themelet_xml);
$component_details = xml2array($component_xml);

$template_arr = $template_details['install'];
$themelet_arr = $themelet_details['install'];
$component_arr = $component_details['install'];

setcookie('current_themelet', $params->get('themelet')); ?>

<div id="shelf" class="<?php if(!isset($_COOKIE['shelf']) || $_COOKIE['shelf'] == 'show'){ echo 'open'; }else{ echo 'closed'; } ?>">
	<div id="utilities">
		<ul>
			<li class="user">
			    Logged in as: <strong><?php echo $user[0]['user_name']; ?></strong>
            </li>
			<li class="logout">
			    <a href="#" class="logout-configurator">Logout</a>
			</li>
			<li class="changes">
			    <?php if(isset($_COOKIE['formChanges'])){ ?><span class="shelf-notice">You have unsaved changes</span><?php }?></li>
			</li>
			<li class="toggle-shelf">
			    <a href="#" <?php if(!isset($_COOKIE['shelf']) || $_COOKIE['shelf'] == 'show'){ echo 'toggle="show"'; }else{ echo 'toggle="hide"'; } ?> title="" id="toggle-shelf">
			    <?php if(!isset($_COOKIE['shelf']) || $_COOKIE['shelf'] == 'show'){ echo 'Hide Shelf'; }else{ echo 'Show Shelf'; } ?></a>
			</li>
		</ul>
	</div>
	<div id="shelf-contents">
		<div id="updates-summary">
			<h3>Updates summary</h3>
			<p class="updates-help">
				<a href="#" class="tt-inline updates-help-link" title="Help::Get help on the Configurator inline updating system">help</a>
				<a href="#" class="tt-inline updates-refresh-link" title="Check for Updates::Check for updates on Configurator, Morph and installed themelet.">check for updates</a>
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
				<li class="ct-name"><span>Name: </span><?php echo $themelet_arr['name']; ?></li>
				<li class="ct-author"><span>Author: </span><a href="<?php echo $themelet_arr['authorUrl']; ?>" target="_blank" title="View all themelets by this provider">
				<?php echo $themelet_arr['author']; ?></a></li>
				<li class="ct-version"><span>Version: </span><?php echo $themelet_arr['version']; ?></li>
				<li class="thumb ct-thumb"><span>&nbsp;</span>
				<img src="<?php echo $themelet_urlpath . $params->get('themelet'); ?>/themelet_thumb.png" width="108" height="72" align="middle" alt="<?php echo $themelet_arr['name']; ?>" />
				</li>
			</ul>
		</div>
		<div id="visual-refs">
			<h3>Quick reference guides <span>(<a href="#" title="" id="keyboard-toggle">Keyboard Shortcuts</a>)</span></h3>
			<ul class="buttons">
				<li><a class="info-link btn-link" href="gettingstarted.html" title="Configurator quick start guide">Quick Start</a></li>
				<li><a class="modal-link-img btn-link" href="visual-blocks.html" title="Visual Reference: By Block">Block Map</a></li>
				<li><a class="modal-link-img btn-link" href="visual-positions.html" title="Visual Reference: By Block">Position Map</a></li>
				<li class="last"><a class="modal-link btn-link" href="troubleshooting.html" title="Morph troubleshooting guide">Troubleshooting</a></li>
				<li><a class="modal-link btn-link" href="modfx.html" title="Getting started with ModuleFX">ModuleFX</a></li>
				<li><a class="modal-link btn-link" href="pagefx.html" title="Getting started with PageFX">PageFX</a></li>
				<li><a class="modal-link btn-link" href="menufx.html" title="Getting started with MenuFX">MenuFX</a></li>
				<li><a class="modal-link btn-link" href="contentfx.html" title="Getting started with ContentFX">ContentFX</a></li>
				<li><a class="modal-link btn-link" href="chromefx.html" title="Getting started with ContentFX">ChromeFX</a></li>
			</ul>
		</div>
	</div>
</div>