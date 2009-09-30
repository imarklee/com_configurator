<div id="conf-login">
	<div id="cl-top">
	<img src="../administrator/components/com_configurator/images/morph-logo.png" alt="morph logo" width="173" height="60" border="0" />
	</div>
	<div id="cl-inner">
		<h2>Configurator for Morph</h2>
		<p>Please log in using your Joomla!Junkie Club Membership details. Not a member? <a href="http://www.joomlajunkie.com/secure" title="this link opens our subscription comparison page in a new window" target="_blank">Click here</a> to sign up!</p>
		<form id="am-login-form" method="post">
			<div id="alf-cont">
				<div id="alf-inp-cont">
				
					<label class="label-username"><span>Username:</span>
					<input type="text" tabindex="10" class="alf-input" id="login_user" name="am-username" title="username" />
					</label>
					<label for="am-password" class="label-password"><span>Password:</span>
					<input type="password" tabindex="20" id="loginpass" class="alf-input" name="am-password" title="password" />
					</label>
					
					<p class="login-sub">
						<label for="am-keep-login" class="login-checkbox">
							<input class="alf-check" type="checkbox" name="am-keep-login" id="am-keep-login" value="true" /> Remember me
						</label>
						&nbsp;&nbsp;|&nbsp;
						<label for="show-password" class="login-checkbox"><span class="sp-check"></span></label>
						&nbsp;&nbsp;|&nbsp;&nbsp;
						<a href="#" id="lost-pass" title="Forgot your club password? Click here to ">Forgot password?</a></p>
				</div>
				<input class="alf-login" type="submit" name="am-do-login" value="am-login-true" />
			</div>				
		</form>
		<div id="alf-warning"></div>
		<div id="alf-output"></div>
		<span class="mascot"></span>
	</div>
	<div id="alf-image">
		<div>
		<img src="../administrator/components/com_configurator/images/loader3.gif" height="16" width="16" border="0" align="center" alt="Loading" /> <span>Logging in..</span>
		</div>
	</div>
	<?php include 'lost-password.php' ?>
</div>