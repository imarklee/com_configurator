<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="jomsocial-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="jomsocial-options" class="options-panel">
		<h3><?= @text('JomSocial Integration Settings') ?></h3>
		<ol class="forms">
			<?= @params(array('jomsocial' => 'jomsocialdata')); ?>
		</ol>
		<h3><?= @text('JomSocial Box Styles') ?></h3>
		<ol class="forms">
			<?= @params(array('jomsocialboxes' => 'jomsocialboxesdata')); ?>
		</ol>
	</div>
	<div id="jomsocial-info" class="info-panel">
		<h3><?= @text('JomSocial options overview') ?></h3>
		<p class="teaser"></p>
		<p></p>
	</div>
</div>