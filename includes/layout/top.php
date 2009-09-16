<div id="top">
	<div id="branding">
		<img src="../administrator/components/com_configurator/images/morph-logo.png" alt="morph logo" width="173" height="60" border="0" />
	</div>
	<div id="quicktips">
	<?php if ($cfg_pref->quick_tips == 1) { ?>
		<div id="tips">
			<div class="inner">
				<h4>Quick tips on using Morph &amp; Configurator:</h4>
				<div id="tips-content">
				<?php
				 
					foreach(array_shuffle(showTips()) as $tip){
						echo '<p style="display:none;">'.$tip.'</p>';
					}
				?>
				</div>
				<a href="#"><span>close </span>x</a>
			</div>
		</div>
	<?php } ?>
	</div>
</div>