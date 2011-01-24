<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="outer-sidebar-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="outer-sidebar-options" class="options-panel">
	    <h3><?= @text('Outer Sidebar Defaults') ?></h3>
		<ol class="forms">
			<?= @params(array('name' => 'outersidebar')) ?>
		</ol>
	    <h3><?= @text('Outer1 Position') ?></h3>
		<ol class="forms">
			<?= @params(array('name' => 'outer1')) ?>
		</ol>
	    <h3><?= @text('Outer2 Position') ?></h3>
		<ol class="forms">
			<?= @params(array('name' => 'outer2')) ?>
		</ol>
	    <h3><?= @text('Outer3 Position') ?></h3>
		<ol class="forms">
			<?= @params(array('name' => 'outer3')) ?>
		</ol>
	    <h3><?= @text('Outer4 Position') ?></h3>
		<ol class="forms">
			<?= @params(array('name' => 'outer4')) ?>
		</ol>
	    <h3><?= @text('Outer5 Position') ?></h3>
		<ol class="forms">
			<?= @params(array('name' => 'outer5')) ?>
		</ol>
	</div>
	<div id="outer-sidebar-info" class="info-panel">
		<h3><?= @text('Outer Sidebar') ?></h3>
		<p class="teaser"><?= @text('The concept of the inner &amp; outer layouts require a bit of understanding to 
		grasp, but once you do you will have unparalelled flexibility at your finger tips.') ?></p>
		<p><?= @text('Based on commonly accepted <em>best practices</em>, we refer to your sites main content as your 
		<strong>primary content</strong> &amp; likewise your two optional sidebars are referred to as your 
		<strong>secondary &amp; tertiary content</strong>. This naming convention relates to the importance 
		of the content &amp; is ordered accordingly in your sites source code.') ?></p>
		
		<!-- <h4>Understanding the Inner &amp; Outer layouts</h4>
		<p>The <strong>outer layout</strong> refers to the width and position of your <strong>secondary content</strong>, 
		whereas the <strong>inner layout</strong> refers to the width and position of your <strong>tertiary content</strong>.</p>
		<p>Setting the inner &amp; outer layout defaults is only the tip of the iceberg. The true power of these is the ability 
		to control them on a page by page basis, using our PageFX feature.</p>
		<p><a class="modal-link btn-link" href="pagefx.html" title="Getting started with PageFX">Learn more about PageFX</a></p>-->
	</div>
</div>