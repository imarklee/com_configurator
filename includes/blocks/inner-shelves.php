<div id="inner-shelves-tab" class="ui-tabs-hide ui-tabs-panel">
	<div id="user-options" class="options-panel">
   	    <h3>User1 Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('user1', 'user1data')); ?>
		</ol>
   	    <h3>User2 Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('user2', 'user2data')); ?>
		</ol>
	</div>
	<div id="inner-shelves-info" class="info-panel">
		<h3>User1 &amp; User2 blocks</h3>
		<p class="teaser">The user1 &amp; user2 shelves are located at the top &amp; bottom of the main block. 
		This means that they are constrained to the overall sites width &amp; will only as far as the overall 
		sites width.</p>
		
		<p>We added the inline-shelves to give you maximum flexibility when developing your site and we will be 
		publising some more hands on tutorials on the best way to take advantage of these.</p>
	</div>
</div>