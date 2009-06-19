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
?>
<div id="utilities" class="ui-widget-header">
		<ul>
			<li class="toggle-shelf"><a href="#" title="" id="toggle-shelf">Toggle display</a></li>
			<li class="report-bug"><a href="#" title="" id="report-bug-link">Report a bug</a></li>
			<li class="preferences"><a href="#" title="">Preferences</a></li>
		</ul>
	</div>
	<div id="shelf-contents" class="ui-widget-content">
	<div id="updates-summary">
		<h3>Updates summary</h3>
			<dl>
				<dt class="component com_configurator" id="us-configurator">Configurator</dt>
				<dd class="current"><?php echo $component_arr['version']; ?></dd>
				<dd class="latest"></dd>
				<dd class="icon"></dd>

				<dt class="template morph alt" id="us-morph">Morph</dt>
				<dd class="current"><?php echo $template_arr['version']; ?></dd>
				<dd class="latest"></dd>
				<dd class="icon"></dd>
			
				<dt class="themelet <?php echo $themelet_arr['foldername']; ?>" id="us-themelet"><?php echo $themelet_arr['name']; ?></dt>
				<dd class="current"><?php echo $themelet_arr['version']; ?></dd>
				<dd class="latest"></dd>
				<dd class="icon"></dd>						
			</dl>
	</div>  
	<div id="current-themelet">
		<h3>Current themelet</h3>
		<ul>
			<li><span>Name: </span><?php echo $template_arr['name']; ?></li>
			<li><span>Author: </span><a href="<?php echo $template_arr['authorUrl']; ?>" target="_blank" title="View all themelets by this provider"><?php echo $template_arr['author']; ?></a></li>
			<li><span>Version: </span><?php echo $template_arr['version']; ?></li>
			<li class="thumb"><span>&nbsp;</span><img src="<?php echo $themelet_url . $params->get('themelet'); ?>/themelet_thumb.png" width="108" height="72" align="center" alt="<?php echo $themelet_arr['name']; ?>" /></li>
		</ul>
	</div> 
	<div id="visual-refs">
		<h3>Quick reference guides</h3>
			<ul class="buttons">
				<li><a class="modal-link" href="gettingstarted.html" title="Visual Reference: By Block">Quick Start</a></li>
				<li><a class="modal-link" href="gettingstarted.html" title="Visual Reference: By Block">Block Map</a></li>
				<li><a class="modal-link" href="gettingstarted.html" title="Visual Reference: By Block">Position Map</a></li>
				<li><a class="modal-link" href="gettingstarted.html" title="Visual Reference: By Block">Troubleshooting</a></li>
				<li><a class="modal-link" href="gettingstarted.html" title="Visual Reference: By Block">ModuleFX</a></li>
				<li><a class="modal-link" href="gettingstarted.html" title="Visual Reference: By Block">PageFX</a></li>
				<li><a class="modal-link" href="gettingstarted.html" title="Visual Reference: By Block">MenuFX</a></li>
				<li><a class="modal-link" href="gettingstarted.html" title="Visual Reference: By Block">ContentFX</a></li>
			</ul>
	</div>
</div>