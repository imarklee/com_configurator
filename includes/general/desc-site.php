<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php if (!isset ($_COOKIE['site-desc'])) { ?><div class="desc-overlay">&nbsp;</div><?php } ?>
<div id="site-desc" class="tab-desc"<?php if (isset ($_COOKIE['site-desc'])) { ?> style="display:none;"<?php } ?>>
	<div class="desc-inner">
		<h2><?= @text('About the general settings tab') ?></h2>
		<p class="last"><?= @text('The options in the general settings tab are those which are specific to your site 
		and will not change when you assign a new themelet. We have tried to make the options as easy to understand 
		as possible, but if there is anything that you think could be improved, please be sure to let us know.') ?> 
		<a href="#" class="close">close</a></p>
	</div>
</div>