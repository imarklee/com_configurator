<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php if (!isset ($_COOKIE['blocks-desc'])) { ?><div class="desc-overlay">&nbsp;</div><?php } ?>
<div id="blocks-desc" class="tab-desc"<?php if (isset ($_COOKIE['blocks-desc'])) { ?> style="display:none;"<?php } ?>>
	<div class="desc-inner">
		<h2><?= @text('About the block settings tab') ?></h2>
		<p class="last"><?= @text('Think of blocks as the lego pieces that make up your website. Each one of the different blocks can be configured 
		to work in a multitude of ways. These settings will change depending on which themelet is currently published.') ?>
		<a href="#" class="close"><?= @text('close') ?></a></p>
	</div>
</div>