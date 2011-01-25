<?php ?>
<div id="docs-gridsplits" class="docs-wrap">
<h3><?= @text('Grid Split Explained:') ?></h3>
<p class="intro"><?= @text('Grid split refers to the ratio in which modules assigned to a particular module position. Morph will automatically float your various modules in a default fashion, unless otherwise specified. Its important to note that custom grid split options only apply when there are two modules assigned to a position. We do however plan on incorporating the <a href="http://www.grid960.com" target="_blank">Grid 960</a> css library to allow for even more layout options.') ?></p>

<h4><?= @text('Grid Split defaults:') ?></h4>
<p><?= @text('This is a break down of the grid split defaults. There is nothing that you need to do in order to get this working. See the custom options examples on how you can customize your module grids further.') ?></p>

<table border="0" cellspacing="0" cellpadding="0" id="gs-default1">
	<caption><?= @text('Grid Split ratio with one modules assigned') ?></caption>
	<tr>
		<td>100%</td>
	</tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" id="gs-default2">
	<caption><?= @text('Grid Split ratio with two modules assigned') ?></caption>
	<tr>
		<td>50%</td>
		<td>50%</td>
	</tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" id="gs-default3">
	<caption><?= @text('Grid Split ratio with three modules assigned') ?></caption>
	<tr>
		<td width="33%">33%</td>
		<td width="33%">33%</td>
		<td width="34%">33%</td>
	</tr>
</table>

<h3><?= @text("Custom Grid Split ratio's") ?></h3>
<p><?= @text("** Please note that custom ratio's only work when two modules are assigned to a position.") ?></p>
<table border="0" cellspacing="0" cellpadding="0" id="gs-custom1">
	<caption><?= @text('Option One: 50/50 Split') ?></caption>
	<tr>
		<td>50%</td>
		<td>50%</td>
	</tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" id="gs-custom2">
	<caption><?= @text('Option Two: 66/33 Split') ?></caption>
	<tr>
		<td width="67%">66%</td>
		<td width="33%">33%</td>
	</tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" id="gs-custom3">
	<caption><?= @text('Option Three: 33/66 Split') ?></caption>
	<tr>
		<td width="33%">33%</td>
		<td width="67%">66%</td>
	</tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" id="gs-custom4">
	<caption><?= @text('Option Four: 75/25 Split') ?></caption>
	<tr>
		<td width="75%">75%</td>
		<td width="25%">25%</td>
	</tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" id="gs-custom5">
	<caption><?= @text('Option Five: 25/75 Split') ?></caption>
	<tr>
		<td width="25%">25%</td>
		<td width="75%">75%</td>
	</tr>
</table>

</div>