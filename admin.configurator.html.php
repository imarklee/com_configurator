<?php
defined('_JEXEC') or die('Restricted access');
include_once(JPATH_COMPONENT_ADMINISTRATOR . DS . 'includes' . DS .'HTML_configuratorhelper_admin.php');
include_once(JPATH_COMPONENT_ADMINISTRATOR . DS . 'includes' . DS . 'configurator.functions.php');

$document 	=& JFactory::getDocument();
$option 	= JRequest::getVar('option','com_configurator');
$task 		= JRequest::getCmd('task');

if(isset($_COOKIE['pack'])){
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/configurator.js.php');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/configurator.css.php');
}else{
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery-1.3.2.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery-ui-1.7.2.custom.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/cookie.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/colorpicker.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jqbrowser.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.corners.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.filestyle.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.qtip-1.0.0-rc3.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.fileupload.js');$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.autoresize.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/configurator.functions.js.php');

$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/jquery-ui-1.7.2.custom.css');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/colorpicker.css');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/reset.css');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/text.css');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/960.css');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/manage.css');

}
?>
<?php
class HTML_configurator_admin {

function manage( &$params, &$lists, $morph_installed ) {
        global $mainframe;
        include_once (JPATH_COMPONENT_ADMINISTRATOR . DS . "configuration.php");
        $option = JRequest::getVar('option');
   
        JToolBarHelper::title( 'Configurator', 'configurator' );
        JToolBarHelper::save('savetemplate');
        JToolBarHelper::apply('applytemplate');
        JToolBarHelper::cancel('dashboard');
        
        if (!$morph_installed){
	        echo '<center>';
	        echo '<h1>It seems that Morph has not yet been installed.</h1>';	
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
					<div id="cl-inner">
						<h2>Configurator for Morph</h2>
						<p>Please log in using your Joomla!Junkie Club Membership details</p>
						<form id="am-login-form" method="post">
							<div id="alf-cont">
								<div id="alf-inp-cont">
									<input type="text" class="alf-input" name="am-username" value="username" title="username" />
									<input type="password" class="alf-input" name="am-password" value="password" title="password" />
									<input class="alf-check" type="checkbox" name="am-keep-login" value="true" />
									<label for="am-keep-login">Keep me logged in</label>
								</div>
								<input class="alf-login" type="button" name="am-do-login" value="am-login-true" />
							</div>				
						</form>
						<div id="alf-warning"></div>
						<div id="alf-output"></div>
					</div>
					<div id="alf-image">
						<img src="../administrator/components/com_configurator/images/ajax-loader-dark.gif" height="31" width="31" border="1" alt="Loading" />
					</div>
				</div>
	        <?php }else{ ?>
	        	
	        	<div id="wrap" class="container_16">
					<div id="shelf" class="<?php if(!isset($_COOKIE['shelf']) || $_COOKIE['shelf'] == 'show'){ echo 'open'; }else{ echo 'closed'; } ?>">
						<?php include 'includes/shelf.php' ?>
					</div>
				
					<div class="clear spacer">&nbsp;</div>
		
					<div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
						<!--<ul class="primary">
							<li class="tab-general"><a href="#general"><strong>General Settings </strong>Everything under the hood</a></li>
							<li class="tab-block"><a href="#blocks"><strong>Block Settings </strong>Your sites building blocks</a></li>
							<li class="tab-tools"><a href="#tools"><strong>Morph's Tools </strong>Installer, backups &amp; more</a></li>
							<li class="tab-assets"><a href="#assets"><strong>Your Assets </strong>Themelets, logos, etc</a></li>
							<li class="tab-help last"><a href="#help"><strong>Help &amp; Support </strong>List of additional resources</a></li>
						</ul>-->
						<ul class="primary ui-tabs-nav ui-helper-reset ui-helper-clearfix">
							<li class="site-icon ui-tabs-selected"><a href="#site">Site Settings</a></li>
							<li class="themelet-icon"><a href="#themelets">Themelet Settings</a></li>
							<li class="blocks-icon"><a href="#blocks">Block Settings</a></li>
							<li class="tools-icon"><a href="#tools">Morph Tools</a></li>
							<li class="assets-icon"><a href="#assets">Your Assets</a></li>
							<li class="help-icon last"><a href="#help">Help &amp; Support</a></li>
						</ul>		
						<form action = "index.php" method = "post" name = "adminForm" id="templateform" enctype="multipart/form-data">
							
							<div id="site">					
								<div id="site-tabs" class="subtabs">
									<?php if (!isset ($_COOKIE['site-desc'])) { include 'includes/tabs/desc/desc-site.php'; } ?>
									<ul class="ui-helper-clearfix ui-tabs-nav">
										<li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a href="#general-tab">General</a></li>
										<li><a href="#logos-tab">Logos</a></li>
										<li><a href="#progressive-tab">Progressive Enhancements</a></li>
										<li><a href="#performance-tab">Performance</a></li>
										<li><a href="#debugging-tab">Debugging</a></li>
										<li><a href="#miscellaneous-tab">Miscellaneous</a></li>
									</ul>
									<?php include 'includes/tabs/general/general.php' ?>
									<?php include 'includes/tabs/general/logos.php' ?>
									<?php include 'includes/tabs/general/progressive.php' ?>
									<?php include 'includes/tabs/general/performance.php' ?>
									<?php include 'includes/tabs/general/debugging.php' ?>
									<?php include 'includes/tabs/general/miscellaneous.php' ?>
								</div>
							</div>
							
							<div id="themelets" class="ui-tabs-hide">
								<div id="themelet-tabs" class="subtabs">
									<?php if (!isset ($_COOKIE['themelet-desc'])) { include 'includes/tabs/desc/desc-themelet.php'; } ?>
									<ul class="ui-helper-clearfix ui-tabs-nav">
										<li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a href="#colors-tab">Colors</a></li>
										<li><a href="#backgrounds-tab">Backgrounds</a></li>
										<li><a href="#menus-tab">Menus</a></li>
									</ul>
									<?php include 'includes/tabs/themelet/colors.php' ?>
									<?php include 'includes/tabs/themelet/backgrounds.php' ?>
									<?php include 'includes/tabs/themelet/menus.php' ?>
								</div>
							</div>
							
							<div id="blocks" class="ui-tabs-hide">
								<div id="blocks-tabs" class="subtabs">
									<?php if (!isset ($_COOKIE['blocks-desc'])) { include 'includes/tabs/desc/desc-blocks.php'; } ?>
									<ul class="ui-helper-clearfix ui-tabs-nav">
										<li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a href="#toolbar-tab">Toolbar</a></li>
										<li><a href="#masthead-tab">Master Header</a></li>
										<li><a href="#subhead-tab">Sub Header</a></li>
										<li><a href="#topnav-tab">Top Navigation</a></li>
										<li><a href="#shelves-tab">Outer Shelves</a></li>
										<li><a href="#user-tab">Inline Shelves</a></li>
										<li><a href="#insets-tab">Insets</a></li>
										<li><a href="#main-tab">Main</a></li>
										<li><a href="#footer-tab">Footer</a></li>
									</ul>
									<?php include 'includes/tabs/blocks/toolbar.php' ?>
									<?php include 'includes/tabs/blocks/masthead.php' ?>
									<?php include 'includes/tabs/blocks/subhead.php' ?>
									<?php include 'includes/tabs/blocks/topnav.php' ?>
									<?php include 'includes/tabs/blocks/shelves.php' ?>
									<?php include 'includes/tabs/blocks/ishelves.php' ?>
									<?php include 'includes/tabs/blocks/inset.php' ?>
									<?php include 'includes/tabs/blocks/main.php' ?>
									<?php include 'includes/tabs/blocks/footer.php' ?>
								</div>
							</div>
							
							<div id="tools" class="ui-tabs-hide">
								<div id="tools-tabs" class="subtabs">
									<?php if (!isset ($_COOKIE['tools-desc'])) { include 'includes/tabs/desc/desc-tools.php'; } ?>
									<ul class="ui-helper-clearfix ui-tabs-nav">
										<li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a href="#tools-installer" class="ui-corner-left">Universal Installer</a></li>
									</ul>
									<?php include 'includes/tabs/tools/uploader.php' ?>
								</div>
							</div>
							
							<div id="assets" class="ui-tabs-hide">	
								<div id="assets-tabs" class="subtabs">
									<?php if (!isset ($_COOKIE['assets-desc'])) { include 'includes/tabs/desc/desc-assets.php'; } ?>
									<ul class="ui-widget-header ui-corner-all ui-helper-clearfix">
										<li><a href="#assets-themelets" class="ui-corner-left">Themelets</a></li>
										<li><a href="#assets-logos">Logos</a></li>
										<li><a href="#assets-backgrounds">Backgrounds</a></li>
									</ul>				
									<?php include 'includes/tabs/assets/themelets.php' ?>
									<?php include 'includes/tabs/assets/logos.php' ?>
									<?php include 'includes/tabs/assets/backgrounds.php' ?>
								</div>
							</div>
							
							<div id="help" class="ui-tabs-hide">
								<?php include 'includes/help.php' ?>
							</div>
						</div>
						<input type = "hidden" name = "option" value = "<?php echo $option; ?>"/>
			            <input type = "hidden" name = "t" value = "morph"/>
			            <input type = "hidden" name = "task" value = "list" />
			        </form>
						
					<div class="clear">&nbsp;</div>
					<?php include 'includes/footer.php' ?>
				</div>
				<?php include 'includes/report-bug.php' ?>
<?php
			}
	 	}      
    }
    function dashboard() {
        HTML_configuratorhelper_admin::showDash();
    }
}
?>