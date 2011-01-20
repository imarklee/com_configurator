<?php defined('_JEXEC') or die('Restricted access');
ob_start();
if(strpos($_SERVER['SCRIPT_NAME'], 'install.configurator.php') === false){
$base = './components/com_configurator';
}else{
$base = '.';
}
define('JURL', $base);
define('JROOT', str_replace(array('administrator/components/com_configurator/installer','administrator\components\com_configurator\installer'), '', dirname(__FILE__)));

$themelet = ucwords(KFactory::get('admin::com.configurator.helper.utilities')->getInstallState('ins_themelet_name'););
$conditions = array(
	'cfg'			=> 	array(
							'installed' => true,
							'text'		=> ' the Configurator component.'
						),
	'morphcache'	=> 	array(
							'text'		=> ' the Morph Cache system plugin.'
						),
	'bkpmorph'		=> 	array(
							'method'	=> '',
							'text'		=> 'Created a backup of the Morph template.'
						),
	'morph'			=> 	array(
							'text'		=> ' the Morph template.'
						),
	'pubmorph'		=> 	array(
							'method'	=> '',
							'text'		=> 'Published the Morph template.'
						),
	'bkthemelet'	=>	array(
							'installed'	=> KFactory::get('admin::com.configurator.helper.utilities')->getInstallState('installed_themelet') && KFactory::get('admin::com.configurator.helper.utilities')->getInstallState('upgrade_themelet'),
							'method'	=> '',
							'text'		=> sprintf(JText::_('Created a backup of the %s themelet.'), $themelet),
							'translate'	=> false
						),
	'themelet'		=>	array(
							'text'		=> sprintf(JText::_(' the %s themelet.'), $themelet),
							'translate'	=> false
							
	),
	'actthemelet'	=>	array(
							'method'	=> '',
							'text'		=> sprintf(JText::_('Activated the %s themelet.'), $themelet),
							'translate'	=> false
	),
	'gzip'			=> 	array(
							'installed'	=> KFactory::get('admin::com.configurator.helper.utilities')->getInstallState('installed_gzip'),
							'method'	=> '',
							'text'		=> "Enabled Joomla's GZIP compression."
	),
);
foreach($conditions as $name => $condition)
{
	if(!isset($condition['installed'])) $condition['installed'] = KFactory::get('admin::com.configurator.helper.utilities')->getInstallState('installed_'.$name);
	else if(!$condition['installed']) continue;
	
	if(!isset($condition['method'])) $condition['method'] = KFactory::get('admin::com.configurator.helper.utilities')->getInstallState('upgrade_'.$name) ? 'Upgraded' : 'Installed';
	$summary[] = (object) array('class' => 'tick-'.($condition['installed'] ? 'on' : 'off'), 'text' => JText::_($condition['method'] . $condition['text']));
}
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
		<?php foreach($summary as $item) : ?>
			<li class="<?php echo $item->class ?>"><?php echo JText::_($item->text) ?></li>	
		<?php endforeach ?>
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