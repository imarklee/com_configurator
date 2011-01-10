<? defined( 'KOOWA' ) or die( 'Restricted access' ) ?>
<div id="nomorph">
	<h1><?= @text('Morph needs to be installed in order to work.') ?></h1>
	<p><?= sprintf(
		@text('Please %s then reload this page.'),
		'<a href="index.php?option=com_installer">'.@text('install Morph').'</a>'
	) ?></p>
</div>