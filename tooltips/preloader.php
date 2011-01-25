<?php ?>
<div id="docs-preloader" class="docs-wrap">
<h2><?= @text('Customizing which pages the preloader is enabled on:') ?></h2>
<p class="intro"><?= @text('You may not want the preloader to be displayed on all pages, so this brief tutorial will show you how to customize which pages it is enabled on.') ?></p>

<h3><?= @text('Step 1: Disable loading on all pages') ?></h3>
<p><?= @text('The first thing you need to do is set the "Enable on all pages" option to "no". Once that is done, you can proceed to the built in code editor and select the "custom footer script" option from the drop down list.') ?></p>

<h3><?= @text('Step 2: Add your custom footer script code') ?></h3>
<p><?= @text('You can preload specific pages (using their body classes) or specific elements on a page. See the exampes below.') ?></p>

<p><?= @text('This example uses the body classes of specific pages. You can either use the pre-generated classes created by Morph (ie, the name of a component or view) or add your own page class suffix via the pages menu item, for example if you set a page class suffix of "team" you would then use "body.team".') ?></p>

<pre><code>&lt;script type='text/javascript'&gt;
 	$ = jQuery.noConflict();   
 	QueryLoader.selectorPreload = "body.frontpage";
 	QueryLoader.selectorPreload = "body.kunena";
 	QueryLoader.selectorPreload = "body.article";
 	QueryLoader.init();
&lt;s/script&gt;</code></pre>
<br />
<p><?= @text('This example uses the id of an element on the page. An example of this could be the subhead block, ie: #subhead.') ?></p>
 
<pre><code>&lt;script type='text/javascript'&gt;
 	QueryLoader.selectorPreload = "#idOfTheElement";
 	QueryLoader.init();
&lt;/script&gt;</code></pre>
<br />
<h3><?= @text('Troubleshooting tips:') ?></h3>
<p><?= @text("If you find that the preloader gets stuck on a page, check the page for any broken images. It won't be able to complete the loading process if there are any broken images, so this is something to be aware of before enabling this feature.") ?></p>
</div>