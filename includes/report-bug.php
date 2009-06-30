<div id="report-bug" title="Send us your feedback">
	<p>Your feedback and suggestions are important to us. Fill in the form below, with as much detail
	as possible.</p>
	
	<p><strong>* Please note: </strong> We will attach some information to this submission to allow us 
	to see what environment Morph and Configurator are running on. This will aid us in fixing any 
	bugs/enhancements. You can view this information just above the form buttons.</p>
	
	<p id="validateTips">All form fields are required.</p>
	<form id="feedbackform" method="post" action="">
	<fieldset>
		<label for="name">Your name</label>
		<input type="text" disabled="disabled" name="name" id="ff-name" class="text ui-widget-content ui-corner-all" value="<?php echo $_COOKIE['member_name']; ?> <?php echo $_COOKIE['member_surname']; ?>" />
		<label for="email">Your email address</label>
		<input type="text" disabled="disabled" name="email" id="ff-email" value="<?php echo $_COOKIE['member_email']; ?>" class="text ui-widget-content ui-corner-all" />
		<label for="feedback_type">Type of feedback</label>
		<span><input type="radio" name="feedback_type" value="bug" />Bug</span>
		<span><input type="radio" name="feedback_type" value="enhancement" />Enhancement</span>
		<label for="category">In relation to</label>
		<span><input type="radio" name="category" value="morph" />Morph</span>
		<span><input type="radio" name="category" value="configurator" />Configurator</span>
		<label for="title">Message Title</label>
		<input type="text" name="title" id="ff-title" value="" class="text ui-widget-content ui-corner-all" />
		<label for="description">Describe what happened</label>
		<textarea name="description" id="ff-description" rows="4" cols="40" class="text ui-widget-content ui-corner-all"></textarea>
		<label for="specs">Specifications *</label>
		<textarea name="specs" style="display:none;"rows="4" cols="40" ></textarea>
		<div id="ff-specs">
			<p><strong>Configurator: </strong>Version <?php echo $component_arr['version']; ?><br />
			<strong>Morph: </strong>Version <?php echo $template_arr['version']; ?><br />
			<strong>Themelet: </strong><?php echo $themelet_arr['name']; ?> - Version <?php echo $themelet_arr['version']; ?><br />
			<strong>Joomla: </strong>Version <?php echo JVERSION; ?><br />
			<strong>URL: </strong><?php echo $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?><br />
			<strong>Browser / OS: </strong> <?php echo $_SERVER['HTTP_USER_AGENT']; ?><br />
			</p>
		</div>
		<input class="ff-button" type="submit" name="ff-submit" id="ff-submit" value="Send Feedback" />
		<input class="ff-button" type="reset" name="ff-reset" id="ff-reset" value="Cancel and Close" />
	</fieldset>
	</form>
</div>