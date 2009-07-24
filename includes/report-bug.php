<?php
$template_url = JURI::root() . 'templates/morph/';
$themelet_url = JURI::root() . 'morph_assets/themelets/';
$component_url = JURI::root() . 'administrator/components/com_configurator/'; 
							
$template_xml = $template_url . 'templateDetails.xml';
$themelet_xml = $themelet_url . $params->get('themelet') .'/themeletDetails.xml';
$component_xml = $component_url . 'configurator.xml';

$template_details = xml2array($template_xml);
$themelet_details = xml2array($themelet_xml);
$component_details = xml2array($component_xml);

$template_arr = $template_details['install'];
$themelet_arr = $themelet_details['install'];
$component_arr = $component_details['install'];
?>
<div id="report-bug" title="Send us your feedback">
	<p class="teaser">Your feedback and suggestions are important to us. If there is anything that could be done better, or improved on - even the terminology we use, we want to know! Fill in the form below, with as much detail as possible.</p>

	<form id="feedbackform" method="post" action="">
	<fieldset>
		<?php if(isset($_COOKIE['am_logged_in'])){ ?>
			<span style="display: none;">
			<label for="name">Your name</label>
			<input type="text"name="name" id="ff-name" class="text ui-widget-content ui-corner-all" value="<?php echo $_COOKIE['member_name']; ?> <?php echo $_COOKIE['member_surname']; ?>" />
			
			<label for="email">Your email address</label>
			<input type="text" name="email" id="ff-email" value="<?php echo $_COOKIE['member_email']; ?>" class="text ui-widget-content ui-corner-all" />
			</span>
		<?php } ?>
		<ul>
			<?php if(!isset($_COOKIE['am_logged_in'])){ ?>
				<li class="fb-name">
					<label for="fb-name">Your name:</label>
					<input type="text" name="name" id="fb-name" value="" class="text ui-widget-content ui-corner-all" />
				</li>
				<li class="fb-email">
					<label for="fb-email">Your email address</label>
					<input type="text" name="email" id="fb-email" value="" class="text ui-widget-content ui-corner-all" />
				</li>
			<?php } ?>
			<li class="fb-type">
				<label for="feedback_type">Type of feedback:</label>
				<ul class="inline">
					<li class="fb-suggestion"><label for="type_suggestion"><input type="radio" name="type" id="type_suggestion" value="enhancement" /><span>Suggestion</span></label></li>
					<li class="fb-bug"><label for="type_bug"><input type="radio" name="type" value="bug"  id="type_bug"/> <span>Bug</span></label></li>
				</ul>
			</li>
		
			<li class="fb-product">
				<label for="category">In relation to:</label>
				<ul class="inline">
					<li class="fb-cfg"><label for="product_configurator"><input type="radio" name="category" value="7637" id="product_configurator" /> <span>Configurator</span></label></li>
					<li class="fb-morph"><label for="product_morph"><input type="radio" name="category" value="7635" id="product_morph" /> <span>Morph</span></label></li>
				</ul>
			</li>

			<li class="fb-subject">
				<label for="title">Subject:</label>
				<input type="text" name="title" id="ff-title" value="<?php if(!isset($_COOKIE['am_logged_in'])){ ?>Unable to login<?php } ?>" class="text ui-widget-content ui-corner-all" />
			</li>
			<li class="fb-message">
				<label for="description">Message:</label>
				<textarea name="description" id="ff-description" rows="4" cols="40" class="text ui-widget-content ui-corner-all"></textarea>
			</li>
			<li class="fb-buttons">
				<input class="ff-button" type="submit" name="ff-submit" id="ff-submit" value="Send Feedback" />
				<a href="#" id="ff-reset">Cancel</a>
			</li>
		</ul>
	</fieldset>
	<textarea name="specs" style="display:none;"rows="4" cols="40" ></textarea>
	<div id="ff-specs" style="display:none;">
		<p><strong>Configurator: </strong>Version <?php echo $component_arr['version']; ?><br />
		<strong>Morph: </strong>Version <?php echo $template_arr['version']; ?><br />
		<strong>Themelet: </strong><?php echo $themelet_arr['name']; ?> - Version <?php echo $themelet_arr['version']; ?><br />
		<strong>Joomla: </strong>Version <?php echo JVERSION; ?><br />
		<strong>URL: </strong><?php echo $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?><br />
		<strong>Browser / OS: </strong> <?php echo $_SERVER['HTTP_USER_AGENT']; ?></p>
	</div>
	</form>
</div>