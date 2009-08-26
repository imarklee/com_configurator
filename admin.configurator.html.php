<?php
defined('_JEXEC') or die('Restricted access');
include_once(JPATH_COMPONENT_ADMINISTRATOR . DS . 'includes' . DS .'HTML_configuratorhelper_admin.php');
include_once(JPATH_COMPONENT_ADMINISTRATOR . DS . 'includes' . DS . 'configurator.functions.php');

$document 	=& JFactory::getDocument();
$option 	= JRequest::getVar('option','com_configurator');
$task 		= JRequest::getCmd('task');

if(!isset($_COOKIE['unpack'])){
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/configurator.js.php');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/configurator.css.php');
}else{
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery-1.3.2.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery-ui-1.7.2.custom.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/cookie.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/preloadCssImages.jQuery_v5.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/colorpicker.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jqbrowser.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.corners.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.filestyle.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.qtip-1.0.0-rc3.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.fileupload.js');$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.autoresize.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.form.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.showpassword.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.getparams.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/configurator.functions.js.php');

$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/jquery.ui.css');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/colorpicker.css');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/reset.css');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/text.css');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/960.css');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/manage.css');
}

?>
<?php
class HTML_configurator_admin {

function manage( &$params, &$lists, $morph_installed, $pref_xml, $cfg_pref ) {
        global $mainframe;
        include_once (JPATH_COMPONENT_ADMINISTRATOR . DS . "configuration.php");
        $option = JRequest::getVar('option');
        
        JToolBarHelper::title( 'Configurator', 'configurator' );
        
        // preference cookies
        // auto updates
        if($cfg_pref->check_updates == 0 && !isset($_COOKIE['noupdates'])){
        	setcookie('noupdates', 'true');
        }else{
        	setcookie('noupdates', '', time()-3600);
        }
        // keyboard shortcuts
        if($cfg_pref->short_keys == 0 && !isset($_COOKIE['noshortkeys'])){
        	setcookie('noshortkey', 'true');
        }else{
        	setcookie('noshortkey', '', time()-3600);
        }
        
        if (!$morph_installed){
	        echo '<center>';
	        echo '<h1>Morph needs to be installed in order to work.</h1>';	
	        echo '<h3>Please, <a href="index.php?option=com_installer">Morph</a> before continue...</h3>';	
	        echo '</center>';	
	        //if found morph	
        } else {	
	        $template_dir = JPATH_SITE . DS . 'templates' . DS . 'morph';
	        $jVer 		= new JVersion();
			$jVer_curr  = $jVer->RELEASE.'.'.$jVer->DEV_LEVEL;
	        
	        // Show a specific template in editable mode.
	        if(isset($lists['err_messages'])) echo count($lists['err_messages'])?'<span style="color:#FFFFFF;background-color:#FF0000;font-weight:bold;">'.implode(',', $lists['err_messages']).'</span>':''; ?>
			
			<?php if(!isset($_COOKIE['am_logged_in']) && !isset($_COOKIE['am_logged_in_user'])){ ?>
				<div id="conf-login">
					<div id="cl-top">
					<img src="../administrator/components/com_configurator/images/morph-logo.png" alt="morph logo" width="173" height="60" border="0" />
					</div>
					<div id="cl-inner">
						<h2>Configurator for Morph</h2>
						<p>Please log in using your Joomla!Junkie Club Membership details. Not a member? <a href="http://www.joomlajunkie.com/secure" title="this link opens our subscription comparison page in a new window" target="_blank">Click here</a> to sign up!</p>
						<form id="am-login-form" method="post">
							<div id="alf-cont">
								<div id="alf-inp-cont">
								
									<label for="am-username" class="label-username"><span>Username:</span>
									<input type="text" class="alf-input" name="am-username" value="username" title="username" />
									</label>
									<label for="am-password" class="label-password"><span>Password:</span>
									<input type="password" id="loginpass" class="alf-input" name="am-password" value="password" title="password" />
									</label>
									
									<p class="login-sub">
										<label for="am-keep-login" class="login-checkbox">
											<input class="alf-check" type="checkbox" name="am-keep-login" id="am-keep-login" value="true" /> Remember me
										</label>
											
											&nbsp;&nbsp;|&nbsp;<label for="show-password" class="login-checkbox"><span class="sp-check"></span></label>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" id="lost-pass" title="">Forgot password?</a></p>
								</div>
								<input class="alf-login" type="submit" name="am-do-login" value="am-login-true" />
							</div>				
						</form>
						<div id="alf-warning"></div>
						<div id="alf-output"></div>
						<span class="mascot"></span>
					</div>
					<div id="alf-image">
						<div>
						<img src="../administrator/components/com_configurator/images/loader3.gif" height="16" width="16" border="0" align="center" alt="Loading" /> <span>Logging in..</span>
						</div>
					</div>
					<?php include 'includes/lost-password.php' ?>
				</div>
	        <?php }else{ ?>
	        
	        	<form action="index.php" method="post" name="adminForm" id="templateform" enctype="multipart/form-data">        	
	        	<div id="wrap" class="container_16<?php if($cfg_pref->shelf_position == 0){ ?> noshelf<?php } if($cfg_pref->shelf_position == 1){ ?> shelftop<?php } if($cfg_pref->shelf_position == 2){ ?> shelfbtm<?php } if($cfg_pref->show_footer == 0 ){ ?> nofooter<?php } if($cfg_pref->show_footer == 1 ){ ?> footer<?php } if($cfg_pref->show_branding == 0){ ?> nobranding<?php } if($cfg_pref->show_branding == 1){ ?> branding<?php } ?>">
	        		
	        		<?php if($cfg_pref->show_branding == 1){include_once('includes/top.php'); } ?>
					<?php if($cfg_pref->shelf_position == 1){include_once('includes/shelf.php'); } ?>
				
					<div class="clear spacer">&nbsp;</div>
		
					<div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
						<ul class="primary ui-tabs-nav ui-helper-reset ui-helper-clearfix">
							<li class="site-icon ui-tabs-selected"><a href="#site">General Settings</a></li>
							<li class="themelet-icon"><a href="#themelets">Customization</a></li>
							<li class="blocks-icon"><a href="#blocks">Building Blocks</a></li>
							<li class="tools-icon"><a href="#tools">Toolbox</a></li>
							<li class="assets-icon"><a href="#assets">Your Assets</a></li>
							<li class="help-icon last"><a href="#help">Help &amp; Support</a></li>
						</ul>
						<div id="site">					
							<div id="site-tabs" class="subtabs">
								<?php if ($cfg_pref->show_intros == 1) { include 'includes/tabs/desc/desc-site.php'; } ?>
								<ul class="ui-helper-clearfix ui-tabs-nav">
									<li class="icon-general ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a href="#general-tab">General</a></li>
									<li class="icon-progressive"><a href="#progressive-tab">Progressive Enhancements</a></li>
									<li class="icon-performance"><a href="#performance-tab">Performance Tuning</a></li>
									<li class="icon-debugging"><a href="#debugging-tab">Debugging</a></li>
								</ul>
								<?php include 'includes/tabs/general/general.php' ?>
								<?php include 'includes/tabs/general/progressive.php' ?>
								<?php include 'includes/tabs/general/performance.php' ?>
								<?php include 'includes/tabs/general/debugging.php' ?>
							</div>
						</div>

						<div id="themelets" class="ui-tabs-hide">
							<div id="themelet-tabs" class="subtabs">
								<?php if ($cfg_pref->show_intros == 1) { include 'includes/tabs/desc/desc-themelet.php'; } ?>
								<ul class="ui-helper-clearfix ui-tabs-nav">
									<li class="ui-tabs-selected icon-colors"><a href="#colors-tab">Color Settings</a></li>
									<li class="icon-logos"><a href="#logos-tab">Logo Settings</a></li>
									<li class="icon-backgrounds"><a href="#backgrounds-tab">Background Settings</a></li>
									<li class="icon-menus"><a href="#menus-tab">Menu Settings</a></li>
									<li class="icon-iphone"><a href="#iphone-tab">iPhone Compatibility</a></li>
								</ul>
								<?php include 'includes/tabs/themelet/colors.php' ?>
								<?php include 'includes/tabs/general/logos.php' ?>
								<?php include 'includes/tabs/themelet/backgrounds.php' ?>
								<?php include 'includes/tabs/themelet/menus.php' ?>
								<?php include 'includes/tabs/themelet/iphone.php' ?>
							</div>
						</div>

						<div id="blocks" class="ui-tabs-hide">
							<div id="blocks-tabs" class="subtabs">
								<?php if ($cfg_pref->show_intros == 1) { include 'includes/tabs/desc/desc-blocks.php'; } ?>
								<ul class="ui-helper-clearfix ui-tabs-nav">
									<li class="icon-toolbar ui-tabs-selected"><a href="#toolbar-tab">Toolbar</a></li>
									<li class="icon-mainhead"><a href="#mainhead-tab">Main Header</a></li>
									<li class="icon-subhead"><a href="#subhead-tab">Sub Header</a></li>
									<li class="icon-topnav"><a href="#topnav-tab">Top Menu</a></li>
									<li class="icon-oshelves"><a href="#outer-shelves-tab">Outer Shelves</a></li>
									<li class="icon-ishelves"><a href="#inner-shelves-tab">Inner Shelves</a></li>
									<li class="icon-main"><a href="#main-tab">Main Content</a></li>
									<li class="icon-sidebars"><a href="#outer-sidebar-tab">Outer Sidebar</a></li>
									<li class="icon-sidebars"><a href="#inner-sidebar-tab">Inner Sidebar</a></li>
									<li class="icon-insets"><a href="#insets-tab">Insets</a></li>
									<li class="icon-footer"><a href="#footer-tab">Footer</a></li>
								</ul>
								<?php include 'includes/tabs/blocks/toolbar.php' ?>
								<?php include 'includes/tabs/blocks/mainhead.php' ?>
								<?php include 'includes/tabs/blocks/subhead.php' ?>
								<?php include 'includes/tabs/blocks/topnav.php' ?>
								<?php include 'includes/tabs/blocks/outer-shelves.php' ?>
								<?php include 'includes/tabs/blocks/inner-shelves.php' ?>
								<?php include 'includes/tabs/blocks/inset.php' ?>
								<?php include 'includes/tabs/blocks/main.php' ?>
								<?php include 'includes/tabs/blocks/outer-sidebar.php' ?>
								<?php include 'includes/tabs/blocks/inner-sidebar.php' ?>
								<?php include 'includes/tabs/blocks/footer.php' ?>
							</div>
						</div>

						<div id="tools" class="ui-tabs-hide">
							<div id="tools-tabs" class="subtabs">
								<?php if ($cfg_pref->show_intros == 1) { include 'includes/tabs/desc/desc-tools.php'; } ?>
								<ul class="ui-helper-clearfix ui-tabs-nav">
									<li class="icon-installer ui-tabs-selected"><a href="#tools-installer">Universal Installer</a></li>
								</ul>
								<?php include 'includes/tabs/tools/uploader.php'; ?>
							</div>
						</div>

						<div id="assets" class="ui-tabs-hide">	
							<div id="assets-tabs" class="subtabs">
								<?php if ($cfg_pref->show_intros == 1) { include 'includes/tabs/desc/desc-assets.php'; } ?>
								<ul class="ui-helper-clearfix">
									<li class="icon-themelets"><a href="#assets-themelets">Themelets</a></li>
									<li class="icon-logos"><a href="#assets-logos">Logos</a></li>
									<li class="icon-backgrounds"><a href="#assets-backgrounds">Backgrounds</a></li>
								</ul>				
								<?php include 'includes/tabs/assets/themelets.php'; ?>
								<?php include 'includes/tabs/assets/logos.php'; ?>
								<?php include 'includes/tabs/assets/backgrounds.php'; ?>
							</div>
						</div>
							
						<div id="help" class="ui-tabs-hide off">
							<?php include 'includes/help.php'; ?>
						</div>
					</div>

					<div class="clear">&nbsp;</div>
					<?php if($cfg_pref->shelf_position == 2){include_once('includes/shelf.php'); } ?>
					<?php if($cfg_pref->show_footer == 1){include_once('includes/footer.php'); } ?>					
										
				</div>
				<input type="hidden" name="option" value="<?php echo $option; ?>"/>
			    <input type="hidden" name="t" value="morph"/>
				<input type="hidden" name="task" value="" />
				</form>
				
				
				<div id="getting-started" style="display:none;"></div>
				<div id="preferences-screen" style="display:none;">
					<?php include 'includes/preferences.php'; ?>
				</div>
				<div id="keyboard-screen" style="display:none;"></div>
				<div class="toolguides"></div>
<?php
			} ?>
			<?php include 'includes/report-bug.php';
	 	}      
    }
    function dashboard() {
        HTML_configuratorhelper_admin::showDash();
    }
}
?>