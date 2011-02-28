<?php defined('_JEXEC') or die('Restricted access'); ?>

<? $key = KFactory::get('admin::com.configurator.helper.browser')->getKeyboardKey() ?>

<h2>Configurator's Keyboard Shortcuts:</h2>
<p>All of the below shortcuts can be used to toggle between the 
on &amp; off state of the shortcut. For example, pressing the <?= $key ?>+p 
shortcut will open the preferences dialog and pressing <?= $key ?>+p again 
will close it.</p>



<ul>
<li><strong><?= $key ?> P</strong> Preferences</li>
<li><strong><?= $key ?> 1</strong> Open the Quick Start guide</li>
<li><strong><?= $key ?> O</strong> Open your site in new window</li>
<li><strong><?= $key ?> 2</strong> Open the Blocks reference map</li>
<li><strong><?= $key ?> /</strong> Preview your sites module positions</li>
<li><strong><?= $key ?> 3</strong> Open the Position reference map</li>
<li><strong><?= $key ?> S</strong> Save your changes</li>
<li><strong><?= $key ?> 4</strong> Open the Troubleshooting guide</li>
<li><strong><?= $key ?> E</strong> Send feedback (bug or suggestion)</li>
<li><strong><?= $key ?> 5</strong> Open the ModuleFX guide</li>
<li><strong><?= $key ?> 6</strong> Open the PageFX guide</li>
<li><strong><?= $key ?> F</strong> Toggle between fullscreen mode</li>
<li><strong><?= $key ?> 7</strong> Open the MenuFX guide</li>
<li><strong><?= $key ?> 0</strong> Toggle the top shelf</li>
<li><strong><?= $key ?> 8</strong> Open the ContentFX guide</li>
</ul>