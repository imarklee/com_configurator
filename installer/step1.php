<?php 
if(strpos($_SERVER['SCRIPT_NAME'], 'install.configurator.php') === false){
$base = './components/com_configurator';
}else{
$base = '.';
}
define('JURL', $base);
?>
<form id="install-template" class="step1" method="post" action="index.php?option=com_configurator&task=installTemplate&format=raw&backup=false" enctype="multipart/form-data">
	<div id="install-head">
		<img src="<?php echo JURL; ?>/installer/images/install-logo.png" alt="morph logo" width="160" height="60" border="0" class="logo" />
		<img src="<?php echo JURL; ?>/installer/images/tagline.png" alt="morph tagline" width="195" height="24" border="0" class="tagline" />
		<p class="steps"><strong>Step 1 of 3: </strong>Install &amp; publish Morph</p>
	</div>
		
	<div id="install-shadow">
		<div id="install-main">	
			<div id="install-title">
				<h2><strong>Step 1: </strong>Install &amp; publish Morph</h2>
				<a href="#" class="help-step1">Help with this step</a>
			</div>
			
			<div id="install-body">
				<h3>In this step, you will install and publish the Morph template.</h3>
				<p>If you already have a copy of Morph installed, you can choose to have a backup automatically created for you or skip this step completely.</p>
				
				<label class="upload"><h4>Select the template framework install file:</h4>
				<input type="file" name="template-file" id="template-file" /></label>
				
				<label class="backup"><input type="checkbox" name="backup_template" id="backup_template" checked="checked" value="true" />
				Backup your existing copy of Morph?</label>
				<span class="mascot">&nbsp;</span>
				
				<!--<a id="upload-info" href="#" title="click here for more info">&nbsp;</a>-->
				
			</div>
				
			<div id="install-foot">
				<ul id="action">
					<li class="next"><input class="action install-template btn-install" type="submit" value="submit" /></li>
					<li class="previous"><span>&laquo; </span>Previous step</li>
					<li class="skip"><a href="#" class="btn-skip skip-step1">Skip this step<span> &raquo;</span></a></li>
				</ul>
			</div>
		</div>	
	</div>	
</form>