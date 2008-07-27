<?php 
if(strpos($_SERVER['SCRIPT_NAME'], 'install.configurator.php') === false){
$base = './components/com_configurator';
}else{
$base = '.';
}
define('JURL', $base);
function summaryclass($cookie){
	if(isset($_COOKIE[$cookie])){
		$class = ' class="tick-on"';
	}else{
		$class = ' class="tick-off"';
	}
	return $class;
}
?>
<div id="install-head">
	<img src="<?php echo JURL; ?>/installer/images/install-logo.png" alt="morph logo" width="160" height="60" border="0" class="logo" />
	<img src="<?php echo JURL; ?>/installer/images/tagline.png" alt="morph tagline" width="195" height="24" border="0" class="tagline" />
	<p class="steps"><strong>Installation Complete </strong>Everything installed successfully</p>
</div>
<div id="install-shadow">
<div id="install-main">	
	<div id="install-title">
		<h2>Installation complete!</h2>
	</div>
	<div id="install-body" class="complete">
		<h3>Congratulations! Your installation was successful!</h3>
		<p>Want to get up and running quickly? Grab a cup of coffee and read through the "<strong>Getting started with Morph &amp; Configurator</strong>" help window that is displayed the first time you load Configurator.</p>	
		<h4>Summary of what has been done:</h4>
		<ul id="install-summary">
			<li<?php echo summaryclass('installed_cfg'); ?>>Installed Morph's Configurator component</li>
			<li<?php echo summaryclass('installed_bkpmorph'); ?>>Created backup of existing version of the Morph template</li>
			<li<?php echo summaryclass('installed_morph'); ?>>Installed new version of the Morph template</li>
			<li<?php echo summaryclass('installed_pubmorph'); ?>>Published new version of the Morph template</li>
			<li<?php echo summaryclass('installed_themelet'); ?>>Installed<?php if(isset($_COOKIE['ins_themelet_name'])) { echo ' '.ucwords($_COOKIE['ins_themelet_name']).' '; }else{ echo ' '; } ?>themelet</li>
			<li<?php echo summaryclass('installed_actthemelet'); ?>>Activated<?php if(isset($_COOKIE['ins_themelet_name'])) { echo ' '.ucwords($_COOKIE['ins_themelet_name']).' '; }else{ echo ' '; } ?>themelet</li>
			<li<?php echo summaryclass('installed_bkpdb'); ?>>Created full backup of your site's database</li>
			<li<?php echo summaryclass('installed_gzip'); ?>>Enabled GZIP compression</li>
			<li<?php echo summaryclass('installed_samplecont'); ?>>Loaded sample content</li>
			<li<?php echo summaryclass('installed_samplemods'); ?>>Loaded sample modules</li>
		</ul>
	</div>
	<div id="install-foot">
		<ul id="action">
			<li class="previous"><a href="#" class="btn-skip back-step3"><span>&raquo; </span>Previous step</a></li>
			<li class="skip">Skip this step<span> &raquo;</span></li>
			<li class="next"><a href="index.php?option=com_configurator&task=manage" class="launch-cfg btn-install" title="click here to get started with configurator">Launch Configurator</a></li>
		</ul>
	</div>
</div>	
</div>