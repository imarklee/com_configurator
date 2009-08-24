<h2>Configurator Preferences</h2>
<p>Set your configurator preferences here. These rely on cookies and will need to be re-applied should your cookies be cleared.</p>
<form action="index.php?option=com_configurator&task=save_prefs" method="post" id="preferences-form">
	<ul class="prefs">
	<?php echo renderParams($pref_xml->renderToArray('cfg', 'cfg_prefs')); ?>
	</ul>
	<input type="submit" value="save preferences" class="btn-prefs" />
</form>