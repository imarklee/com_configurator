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
<table border="0" cellspacing="0" cellpadding="0" id="configurator-summary" width="100%">
	<caption>Updates Summary</caption>
	<tbody>
		<tr class="component com_configurator" id="us-configurator">
			<td class="label">Configurator Version:</td>
			<td class="installed-version"><?php echo $component_arr['version']; ?></td>
			<td class="current-version">Not Available</td>
			<td class="status"></td>			
		</tr>
		<tr class="template morph alt" id="us-morph">
			<td class="label">Morph Version:</td>
			<td class="installed-version"><?php echo $template_arr['version']; ?></td>
			<td class="current-version">Not Available</td>
			<td class="status"></td>
		</tr>
		<tr class="themelet <?php echo $themelet_arr['foldername']; ?>" id="us-themelet">
			<td class="label">Themelet Version:</td>
			<td class="installed-version"><?php echo $themelet_arr['version']; ?></td>
			<td class="current-version">Not Available</td>
			<td class="status"></td>
		</tr>
	</tbody>
</table>

<table border="0" cellspacing="0" cellpadding="0" id="current-themelets" width="100%">
	<caption>Current Themelet:</caption>
	<tbody>
		<tr>
			<td class="label">Themelet Name:</td>
			<td class="themelet-name"><?php echo $themelet_arr['name']; ?></td>
			<td class="themelet-thumb" rowspan="3"><img src="<?php echo $themelet_url . $params->get('themelet'); ?>/themelet_thumb.png" width="95" /></td>
		</tr>
		<tr>
			<td class="label">Thelemet Author:</td>
			<td class="themelet-author"><?php echo $template_arr['author']; ?></td>
		</tr>
		<tr>
			<td class="label">Thelemet Version:</td>
			<td class="installed-version"><?php echo $themelet_arr['version']; ?></td>
		</tr>
	</tbody>
</table>


<table border="0" cellspacing="0" cellpadding="0" id="installed-themelets" width="100%">
	<caption>Other Installed Themelets:</caption>
	<tfoot>
		<tr>
			<td colspan="5"><i>*</i> <span class="installed-version">Installed Version</span> / <span class="current-version">Current Version</span></td>
		</tr>	
	</tfoot>
	<tbody>
	<?php
	$themelet_dir = JPATH_ROOT . DS . 'templates' . DS . 'morph' . DS . 'assets' . DS . 'themelets';          
	if(is_dir($themelet_dir)) {
		$lists['themelets'] = JFolder::folders( $themelet_dir );
	} else {
		$lists['themelets'] = null;
	}
	if( count($lists['themelets'])  <= '1' ){
		echo '<tr class="other-themelet no-themelets"><td>There are no other themelets installed</td></tr>';
    }else{
    	foreach ($lists['themelets'] as $themelet){
			if( $themelet !== $params->get('themelet') ) {
				$themelet_uc = ucwords(str_replace('-', ' ', $themelet));
				$other_themelet_xml = $themelet_dir . DS . $themelet . DS . 'themeletDetails.xml';
				$other_themelet_params = xml2array($other_themelet_xml);
				$other_themelet_arr = $other_themelet_params['install'];
				echo '<tr class="other-themelet ' . $other_themelet_arr['foldername'].'">';
				echo '<td class="other-themelet-name label"><span class="sd-label-themelet" title="'. $themelet_url . $params->get('themelet').'/themelet_thumb.png">'.$themelet_uc.'</span></td>';
				echo '<td class="installed-version">'.$other_themelet_arr['version'].'</td>';
				echo '<td class="current-version">Not Available</td>';
				echo '<td class="status"><span class="activate-themelet"><a href="#" class="act-themelet" name="'.$themelet.'" title="Activate '.$themelet_uc.' Themelet">Activate Themelet</a></span><span class="delete-themelet"><a href="#" class="del-themelet" name="'.$themelet.'" title="Delete '.$themelet_uc.' Themelet">Delete Themelet</a></span></td>';
				echo '</tr>';
			}
    	}
    }
    ?>
	</tbody>
</table>