<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="miscellaneous-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="miscellaneous-options" class="options-panel">
		<ol class="forms">
			<?= @params(array('miscellaneous' => 'miscellaneousdata')); ?>
		</ol>
	</div>
	<div id="miscellaneous-info" class="info-panel">
		<h3><?= @text('Miscellaneous overview') ?></h3>
		<p class="teaser"><?= @text('The toolbar block is a general utilities bar and can be used for a number of different functions.') ?></p>
		<p><?= @text('The toolbar block is a general utilities bar and can be used for a number of different functions. This block can be positioned 
		in 4 different areas, giving you additional flexibility with how you use it.') ?></p>	
	</div>
</div>