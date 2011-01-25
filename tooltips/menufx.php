<?php ?>
<div id="docs-menufx" class="docs-wrap">
<h2><?= @text('Understanding Morphs menus:') ?></h2>
<p class="intro"><?= @text('This is a quick overview on how to take advantage of the various menu options that we have built into Morph. To really get the most out of Morph, we do recommend that you check out the dedicated Morph Documentation site, as we will constantly be updating it with more detailed tutorials.') ?></p>

<h3><?= @text('Horizontal Navigation:') ?></h3>
<p><?= @text('The horizontal navigation refers to the top navigation, that uses the core Joomla! menu module, assigned to the "user3" module position. There are four different menu types that can be used in the <strong>topnav</strong> block.') ?></p>

<dl class="options-list">

<dt><?= @text('Default') ?></dt>
<dd><?= @text('This is the default state of the top navigation and will be styled as a traditional horizontal menu bar. The default state requires no module suffixes.') ?></dd>

<dt><?= @text('Subtext') ?></dt>
<dd><?= @text("Adding a module suffix of '<strong>subtext</strong>' will allow you to use subtext in your menu items. This can be used on any of the different menu levels. Once you have added the module suffix to your menu module, you will need to update you menu items to use subtext. An example of this would be Home#This is my subtext. Notice how the # is used set the breaking point for the subtext. Don't worry, the # will not be included in your menu items.") ?></dd>

<dt><?= @text('TopFish') ?></dt>
<dd><?= @text("Adding a module suffix of '<strong>topfish</strong>' will activate the top horizontal Superfish navigation. Once you have added the menu's module suffix, you can proceed to add child menu items to your navigation. See below if you are not sure how to add child (sub) menu items to your menu.") ?></dd>

<dt><?= @text('TopDrop') ?></dt>
<dd><?= @text('Adding a module suffix of "<strong>topdrop</strong>" will activate the top dropline menu with a twist. Any child items on the second level will be displayed in a sub bar, but any further subitems will drop down like a traditional superfish menu. This allows you to get the best of both worlds.') ?></dd>

<dt><?= @text('TopSplit') ?></dt>
<dd><?= @text('The top split menu requires a few changes to your mainmenu modules settings. More info coming soon.') ?></dd>
</dl>
<br />
<h3><?= @text('Vertical Navigation:') ?></h3>
<p></p>

<dl class="options-list">

<dt><?= @text('Default') ?></dt>
<dd><?= @text('This is the default state of the sidebar navigation and will be styled as a traditional vertical menu. The default state requires no module suffixes. Any sub menu items will be displayed as a nested list with this option.') ?></dd>

<dt><?= @text('Subtext') ?></dt>
<dd><?= @text("As with the horizontal navigation, adding a module suffix of 'subtext' will allow you to use subtext in your vertical menu items. Again, this can be used on any of the different menu levels. Once you have added the module suffix to your menu module, you will need to update you menu items to use subtext. An example of this would be Home#This is my subtext. Notice how the # is used set the breaking point for the subtext. Don't worry, the # will not be included in your menu items.") ?></dd>

<dt><?= @text('SideFish') ?></dt>
<dd><?= @text("Adding a module suffix of '<strong>sidefish</strong>' will activate the sidebar vertical Superfish navigation. Once you have added the menu's module suffix, you can proceed to add child menu items to your navigation. See below if you are not sure how to add child (sub) menu items to your menu. Depending on which sidebar the menu is published will determine how the sub items will fly out.") ?></dd>

</dl>

 </div>
 









