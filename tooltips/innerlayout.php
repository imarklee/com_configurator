<?php ?>
<div id="docs-inner" class="docs-wrap">
<h3><?= @text('Inner Layouts Explained:') ?></h3>
<p class="intro"><?= @text('The inner layout refers to your tertiary content, which is essentially your right sidebar.') ?></p>

<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td width="200" class="docs-il-outer"><?= @text('Outer Sidebar') ?></td>
		<td>
			<table border="0" cellspacing="5" cellpadding="5">
				<tr>
					<td class="docs-il-content"><?= @text('Main Content') ?></td>
					<td class="docs-il-inner"><?= @text('50% Sidebar right') ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="200" class="docs-il-outer"><?= @text('Outer Sidebar') ?></td>
		<td>
			<table border="0" cellspacing="5" cellpadding="5">
				<tr>
					<td class="docs-il-content"><?= @text('Main Content') ?></td>
					<td class="docs-il-inner" width="33%"><?= @text('33% Sidebar right') ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="200" class="docs-il-outer"><?= @text('Outer Sidebar') ?></td>
		<td>
			<table border="0" cellspacing="5" cellpadding="5">
				<tr>
					<td class="docs-il-content"><?= @text('Main Content') ?></td>
					<td class="docs-il-inner" width="25%"><?= @text('25% Sidebar right') ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="200" class="docs-il-outer"><?= @text('Outer Sidebar') ?></td>
		<td>
			<table border="0" cellspacing="5" cellpadding="5">
				<tr>
					<td class="docs-il-inner" width="200"><?= @text('200px Sidebar left') ?></td>
					<td class="docs-il-content"><?= @text('Main Content') ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="200" class="docs-il-outer"><?= @text('Outer Sidebar') ?></td>
		<td>
			<table border="0" cellspacing="5" cellpadding="5">
				<tr>
					<td class="docs-il-content"><?= @text('Main Content') ?></td>
					<td class="docs-il-inner" width="200"><?= @text('200px Sidebar left') ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>