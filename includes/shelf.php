<?php
$template_dir = JPATH_SITE . DS . 'templates' . DS . 'morph/';
$template_url = JURI::root() . 'templates/morph/';
$themelet_url = JURI::root() . 'templates/morph/assets/themelets/';
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

if(isset($_COOKIE['us_'.$themelet_arr['foldername']])){ 
	$themelet_cookie_val = split('##', $_COOKIE['us_'.$themelet_arr['foldername']]); 
	$themelet_us_version = $themelet_cookie_val[0];
}else{ $themelet_us_version = ''; }

if(isset($_COOKIE['us_'.$template_arr['foldername']])){ 
	$template_cookie_val = split('##', $_COOKIE['us_'.$template_arr['foldername']]); 
	$template_us_version = $template_cookie_val[0];
}else{ $template_us_version = ''; }

if(isset($_COOKIE['us_'.$component_arr['foldername']])){ 
	$component_cookie_val = split('##', $_COOKIE['us_'.$component_arr['foldername']]); 
	$component_us_version = $component_cookie_val[0];
}else{ $component_us_version = ''; }

function showIcon($curr, $serv){
	if($curr < $serv){
		return '<span class="update-no" title="There is an update available">Update Available</span>';
	}else{
		return '<span class="update-yes" title="You are up to date">Up to date</span>';
	}
}

?>
<div id="shelf" class="<?php if(!isset($_COOKIE['shelf']) || $_COOKIE['shelf'] == 'show'){ echo 'open'; }else{ echo 'closed'; } ?>">
	<div id="utilities">
			<ul>
				<li class="logged-in">Logged in as: <strong><?php echo $_COOKIE['am_logged_in_user']; ?></strong>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" class="logout-configurator">Logout</a></li>
				<li class="toggle-shelf"><a href="#" title="" id="toggle-shelf"><?php if(!isset($_COOKIE['shelf']) || $_COOKIE['shelf'] == 'show'){ echo 'Hide Shelf'; }else{ echo 'Open Shelf'; } ?></a></li>
				<li class="shortcuts"><a href="#" title="" id="keyboard-toggle">Keyboard Shortcuts</a></li>

				<!--<li class="report-bug"><a href="#" title="" id="report-bug-link">Submit Feedback</a></li>
				<li class="preferences"><a href="#" title="">Preferences</a></li>
				<li class="full-mode" id="fullscreen"><a href="#" title="" id="screenmode">Fullscreen Mode</a></li>-->
			</ul>
		</div>
		<div id="shelf-contents">
		<div id="updates-summary">
			<h3>Updates summary</h3>
			<p class="updates-help">(<a href="#" class="updates-link">Help</a>)</p>
				<dl>
					<dt class="component com_configurator" id="us-configurator">Configurator</dt>
					<dd class="current"><?php echo $component_arr['version']; ?></dd>
					<dd class="latest"><?php echo $component_arr['version']; ?></dd>
					<dd class="icon"><?php echo showIcon($component_arr['version'], $component_arr['version']); ?></dd>
	
					<dt class="template morph alt" id="us-morph">Morph</dt>
					<dd class="current"><?php echo $template_arr['version']; ?></dd>
					<dd class="latest"><?php echo $template_us_version; ?></dd>
					<dd class="icon"><?php echo showIcon($template_arr['version'], $template_arr['version']); ?></dd>
				
					<dt class="themelet <?php echo $themelet_arr['foldername']; ?>" id="us-themelet"><?php echo $themelet_arr['name']; ?></dt>
					<dd class="current"><?php echo $themelet_arr['version']; ?></dd>
					<dd class="latest"><?php echo $themelet_us_version; ?></dd>
					<dd class="icon"><?php echo showIcon($themelet_arr['version'], $themelet_arr['version']); ?></dd>						
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
			<h3>Quick reference guides</h3>
				<ul class="buttons">
					<li><a class="info-link btn-link" href="gettingstarted.html" title="Configurator quick start guide">Quick Start</a></li>
					<li><a class="refimage-block btn-link" onclick="return false;" href="../administrator/components/com_configurator/images/visual-reference-blocks.png" title="Visual Reference: By Block">Block Map</a></li>
					<li><a class="refimage-position btn-link" onclick="return false;" href="../administrator/components/com_configurator/images/visual-reference-positions.png" title="Visual Reference: By Block">Position Map</a></li>
					<li class="last"><a class="modal-link btn-link" href="troubleshooting.html" title="Morph troubleshooting guide">Troubleshooting</a></li>
					<li><a class="modal-link btn-link" href="modfx.html" title="Getting started with ModuleFX">ModuleFX</a></li>
					<li><a class="modal-link btn-link" href="pagefx.html" title="Getting started with PageFX">PageFX</a></li>
					<li><a class="modal-link btn-link" href="menufx.html" title="Getting started with MenuFX">MenuFX</a></li>
					<li><a class="modal-link btn-link" href="contentfx.html" title="Getting started with ContentFX">ContentFX</a></li>
				</ul>
		</div>
	</div>
</div>