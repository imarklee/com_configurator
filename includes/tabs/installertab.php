<?php
	$themelet_url = JURI::root() . '/templates/morph/assets/themelets/';
	$favicon_url = JURI::root() . '/templates/morph/assets/favicons/';
	$logo_url = JURI::root() . '/templates/morph/assets/logos/';
	$background_url = JURI::root() . '/templates/morph/assets/backgrounds/';
	$template_dir = JPATH_SITE . DS . 'templates' . DS . 'morph';
?>
<h4>What would you like to install?</h4>
<p>Select the type of file you would like to install below. Once you have installed your chosen file type, open the "customization settings" tab on the left. All of these files (including backups) are located in your template's "assets" folder. <a href="#docslink">Click here</a> to read more about how to best utilize this feature.</p>

<div id="installer-tabs">
	<ul class="ui-ins-tabs-nav">
		<li class="ui-ins-tabs-nav-item ui-ins-tabs-selected"><a href="#installer-themelet" class="tabs-install-themelet-icon" onclick="return false;">Themelet</a></li>
		<li class="ui-ins-tabs-nav-item"><a href="#installer-logo" class="tabs-install-logo-icon" onclick="return false;">Logo</a></li>
		<li class="ui-ins-tabs-nav-item"><a href="#installer-favicon" class="tabs-install-favicon-icon" onclick="return false;">Favicon</a></li>
		<li class="ui-ins-tabs-nav-item"><a href="#installer-bg" class="tabs-install-bg-icon" onclick="return false;">Background</a></li>
	</ul>
	<div id="installer-themelet" class="ui-ins-tabs-panel">
		<?php 
		if( isset($lists['themelets_dir']) ) {
        	if(is_writable($lists['themelets_dir']) || is_writable($template_dir)) { ?>
				<input class="input-installer" type="file" name="themeletfile" id="themeletfile" /><br />
				<p><input type="checkbox" value="do_backup" name="themeletbackup" /><span>Backup your existing themelet's settings?</span></p>
				<input type="button" class="button-themelet" value="Upload Themelet" />
			<?php
        	} else { ?>
        		<p>The themelets directory (shown below) is not writeable or does not exist.
        		<br />Themelets functions disabled.<br />
        		<strong><?php echo $lists['themelets_dir']; ?></strong>
        		</p>
        	<?php 
        	}
    	}
    	?>
	</div>
	<div id="installer-logo" class="ui-ins-tabs-panel">
		<?php 
		if( isset($lists['logo_dir']) ) {
	    	if(is_writable($lists['logo_dir']) || is_writable($template_dir)) { ?>
				<input class="input-installer" type="file" name="logofile" id="logofile" /><br />
				<input type="button" class="button-logo" value="Upload Logo" />
			<?php
	    	} else { ?>
	    		<p>The logo directory (shown below) is not writeable or does not exist.
	    		<br />Logo functions disabled.<br />
	    		<strong><?php echo $lists['logo_dir']; ?></strong>
	    		</p>
	    	<?php 
	    	}
		}
		?>
	</div>
	<div id="installer-favicon" class="ui-ins-tabs-panel">					
		<?php 
		if( isset($lists['favicons_dir']) ) {
	    	if(is_writable($lists['favicons_dir']) || is_writable($template_dir)) { ?>
				<input class="input-installer" type="file" name="faviconfile" id="faviconfile" /><br />
				<input type="button" class="button-favicon" value="Upload Favicon" />
			<?php
	    	} else { ?>
	    		<p>The favicon directory (shown below) is not writeable or does not exist.
	    		<br />Favicon functions disabled.<br />
	    		<strong><?php echo $lists['favicons_dir']; ?></strong>
	    		</p>
	    	<?php 
	    	}
		}
		?>
	</div>
	<div id="installer-bg" class="ui-ins-tabs-panel">
		<?php 
		if( isset($lists['bg_dir']) ) {
        	if(is_writable($lists['bg_dir']) || is_writable($template_dir)) { ?>
				<input class="input-installer" type="file" name="bgfile" id="bgfile" /><br />
				<input type="button" class="button-background" value="Upload background" />
			<?php
        	} else { ?>
        		<p>The themelets directory (shown below) is not writeable or does not exist.
        		<br />Themelets functions disabled.<br />
        		<strong><?php echo $lists['bg_dir']; ?></strong>
        		</p>
        	<?php 
        	}
    	}
    	?>
	</div>
</div>	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	