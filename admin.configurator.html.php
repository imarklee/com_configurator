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
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.fileupload.js');
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
					<div id="shelf" class="open">
						<?php include 'includes/shelf.php' ?>
					</div>
				
					<div class="clear spacer">&nbsp;</div>
		
					<div id="tabs">
						<ul class="primary">
							<li class="tab-general"><a href="#general"><strong>General Settings </strong>Everything under the hood</a></li>
							<li class="tab-block"><a href="#blocks"><strong>Block Settings </strong>Your sites building blocks</a></li>
							<li class="tab-tools"><a href="#tools"><strong>Morph's Tools </strong>Installer, backups &amp; more</a></li>
							<li class="tab-assets"><a href="#assets"><strong>Your Assets </strong>Themelets, logos, etc</a></li>
							<li class="tab-help last"><a href="#help"><strong>Help &amp; Support </strong>List of additional resources</a></li>
						</ul>
						
						<form action = "index.php" method = "post" name = "adminForm" id="templateform" enctype="multipart/form-data">
							<div id="general">
			
								<div id="subtabs">
									<ul class="ui-widget-header ui-corner-all ui-helper-clearfix">
										<li><a href="#start" class="ui-corner-left">Start</a></li>
										<li><a href="#logos">Logos</a></li>
										<li><a href="#backgrounds">Backgrounds</a></li>
										<li><a href="#colors">Colors</a></li>
										<li><a href="#menus">Menus</a></li>
										<li><a href="#progressive">Progressive Enhancements</a></li>
										<li><a href="#performance">Performance</a></li>
										<li><a href="#miscellaneous">Miscellaneous</a></li>
									</ul>
									<div id="start">
										<div id="general-options" class="options-panel">
											<h3>General Settings</h3>
											<ol class="forms">
											<?php echo renderParams($params->renderToArray('general','generaldata')); ?>
											</ol>
										</div>
										<div id="general-info" class="info-panel">
											<h4>What is a themelet?</h4>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>	
											
											<ul class="buttons">
												<li><a href="byblock.html" title="Visual Reference: By Block" class="modal-link ui-state-default">More about this feature</a></li>
												<li><a href="byblock.html" title="Visual Reference: By Block" class="modal-link fg-button">Online documentation</a></li>
											</ul>	
											<div class="clear">&nbsp;</div>
										</div>
									</div>
									<div id="logos" class="ui-tabs-hide">
										<h3>Logo Settings</h3>
										<ol class="forms">
										<?php echo renderParams($params->renderToArray('logo', 'logodata')); ?>
										</ol>
									</div>
									<div id="backgrounds" class="ui-tabs-hide">
										<h3>Background Settings</h3>
										<ol class="forms">
										<?php echo renderParams($params->renderToArray('background', 'backgrounddata')); ?>
										</ol>
									</div>
									<div id="colors" class="ui-tabs-hide">
										<h3>Color Settings</h3>
										<ol class="forms">
										<?php echo renderParams($params->renderToArray('color', 'colordata')); ?>
										</ol>
									</div>
									<div id="menus" class="ui-tabs-hide">
										<h3>Menu Settings</h3>
										<ol class="forms">
										<?php echo renderParams($params->renderToArray('menu', 'menudata')); ?>						
										</ol>
									</div>
									<div id="progressive" class="ui-tabs-hide">
										<h3>Progressive Enhancements</h3>
										<ol class="forms">
										<?php echo renderParams($params->renderToArray('progressive', 'progressivedata')); ?>
										</ol>
									</div>
									<div id="performance" class="ui-tabs-hide">
										<h3>Performance Settings</h3>
										<ol class="forms">
										<?php echo renderParams($params->renderToArray('performance', 'performancedata')); ?>
										</ol>
									</div>
									<div id="miscellaneous" class="ui-tabs-hide">
										<h3>Miscellaneous Settings</h3>
										<ol class="forms">
										<?php echo renderParams($params->renderToArray('advanced', 'advanceddata')); ?>
										</ol>
									</div>
								</div>
							
							</div>
							
							<div id="blocks" class="ui-tabs-hide">
								<div id="block-settings">
									<ul class="ui-widget-header ui-corner-all ui-helper-clearfix">
										<li><a href="#toolbar-block" class="ui-corner-left">Toolbar</a></li>
										<li><a href="#master-head-block">Master Head</a></li>
										<li><a href="#sub-head-block">Sub Head</a></li>
										<li><a href="#top-navigation-block">Top Navigation</a></li>
										<li><a href="#top-bottom-shelf-block">Top &amp; Bottom Shelf</a></li>
										<li><a href="#user1-2-block">User 1 &amp; User 2</a></li>
										<li><a href="#inset-block">Inset</a></li>
										<li><a href="#main-block">Main</a></li>
										<li><a href="#footer-block">Footer</a></li>
									</ul>
									<?php include 'includes/tabs/blocks-toolbar.php' ?>
									<?php include 'includes/tabs/blocks-masthead.php' ?>
									<?php include 'includes/tabs/blocks-subhead.php' ?>
									<?php include 'includes/tabs/blocks-topnav.php' ?>
									<?php include 'includes/tabs/blocks-shelves.php' ?>
									<?php include 'includes/tabs/blocks-ishelves.php' ?>
									<?php include 'includes/tabs/blocks-inset.php' ?>
									<?php include 'includes/tabs/blocks-main.php' ?>
									<?php include 'includes/tabs/blocks-footer.php' ?>
								</div>
							</div>
							
							<div id="tools" class="ui-tabs-hide">
								<div id="browse-tools">
									<ul class="ui-widget-header ui-corner-all ui-helper-clearfix">
										<li><a href="#tools-installer" class="ui-corner-left">Universal Installer</a></li>
										<li><a href="#tools-backups">Backups</a></li>
										<li><a href="#tools-profiles">Profiles</a></li>
									</ul>
									<div id="tools-installer">
										<?php include 'includes/tools/uploader.php' ?>
									</div>
									<div id="tools-backups" class="ui-tabs-hide">
										<?php include 'includes/tools/backups.php' ?>
									</div>
									<div id="tools-profiles" class="ui-tabs-hide">
										<?php include 'includes/tools/profiles.php' ?>
									</div>
								</div>
							</div>
							
							<div id="assets" class="ui-tabs-hide">
								<div id="browse-assets">
								
									<ul class="ui-widget-header ui-corner-all ui-helper-clearfix">
										<li><a href="#assets-themelets" class="ui-corner-left">Themelets</a></li>
										<li><a href="#assets-logos">Logos</a></li>
										<li><a href="#assets-backgrounds">Backgrounds</a></li>
										<li><a href="#assets-backups">Backups</a></li>
									</ul>				
									<div id="assets-themelets">
										<?php include 'includes/tabs/themelets.php' ?>
									</div>
									<div id="assets-logos" class="ui-tabs-hide">
										<?php include 'includes/tabs/logos.php' ?>						
									</div>
									<div id="assets-backgrounds" class="ui-tabs-hide">
										<?php include 'includes/tabs/backgrounds.php' ?>						
									</div>
									<div id="assets-backups" class="ui-tabs-hide">
										<?php include 'includes/tabs/backups.php' ?>						
									</div>						
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