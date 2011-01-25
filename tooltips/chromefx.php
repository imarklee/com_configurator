<?php ?>
<div id="docs-chromefx" class="docs-wrap">
<h3><?= @text('Module Chromes &amp; ChromeFX Explained:') ?></h3>
<p class="intro"><?= @text("Module chromes are the xhtml output that is wrapped around your modules contents. By default, Joomla has a number of different types to choose from. These are usual pre-set when a template is developed and cannot be changed without digging in the templates code.</p>
<p>With Morph, we wanted to give users as much control over what is loaded in their site and how. We also weren't satisfied with the chrome options that were available by default. Lucky for us (and you!), Joomla 1.5 gives us the option to create our own chromes.") ?></p>

<h3><?= @text('Chromes available in Morph') ?></h3>
<p><?= @text('We have included five different chrome options for you to choose from. Every single module position in Morph can have a different chrome set.') ?></p>

<dl class="options-list">
<dt><?= @text('Basic<br />XHTML') ?></dt>
<dd><?= @text('The basic xhtml chrome will output the modules heading (if enabled) &amp; contents, wrapped with a single div. We recommend you use this option in most cases, as it will output the least amount of xhtml necessary. This can be styled by using the <span class="docs-class">.mod-basic</span> class.') ?></dd>

<dt><?= @text('Basic<br />Grid') ?></dt>
<dd><?= @text('The basic grid chrome will automatically float modules in a grid layout. By default the number of modules assigned to a position will determine the grid break down. For example, if 2 modules are assigned to a position, they will each take up 50% of the available space. If 3 modules are assigned, then each will take up 33% of the available space. You can further customize this for positions that have 2 modules assigned, but specifying the ratio in which they are divided. This can be styled by using the <span class="docs-class">.mod-grid</span> class.') ?></dd>

<dt><?= @text('ModFX<br />Grid') ?></dt>
<dd><?= @text('This chrome works the same as the basic grid with the addition of an extra wrapping div &amp; various css hooks, which allow you to use one of the many ChromeFX styles via the modules custom suffix. See the <a href="http://www.joomlajunkie.com/demo/2ndgen/morph" target="_blank">snapshot page</a> on our online Morph demo for live examples of the different module suffixes. This can be styled by using the <span class="docs-class">.mod-fx</span> class.') ?></dd>

<dt><?= @text('Module<br />Tabs') ?></dt>
<dd><?= @text("The tabs is probably the neatest of all chromes. This will automatically create a tabs block from different modules assigned to a position where this is enabled. The module titles are used for the actual tabs. It's recommended that you only activate this option when more than one module is assigned to the position.") ?></dd>

<dt><?= @text('None') ?></dt>
<dd><?= @text('This option will not load any additional xhtml around the module contents whatsoever. This is a good option to use when you are only loading a single module in a particular position which already has a wrapping div, like the inset module positions.') ?></dd>
</dl>

</div>
<!--
<span class="modal-preview" title="../administrator/components/com_morph/tooltips/images/chrome-basic.png">Code Output</span>
<span class="modal-preview" title="../administrator/components/com_morph/tooltips/images/chrome-basic.png">Show Example</span>
-->