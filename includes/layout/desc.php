<? defined( 'KOOWA' ) or die( 'Restricted access' ) ?>

<? if(!KRequest::has('cookie.'.$name.'-desc')) : ?>
<div class="desc-overlay">&nbsp;</div>
<div id="<?= $name ?>-desc" class="tab-desc">
	<div class="desc-inner">
		<h2><?= @text($title) ?></h2>
		<p class="last"><?= @text($text) ?>
		<a href="#" class="close">close</a></p>
	</div>
</div>
<? endif ?>