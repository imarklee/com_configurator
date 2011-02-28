<? defined('KOOWA') or die('Restricted access') ?>

<h2><?= @text('Configurator Preferences') ?></h2>
<p><?= @text('Set your configurator preferences here. These rely on cookies and will need to be re-applied should your cookies be cleared.') ?></p>
<form action="index.php?option=com_configurator&amp;task=save_prefs" method="post" id="preferences-form">
	<ul class="prefs">
	<?php echo renderParams($pref_xml->renderToArray('cfg', 'cfg_prefs')); ?>
	</ul>
	<a href="#" class="btn-primary btn-prefs"><span><?= @text('<strong>Save</strong> Preferences') ?></span></a>
</form>