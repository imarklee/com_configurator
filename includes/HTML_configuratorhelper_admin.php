<?php
/**
* @package   Configurator Component
* @author    Prothemer http://www.prothemer.com
* @copyright Copyright (C) 2008 - 2010 Web Monkeys Design Studio CC.
* @license   http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @desc      Originally based on Tatami from Ninja Forge. http://www.ninjaforge.com
*/

defined('_JEXEC') or die('Restricted access');

class HTML_configuratorhelper_admin {
    
    function showHeader($actType='dashboard') {
        global $mainframe;
        $option = JRequest::getVar('option');
   	} // end showHeader
  
  
    function showFooter() {
    	$option = JRequest::getVar('option');
   		echo'</div></div>';
	  	echo '<div class="nfFooter">';
  	
		//Explode our button list parameter into an array so we can check the values inside it.
		$buttonArray = explode(',',_HLPR_BUTTONS);
		
		//Count the array so we know how many times to loop
		$loopCount = count($buttonArray);
			 	
		for ($i=0; $i<$loopCount; $i++) {
			switch (trim($buttonArray[$i])) {
				case 'css':  break;
				case 'xhtml': break;		
			   	case 'lgpl': break;
		   		case 'gpl': break; 
			}
		}
	} // end showFooter
    
	function showDash() {
		$option = JRequest::getVar('option','com_configurator');
		$task = JRequest::getCmd('task');
	
	?>
	<style type="text/css">
	#content-box #element-box .m{background:#fff!important;}
	</style>
	
	<div id="dashboard">
	<h1>Configurators Dashboard is under construction ;)</h1>
	<p>We plan on updating configurator to have a really slick dashboard, but this is on the backburner until both Morph &amp; Configurator are 100% stable.</p>
	<p class="config-morph"><a href="index.php?option=com_configurator&view=configuration" title="Configure Morph">Configure Morph</a></p>
	</div>
	<?php   
	}
   
	function showButs($butInfo) {     
		$option = JRequest::getVar('option');
		for ($i=0; $i<count($butInfo); $i++) {
		?>
		<div class="infoPgBut">
			<a class="infoPgButA" href="index2.php?option=<?php echo $option; ?>&task=<?=$butInfo[$i][0]?>">
				<img class="infoPgButImg" src="<?php echo JURI::root();?>administrator/components/<?php echo $option; ?>/images/<?=$butInfo[$i][1]?>"/>
				<span class="infoPgButSpan"><?=$butInfo[$i][2]?></span>
			</a>
		</div>
		<?php
		}
	}	
}