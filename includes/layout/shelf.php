<?php
$template_dir = JPATH_SITE . DS . 'templates' . DS . 'morph/';
$template_url = JURI::root() . 'templates/morph/';
$themelet_url = JURI::root() . 'morph_assets/themelets/';
$component_url = JURI::root() . 'administrator/components/com_configurator/'; 
							
$template_xml = $template_url . 'templateDetails.xml';
$themelet_xml = $themelet_url . $params->get('themelet') .'/themeletDetails.xml';
$component_xml = $component_url . 'configurator.xml';

$template_details = xml2array($template_xml);
$themelet_details = xml2array($themelet_xml);
$component_details = xml2array($component_xml);

$template_arr = $template_details['install'];
$themelet_arr = $themelet_details['install'];
$component_arr = $component_details['install'];

setcookie('current_themelet', $themelet_arr['foldername']); ?>

<div id="shelf" class="<?php if(!isset($_COOKIE['shelf']) || $_COOKIE['shelf'] == 'show'){ echo 'open'; }else{ echo 'closed'; } ?>">
	<div id="utilities">
		<ul>
			<li class="logged-in">Logged in as: <strong><?php echo $_COOKIE['am_logged_in_user']; ?></strong>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" class="logout-configurator">Logout</a></li>
			<li class="toggle-shelf"><a href="#" title="" id="toggle-shelf">
			<?php if(!isset($_COOKIE['shelf']) || $_COOKIE['shelf'] == 'show'){ echo 'Hide Shelf'; }else{ echo 'Open Shelf'; } ?></a></li>
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
					<dd class="current"><span title="Your installed version is <?php echo $component_arr['version']; ?>. Click on the help link above for more information."><?php echo $component_arr['version']; ?></span></dd>
					<dd class="latest"><span title="The latest available version is <?php echo $component_us_version; ?>. Click on the help link above for more information."><?php echo $component_us_version; ?></span></dd>
					<dd class="icon"></dd>
	
					<dt name="morph" type="shelf" id="us-morph">Morph</dt>
					<dd class="current"><span title="Your installed version is <?php echo $template_arr['version']; ?>. Click on the help link above for more information."><?php echo $template_arr['version']; ?></dd>
					<dd class="latest"><span title="The latest available version is <?php echo $template_us_version; ?>. Click on the help link above for more information."><?php echo $template_us_version; ?></dd>
					<dd class="icon"></dd>
				
					<dt name="<?php echo $themelet_arr['foldername']; ?>" type="shelf" id="us-themelet"><?php echo $themelet_arr['name']; ?></dt>
					<dd class="current"><span title="Your installed version is <?php echo $themelet_arr['version']; ?>. Click on the help link above for more information."><?php echo $themelet_arr['version']; ?></dd>
					<dd class="latest"><span title="The latest available version is <?php echo $themelet_us_version; ?>. Click on the help link above for more information."><?php echo $themelet_us_version; ?></dd>
					<dd class="icon"></dd>						
				</dl>
		</div>  
		<div id="current-themelet">
			<h3>Current themelet</h3>
			<ul>
				<li class="ct-name"><span>Name: </span><?php echo $themelet_arr['name']; ?></li>
				<li class="ct-author"><span>Author: </span><a href="<?php echo $themelet_arr['authorUrl']; ?>" target="_blank" title="View all themelets by this provider"><?php echo $themelet_arr['author']; ?></a></li>
				<li class="ct-version"><span>Version: </span><?php echo $themelet_arr['version']; ?></li>
				<li class="thumb ct-thumb"><span>&nbsp;</span><img src="<?php echo $themelet_url . $params->get('themelet'); ?>/themelet_thumb.png" width="108" height="72" align="middle" alt="<?php echo $themelet_arr['name']; ?>" /></li>
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