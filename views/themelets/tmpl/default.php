<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined('_JEXEC') or die('Restricted access');

$themelet_dir = JPATH_ROOT.'/morph_assets/themelets';
$themelet_url = JURI::root().'morph_assets/themelets/';
if(is_dir($themelet_dir)) {
	$lists['themelets'] = JFolder::folders( $themelet_dir );
} else {
	$lists['themelets'] = 'test';
}
$ct = JTable::getInstance('ConfiguratorTemplateSettings', 'Table')->param('themelet')->getItem()->value;
?>
<div id="assets-themelets">
	<div id="themelet-switch" class="switch">
		<h2>Manage your assets: <strong>Themelets</strong></h2>
		<p><a href="#" class="themelet-tab btn-link">Customize themelet</a>&nbsp;&nbsp;<a href="#" class="upload-themelet btn-link">Upload a new themelet</a>&nbsp;&nbsp;<a href="#" class="switch-view">Switch View</a></p>
	</div>
	
	<div id="themelets-list" class="assets-layout <?php if(isset($_COOKIE['themelets-view']) && $_COOKIE['themelets-view'] == 'list') { echo 'list-view'; } else { setcookie('themelets_view', 'thumb',60*60*24*30, '/'); echo 'thumb-view'; } ?>">
		<?php if(!empty($lists['themelets'])){ ?>
		<ul id="themelets-headers" class="assets-headers">
			<li class="th-name">Themelet Name</li>
			<li class="th-installed">Installed Version</li>
			<li class="th-current">Current Version</li>
			<li class="th-date">Date Added</li>
			<li class="th-activate">Activate</li>
			<li class="th-delete">Delete</li>
			<li class="th-preview">Preview</li>
		</ul>
		
		<ul class="assets-list">
			<?php
	    	foreach ($lists['themelets'] as $themelet){
	    		$themelet_uc = ucwords(str_replace('-', ' ', $themelet));
				$themelet_xml = $themelet_dir.'/'.$themelet.'/themeletDetails.xml';
				$themelet_arr = (array) simplexml_load_file($themelet_xml);
				if(isset($_COOKIE['us_'.$themelet_arr['foldername']])){ 
					$cookie_val = split('##', $_COOKIE['us_'.$themelet_arr['foldername']]); 
					$us_version = $cookie_val[0];
					$us_updated = $cookie_val[1];
				}else{
					$us_version = '';
					$us_updated = '';
				}
				if( $themelet !== $ct ) { $themelet_class = 'tl-inactive'; } else { $themelet_class = 'tl-active'; }
			?>	
				
			<li class="themelet-item <?php echo $themelet_class; ?>">
				<div class="assets-inner">
					<h3><?php echo $themelet_uc; ?><span class="update-link"> (<a href="#">Download Update</a>)</span></h3>
					<img src="<?php echo $themelet_url . $themelet.'/themelet_thumb.png'; ?>" width="197" height="133" border="0" alt="themelet thumbnail" />
					<ul name="<?php echo $themelet_arr['foldername']; ?>" type="assets" class="themelet-summary assets-summary">
						<li type="current" class="tl-installed"><strong>Installed version: </strong><span><?php echo $themelet_arr['version']; ?></span></li>
						<li type="latest" class="tl-current"><strong>Current version: </strong><span></span></li>
						<li type="updated" class="tl-date"><strong>Last update: </strong><span></span></li>
					</ul>
					<h4>Options for this file:</h4>
					<ul class="buttons">
						<li class="btn-activate"><a name="<?php echo $themelet_arr['foldername']; ?>" href="#" title="Activate <?php echo $themelet_uc; ?>"><span>Activate</span></a></li>
						<li class="btn-delete"><a name="<?php echo $themelet_arr['foldername']; ?>" href="#" title="Delete <?php echo $themelet_uc; ?>"><span>Delete</span></a></li>
						<li class="btn-preview"><a href="<?php echo $themelet_url . $themelet.'/themelet_thumb.png'; ?>" title="Preview <?php echo $themelet_uc; ?>"><span>Preview</span></a></li>
						<li class="btn-update"><a href="#" target="_blank" title="Download update"><span>Update</span></a></li>
					</ul>
				</div>
			</li>	
			<?php }	
			} else { ?>
				<div class="no-assets">
					There are currently no themelets in your assets folder. <a href="#" class="upload-themelet">Upload a themelet?</a>
				</div>
			<?php }	?>
		</ul>
	</div>
</div>