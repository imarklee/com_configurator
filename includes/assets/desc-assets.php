<?php if (!isset ($_COOKIE['assets-desc'])) { ?><div class="desc-overlay">&nbsp;</div><?php } ?>
<div id="assets-desc" class="tab-desc"<?php if (isset ($_COOKIE['assets-desc'])) { ?> style="display:none;"<?php } ?>>
	<div class="desc-inner">
		<h2>About the assets tab</h2>
		<p class="last">Assets are the digital media files that are specific to your website and 
		are stored in a folder called "<strong>morph_assets</strong>", which is stored 
		in your Joomla! site root. Having your assets located outside of your template means you can 
		upgrade Morph without losing your custom backgrounds, logos, themelets and backups.
		<a href="#" class="close">close</a></p>
	</div>
</div>