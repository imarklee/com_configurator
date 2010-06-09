<?php 
ob_start();
if(strpos($_SERVER['SCRIPT_NAME'], 'install.configurator.php') === false){
$base = './components/com_configurator';
}else{
$base = '.';
}
define('JURL', $base);
define('JROOT', str_replace(array('administrator/components/com_configurator/installer','administrator\components\com_configurator\installer'), '', dirname(__FILE__)));
function summaryclass($cookie){
	if(isset($_COOKIE[$cookie])){
		$class = ' class="tick-on"';
	}else{
		$class = ' class="tick-off"';
	}
	return $class;
}
function iType($cookie){
	if(isset($_COOKIE[$cookie])){
		$iType = 'Upgraded';
	}else{
		$iType = 'Installed';
	}
	return $iType;
}
/*$conditions = array(
	'cfg'	=> 	array(
					'installed' => true,
					'text'		=> ' the Configurator component.'
				)
);
foreach($conditions as $name => $condition)
{
		foreach((array) $condition['conditions'] as $check)
		{
			die('<pre>'.var_export($check, true).'</pre>');
		}
	
	if(!isset($condition['method'])) $condition['method'] = iType('upgrade_'.$name);
	$summary['tick-'.($condition['installed'] ? 'on' : 'off')] = 
}*/
?>
<div id="install-head">
	<img src="<?php echo JURL; ?>/installer/images/morphlogo.png" alt="morph logo" width="182" height="59" border="0" class="logo" />
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
		<?php /*foreach($summary as $class => $text) : ?>
			<li class="<?php echo $class ?>"><?php echo JText::_($text) ?></li>	
		<?php endforeach*/ ?>
			<li class="tick-on"><?php echo iType('upgrade_cfg'); ?> the Configurator component.</li>
			<li<?php echo summaryclass('installed_morphcache'); ?>><?php echo iType('upgrade_morphcache'); ?> the Morph Cache system plugin.</li>
			<?php if(isset($_COOKIE['installed_morph']) && isset($_COOKIE['installed_bkpmorph'])){ ?>
			<li<?php echo summaryclass('installed_bkpmorph'); ?>>Created a backup of the Morph template.</li>
			<?php } ?>
			<li<?php echo summaryclass('installed_morph'); ?>><?php echo iType('upgrade_morph'); ?> the Morph template.</li>
			<li<?php echo summaryclass('installed_pubmorph'); ?>>Published the Morph template.</li>
			<?php if(isset($_COOKIE['installed_themelet']) && isset($_COOKIE['upgrade_themelet'])){ ?>
			<li<?php echo summaryclass('installed_bkpmorph'); ?>>Created a backup of the <?php if(isset($_COOKIE['ins_themelet_name'])) { echo ' '.ucwords($_COOKIE['ins_themelet_name']).' '; }else{ echo ' '; } ?>themelet.</li>
			<?php } ?>
			<li<?php echo summaryclass('installed_themelet'); ?>><?php echo iType('upgrade_themelet'); ?> the <?php if(isset($_COOKIE['ins_themelet_name'])) { echo ' '.ucwords($_COOKIE['ins_themelet_name']).' '; }else{ echo ' '; } ?>themelet.</li>
			<li<?php echo summaryclass('installed_actthemelet'); ?>>Activated the <?php if(isset($_COOKIE['ins_themelet_name'])) { echo ' '.ucwords($_COOKIE['ins_themelet_name']).' '; }else{ echo ' '; } ?>themelet.</li>
			<?php if(isset($_COOKIE['installed_gzip'])) { ?><li<?php echo summaryclass('installed_gzip'); ?>>Enabled Joomla's GZIP compression.</li><?php } ?>
		</ul>
	</div>
	<div id="install-foot">
		<ul id="action">
			<li class="previous"><a href="#" class="btn-skip back-step2"><span>&raquo; </span>Previous step</a></li>
			<li class="skip">Skip this step<span> &raquo;</span></li>
			<li class="next"><a href="index.php?option=com_configurator&view=configuration" class="launch-cfg btn-install" title="click here to get started with configurator">Launch Configurator</a></li>
		</ul>
	</div>
</div>	
</div>
<?php ob_end_flush(); ?>