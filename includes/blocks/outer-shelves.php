<div id="outer-shelves-tab" class="ui-tabs-hide">
	<div id="shelf-options" class="options-panel">
   	    <h3>Top Shelf Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('topshelf', 'topshelfdata')); ?>
		</ol>
   	    <h3>Bottom Shelf Settings</h3>
		<ol class="forms">
			<?php echo renderParams($params->renderToArray('bottomshelf', 'bottomshelfdata')); ?>
		</ol>
	</div>
	<div id="shelves-info" class="info-panel">
		<h3>Top &amp; bottom shelves</h3>
		<p class="teaser">The top &amp; bottom shelves are outside of the main content block. 
		This means that although they are constrained to the overall sites width, they can be 
		configured in a number of different ways.</p>
				
		<h4>This block is slider enabled</h4>
		<p>This means that if enabled, the block will have a toggle link, allowing the person 
		browsing your site to toggle the blocks visibility. The slider will use <dfn title="Cookies 
		are small text files a web site puts on your computer to store information about your 
		browsing that the site can access at later sessions. The following sections provide more 
		information.">cookies</dfn> to remember the users selection.</p>		
	</div>
</div>