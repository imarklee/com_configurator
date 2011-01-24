<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php if (!isset ($_COOKIE['plugins-desc'])) { ?><div class="desc-overlay">&nbsp;</div><?php } ?>
<div id="plugins-desc" class="tab-desc"<?php if (isset ($_COOKIE['plugins-desc'])) { ?> style="display:none;"<?php } ?>>
	<div class="desc-inner">
		<h2><?= @text('About the plugins tab') ?></h2>
		<p class="last"><?= @text('The plugins tab will provide you with an interface to manage the various jQuery plugins that we have integrated with Morph.') ?> 
		<a href="#" class="close"><?= @text('close') ?></a></p>
	</div>
</div>