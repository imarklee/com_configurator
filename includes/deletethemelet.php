<?php
	$themeletname = $_GET['themelet'];
	function deleteThemelet($tn){
		$themeletdir = JPATH_SITE . DS . 'templates' . DS . 'morph' . DS . 'assets' . DS . 'themelets' . DS . $tn;
		if (is_dir($themeletdir)) {
			if(JFolder::delete($themeletdir)){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	deleteThemelet($themeletname);
?>