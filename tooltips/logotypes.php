<?php ?>
<div id="docs-logos" class="docs-wrap">
<h3><?= @text('Logo Types Explained:') ?></h3>
<p class="intro"><?= @text("The best way to code your sites logo is something that has been debated in great depth, each method having its merits or disadvantages for Search Engine Optimization. When we first started planning out Morph's development, we did extensive research into which were the various recommended ways of coding your sites logo and since there was no exact science, we decided to give you the choice about which method to use.") ?></p>

<h3><?= @text('Below is a list of the various logo types you can choose from:') ?></h3>

<dl class="options-list">
	<dt><?= @text('Linked inline image') ?></dt>
	<dd><?= @text('Some people feel that since your logo is part of your branding and thus should not be seen as a presentational element. Choosing this option will output the logo of your choice, wrapped in a link to your sites home page. There are also options where you can set your logos dimensions, alt text and link title.') ?></dd>
	
	<dt><?= @text('Linked plain text') ?></dt>
	<dd><?= @text('Some of you may prefer just a plain text logo, wrapped in a link to your sites home page. You can customize the text to use, as well as the optionally enable a slogan text below (which can also be customized).') ?></dd>
	
	<dt><?= @text('Linked h1 text replacement') ?></dt>
	<dd><?= @text('This option will output a linked H1 and then use css image replacement to hide the logo text (which you can customize) and output an image of your logo instead. The link title can also be customized.') ?></dd>
	
	<dt><?= @text('Module position') ?></dt>
	<dd><?= @text("Just in case there is an alternate method not listed in the options, we have included an option to output a module position instead - thus allowing you to inset your own custom code instead. You can do this be creating a new custom module from Joomla's Module Manager. The module position (if this is enabled) is 'branding'.") ?></dd>
</dl>
</div>