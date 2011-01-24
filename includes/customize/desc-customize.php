<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php if (!isset ($_COOKIE['themelet-desc'])) { ?><div class="desc-overlay">&nbsp;</div><?php } ?>
<div id="themelet-desc" class="tab-desc"<?php if (isset ($_COOKIE['themelet-desc'])) { ?> style="display:none;"<?php } ?>>
	<div class="desc-inner">
		<h2><?= @text('About the themelet settings tab') ?></h2>
		<p class="last"><?= @text('Themelets (otherwise known as "child themes" take care of the visual aspect of your 
		website and run off Morphs core template framework. These settings will change depending on which 
		themelet is currently published.') ?> <a href="#" class="close"><?= @text('close') ?></a></p>
	</div>
</div>