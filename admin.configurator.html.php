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
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery-ui-1.7.1.custom.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/cookie.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/colorpicker.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.corners.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.filestyle.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.qtip-1.0.0-rc3.min.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/jquery.fileupload.js');
$document->addScript(JURI::root() . 'administrator/components/com_configurator/js/configurator.functions.js.php');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/configurator.css');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/colorpicker.css');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_configurator/css/jquery-ui-1.7.1.custom.css');
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
        echo '<h1>Morph template was not found!</h1>';	
        echo '<h3>Please, <a href="index.php?option=com_installer">Morph</a> before continue...</h3>';	
        echo '</center>';	
        //if found morph	
        } else {	
        $template_dir = JPATH_SITE . DS . 'templates' . DS . 'morph';	
        //jimport('joomla.html.pane');

        // Show a specific template in editable mode.
        if(isset($lists['err_messages'])) echo count($lists['err_messages'])?'<span style="color:#FFFFFF;background-color:#FF0000;font-weight:bold;">'.implode(',', $lists['err_messages']).'</span>':'';
        ?>
        
        <?php if(!isset($_COOKIE['configurator_welcome'])){ ?>
        <div id="welcome-box">
        	<div id="wb-header">
        		<div id="wbh-left">
        			<h2>Getting Started with Morph &amp; Configurator</h2>
        		</div>
        		<div id="wbh-right">
        			<a href="#" class="wbh-hide-show">hide</a> | 
        			<a href="#" class="wbh-close">close x</a>
        		</div>
        	</div>
        	<div id="wb-content">
        		<div id="wbc-col1">
        			<h3>Visual Reference Maps</h3>
        			<p>There are two visual references to show how Morph's different "blocks" and the various module positions that you have available in each.</p>
        			<p class="buttons"><a href="../administrator/components/com_configurator/images/visual-reference-positions.png" class="btn" onclick="return false"><span>By Position</span></a> <a href="../administrator/components/com_configurator/images/visual-reference-blocks.png" class="btn" onclick="return false"><span>By Block</span></a></p>
        			<small>* There are links to these in the Help tab.</small>
        		</div>
        		<div id="wbc-col2">
        			<h3>Inline Help - Every Step of the way</h3>
        			<p>We have tried to make the config options as easy to use
        			and undersand as possible, but some of the concepts &amp; terminology
        			are new and require reading the inline help to properly
        			understand them.</p>
        			<h3>Look for these icons to get contextual help:</h3>
        			<ul class="infobuttons">
        				<li class="helpicon">The help icon indicates that there is an inline guide available.</li>
        				<li class="infoicon">The info icon indicates that there is a tooltip description available.</li>
        			</ul>
        		</div>
        		<div id="wbc-col3">
        			<h3>What to do if you get stuck</h3>
        			<p>If you are not able to find the answer to your question in the inline help,
        			the next step is to.</p>
        			<ul>
						<li>Check the <a href="http://www.joomlajunkie.com/morph/documentation">Online Documentation</a>.</li>
        				<li>Post on our <a href="http://www.joomlajunkie.com/member">Support Forum</a>.</li>
        				<li><a href="#">Report a bug</a> in our <a href="#">Issue Tracker</a>.</li>
					</ul>
        		</div>
        	</div>
         	<div id="wb-footer">&nbsp;</div>
        </div>
        <?php } ?>        
           
        <div id="configurator-wrap">
        	<form action = "index.php" method = "post" name = "adminForm" id="templateform" enctype="multipart/form-data">   
            <div id="accordion">
            	<h3 class="general-settings"><span class="ui-icon ui-gen-settings"></span> <a href="#">General Settings</a></h3>
				<div class="themelet-options"><?php echo renderParams($params->renderToArray('general','generaldata')); ?></div>
					
				<h3 class="general-settings"><span class="ui-icon ui-logo-settings"></span> <a href="#">Logo Settings</a></h3>
				<div class="themelet-options ui-main-tabs-hide"><?php echo renderParams($params->renderToArray('logo', 'logodata')); ?></div>
				
				<h3 class="general-settings"><span class="ui-icon ui-bg-settings"></span> <a href="#">Background Settings</a></h3>
				<div class="themelet-options ui-main-tabs-hide"><?php echo renderParams($params->renderToArray('background', 'backgrounddata')); ?></div>
				
				<h3 class="general-settings"><span class="ui-icon ui-color-settings"></span> <a href="#">Color Settings</a></h3>
				<div class="themelet-options ui-main-tabs-hide"><?php echo renderParams($params->renderToArray('color', 'colordata')); ?></div>
				
				<h3 class="general-settings"><span class="ui-icon ui-prog-settings"></span> <a href="#">Progressive Enhancements</a></h3>
				<div class="themelet-options ui-main-tabs-hide"><?php echo renderParams($params->renderToArray('progressive', 'progressivedata')); ?></div>
				
				<h3 class="general-settings"><span class="ui-icon ui-menu-settings"></span> <a href="#">Menu Settings</a></h3>
				<div class="themelet-options ui-main-tabs-hide"><?php echo renderParams($params->renderToArray('menu', 'menudata')); ?></div>						

				<h3 class="general-settings"><span class="ui-icon ui-per-settings"></span> <a href="#">Performance Settings</a></h3>
				<div class="themelet-options ui-main-tabs-hide"><?php echo renderParams($params->renderToArray('performance', 'performancedata')); ?></div>
				
				<h3 class="general-settings"><span class="ui-icon ui-adv-settings"></span> <a href="#">Miscellaneous Settings</a></h3>
				<div class="themelet-options ui-main-tabs-hide"><?php echo renderParams($params->renderToArray('advanced', 'advanceddata')); ?></div>

				<h3><span class="ui-icon ui-tool-settings"></span> <a href="#">Toolbar Block</a></h3>
				<div class="themelet-options ui-main-tabs-hide"><?php echo renderParams($params->renderToArray('toolbar', 'toolbardata')); ?></div>
				
				<h3><span class="ui-icon ui-main-settings"></span> <a href="#">Master Head Block</a></h3>
				<div class="themelet-options ui-main-tabs-hide"><?php echo renderParams($params->renderToArray('masterhead', 'masterheaddata')); ?></div>
				
				<h3><span class="ui-icon ui-sub-settings"></span> <a href="#">Sub Head Block</a></h3>
				<div class="themelet-options ui-main-tabs-hide"><?php echo renderParams($params->renderToArray('subhead', 'subheaddata')); ?></div>

				<h3><span class="ui-icon ui-sub-settings"></span> <a href="#">Top Navigation Block</a></h3>
				<div class="themelet-options ui-main-tabs-hide"><?php echo renderParams($params->renderToArray('topnav', 'topnavdata')); ?></div>
								
				<h3><span class="ui-icon ui-tbshelf-settings"></span> <a href="#">Top &amp; Bottom Shelf Blocks</a></h3>
				<div class="themelet-options ui-main-tabs-hide"><?php echo renderParams($params->renderToArray('shelves', 'shelvesdata')); ?></div>
				
				<h3><span class="ui-icon ui-us12-settings"></span> <a href="#">User 1 &amp; User 2 Block</a></h3>
				<div class="themelet-options ui-main-tabs-hide"><?php echo renderParams($params->renderToArray('inlineshelves', 'inlineshelvesdata')); ?></div>
				
				<h3><span class="ui-icon ui-ins14-settings"></span> <a href="#">Inset Blocks</a></h3>
				<div class="themelet-options ui-main-tabs-hide"><?php echo renderParams($params->renderToArray('insets', 'insetsdata')); ?></div>

				<h3><span class="ui-icon ui-main-settings"></span> <a href="#">Main Block</a></h3>
				<div class="themelet-options ui-main-tabs-hide"><?php echo renderParams($params->renderToArray('main', 'maindata')); ?></div>
				
				<h3><span class="ui-icon ui-foot-settings"></span> <a href="#">Footer Settings</a></h3>
				<div class="themelet-options ui-main-tabs-hide"><?php echo renderParams($params->renderToArray('footer', 'footerdata')); ?></div>
            </div>
			<div id="tabs">
				<ul class="ui-tabs-nav">
				   	<li class="ui-tabs-nav-item ui-tabs-selected"><a href="#summary" class="tabs-sum-icon" onclick="return false;">Summary</a></li>
				    <li class="ui-tabs-nav-item"><a class="tabs-ins-icon" href="#installer" onclick="return false;">Installer</a></li>
				    <li class="ui-tabs-nav-item"><a href="#backup" class="tabs-bac-icon" onclick="return false;">Backups</a></li>
				    <li class="ui-tabs-nav-item"><a href="#helptab" class="tabs-help-icon" onclick="return false;">Help &amp; Support</a></li>
				</ul>
				<div id="summary" class="ui-tabs-panel">
					<?php include_once("../administrator/components/com_configurator/includes/tabs/summarytab.php"); ?>
					<?php
					if(isset($_GET['do']) && $_GET['do'] == 'delete'){
    					include_once('../administrator/components/com_configurator/includes/deletethemelet.php');
    				}
    				?>
				</div>
				<div id="installer" class="ui-main-tabs-panel ui-main-tabs-hide">
          			<?php include_once("../administrator/components/com_configurator/includes/tabs/installertab.php"); ?>	
				</div>
				<div id="backup" class="ui-tabs-panel ui-tabs-hide">
					<?php include_once("../administrator/components/com_configurator/includes/tabs/backuptab.php"); ?>
				</div>
				<div id="helptab" class="ui-tabs-panel ui-tabs-hide">
					<?php include_once("../administrator/components/com_configurator/includes/tabs/helptab.php"); ?>
				</div>
				
				<div id="changes-dialog" style="display:none;">
					<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
					<span class="error-text">You have made changes in your settings. Would you like to apply these settings?</span></p>
				</div>
				
            </div>		
			<?php include_once("../administrator/components/com_configurator/includes/ptcredits.php"); ?>	

            <input type = "hidden" name = "option" value = "<?php echo $option; ?>"/>
            <input type = "hidden" name = "t" value = "morph"/>
            <input type = "hidden" name = "task" value = "list" />
        </form>
        </div>
        
<?php }      
    }
    function dashboard() {
        HTML_configuratorhelper_admin::showDash();
    }
}
?>