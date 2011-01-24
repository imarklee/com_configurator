<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php if (!isset ($_COOKIE['tools-desc'])) { ?><div class="desc-overlay">&nbsp;</div><?php } ?>
<div id="tools-desc" class="tab-desc"<?php if (isset ($_COOKIE['tools-desc'])) { ?> style="display:none;"<?php } ?>>
	<div class="desc-inner">
		<h2><?= @text('About the tools tab') ?></h2>
		<p class="last"><?= @text('These tools are aimed at making your life easier. Whether its installing a new themelet, upgrading
		your version of Morph, uploading media, managing your database backups - we have you covered. If you have any suggestions
		for any other tools or just ways we can improve the existing ones, please <a href="#" class="report-bug" title="click here to open the 
		feedback form!">let us know</a>!') ?>
		<a href="#" class="close"><?= @text('close') ?></a></p>
	</div>
</div>