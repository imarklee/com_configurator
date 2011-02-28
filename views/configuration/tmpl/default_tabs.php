<? defined( 'KOOWA' ) or die( 'Restricted access' ) ?>

<div id="<?= $name ?>-tabs" class="subtabs">
	<?= $overlay ?>
	<ul class="ui-helper-clearfix ui-tabs-nav">
	<? foreach($tabs as $name => $title) : ?>
		<li class="icon-<?= $name ?>"><a href="#<?= $name ?>-tab"><?= @text($title) ?></a></li>
	<? endforeach ?>
	</ul>
	<? foreach($tabs as $name => $title) : ?>
		<?= @template($template_path.$name) ?>
	<? endforeach ?>
</div>