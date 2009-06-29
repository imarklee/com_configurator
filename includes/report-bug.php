<div id="report-bug" title="Send us your feedback">
	<p id="validateTips">All form fields are required.</p>
	<form>
	<fieldset>
		<label for="name">Your name</label>
		<input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" value="<?php echo $_COOKIE['member_name']; ?> <?php echo $_COOKIE['member_surname']; ?>" />
		<label for="email">Your email address</label>
		<input type="text" name="email" id="email" value="<?php echo $_COOKIE['member_email']; ?>" class="text ui-widget-content ui-corner-all" />
		<label for="feedback_type">Type of feedback</label>
		<input type="radio" name="feedback_type" id="feedback_type" value="bug" /> Bug
		<input type="radio" name="feedback_type" id="feedback_type" value="enhancement" /> Suggestion
		<label for="category">Product</label>
		<input type="radio" name="category" id="category" value="bug" /> Morph
		<input type="radio" name="category" id="category" value="enhancement" /> Configurator
		<label for="description">Describe what happened</label>
		<textarea name="description" rows="8" cols="40"></textarea>
	</fieldset>
	</form>
</div>