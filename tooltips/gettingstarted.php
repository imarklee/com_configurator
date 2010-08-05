<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php include '../includes/configurator.functions.php'; ?>
<div id="splash">
	<ul id="welcome-tabs">
		<li class="splash-start"><a href="#splashtab-start">Getting started</a></li>
		<li class="splash-fullscreen"><a href="#splashtab-fullscreen">Fullscreen mode</a></li>
		<li class="splash-updates"><a href="#splashtab-updates">Update notifications</a></li>
		<li class="splash-assets"><a href="#splashtab-assets">Working with assets</a></li>
		<li class="splash-methods"><a href="#splashtab-methods">Methods of control</a></li>
		<li class="splash-guides"><a href="#splashtab-guides">Quick start guides</a></li>
		<li class="splash-contextual"><a href="#splashtab-contextual">Contextual help</a></li>
		<li class="splash-shortcuts"><a href="#splashtab-shortcuts">Keyboard shortcuts</a></li>
		<li class="splash-prefs"><a href="#splashtab-prefs">Preferences pane</a></li>
		<li class="splash-feedback"><a href="#splashtab-feedback">Sending feedback</a></li>
		<li class="splash-docs"><a href="#splashtab-docs">Online documentation</a></li>
	</ul>
	<div class="tabContainer">
		<div id="splashtab-start" class="splashtabs">
			<h3>Getting started with Configurator &amp; Morph</h3>
			<p class="intro">It looks like this is the first time you are running Configurator, so we thought you’d like a couple of pointers on using the system.</p> 
			<p>In case you don’t already know, Configurator is our Template Management System (T.M.S.) and is used to control most aspects of Morph.</p>
			<p><img src="../administrator/components/com_configurator/images/maskot-right.png" alt="maskot" border="0" align="right" style="margin:-20px -7px 0 15px" /> We have poured our hearts into both Morph &amp; Configurator and hope you enjoy using it as much as we did making it!</p>
			<p>Take a couple of minutes and go through the different help sections in the menu you see on the left. Once you feel ready to jump in, simply close this window and get started.</p>
			<p><strong>You can access this help pane at any time.</strong> Just click on the “Quick Start” button in the top shelf or use one of the built in keyboard shortcuts (cmd + h).</p>
		</div>
		<div id="splashtab-fullscreen" class="splashtabs">
			<h3>Working in Fullscreen mode</h3>
			<p class="intro">We all know how having that extra bit of real estate can really help your productivity, so we decided to add a feature allowing you to easily toggle between fullscreen mode and normal mode in Configurator.</p> 
			<p><img src="../administrator/components/com_configurator/images/splash-fullscreen-bg.png" alt="maskot" border="0" align="right" style="margin:-5px -7px 0 15px" />There are two ways that you can use this feature:</p>
			<h4>Fullscreen link in the top shelf</h4>
			<p>Click the "Fullscreen mode" link in the top toolbar (see screenshot).</p>
			<h4>Built in shortcuts</h4>
			<p>The easier way is to use the built in keyboard shortcuts. If you are on a mac, simply press <strong>cmd + f</strong> to toggle between the two views. All other users (windows, linux, etc) can use <strong>ctrl + f</strong>.</p>
		</div>
		<div id="splashtab-updates" class="splashtabs">
			<h3>Automatic update notifications</h3>
			<p class="intro">One of the challenges when developing Configurator, was to make it super easy for our members to know when new versions are available. The result is our built in notification system.</p>
			<p><img src="../administrator/components/com_configurator/images/splash-updates-bg.png" alt="maskot" border="0" align="right" style="margin: -5px 0px 0 15px" /></p>
			<p>Simply keep an eye on the top shelf to be notified when new versions of Morph, Configurator or your current themelet are available.</p>
			<p><strong>Column 1</strong> (green) is your installed version<br /><strong>Column 2</strong> (red) is the latest available version.<br /><strong>Column 3</strong> (blue) indicates whether your installed version is up-to-date (tick icon) or not (cross icon).</p>
			<p>If your installed version and the online version differ, the version in column 2 will be hyperlinked to the JoomlaJunkie downloads, allowing you to go and get the latest version for as long as you are a member.</p>
		</div>
		<div id="splashtab-assets" class="splashtabs">
			<h3>Working with your sites assets</h3>
			<p class="intro">The term <em>"assets"</em> refers to the digital media specific to your project, such as your sites custom backgrounds, logos, themelets, etc. The assets tab allows you to manage these without having to use an ftp client.</p>
			<p><img src="../administrator/components/com_configurator/images/splash-assets-bg.png" alt="maskot" border="0" align="right" style="margin: -20px 0px 0 15px" />The assets folder currently only consists of your custom backgrounds, logos and themelets.</p> 
			<p>We plan on extending this to include various different types of backups as well as different graphic "packs".</p>
			<p>The reason why these are stored together is so they can be stored outside your templates folder, allowing you to upgrade Morph without overriding your custom images, themelets, etc.</p>
		</div>
		<div id="splashtab-methods" class="splashtabs">
			<h3>Understanding Morphs methods of control</h3>
			<p class="intro">If you use the analogy of Morph as a sports car, the core framework would be the engine, the themelet would be the design/body of the car and Morph’s Configurator would be the dashboard.</p>
			<p>To have total control, even at high speeds, you (the driver) have a wide variety of methods at your fingertips to control the powerful machine, to make it do exactly what is desired.</p>
			<h4>Two methods of control</h4>
			<p>Configurator is one of two methods of control in Morph. The other method is the <strong>FX Range</strong>, which is divided into <em>PageFX, MenuFX, ModuleFX &amp; ContentFX</em>. These use Joomla's core "suffix" feature, which in its simplest form appends a custom class to a page, module or menu.</p>
			<p>Use a combination of different page or module suffixes to transform your sites layout on a page-by-page basis. You can also mix &amp; match your own custom module styles.</p>
			<p>We highly recommend that you checkout the relevant quick start guides in order to get the most out of the FX Range of features.</p>
		</div>
		<div id="splashtab-guides" class="splashtabs">
			<h3>Quick start guides to get you going</h3>
			<p class="intro">The Quick Start Guides are the quickest way for you to take advantage of Morphs FX Range and are close at hand in Configurators top shelf.</p>
			<p><img src="../administrator/components/com_configurator/images/splash-guides-bg.png" alt="maskot" border="0" align="right" style="margin: 15px 0px 0 15px" /><strong>The Block &amp; Position Maps</strong> give you a visual representation of Morph's building blocks and the various module positions available. </p>
			<p><strong>The ModuleFX guide</strong> lists the various module heading, background &amp; icon styles you have at your disposal.</p>
			<p><strong>The PageFX guide</strong> lists all the page suffixes you can use to change your sites layouts on a page by page basis.</p>
			<p><strong>The MenuFX guide</strong> lists the suffixes used to activate the various menu options built into Morph.</p>
		</div>
		<div id="splashtab-contextual" class="splashtabs">
			<h3>Inline contextual help is close at hand</h3>
			<p class="intro">We realize that when getting started with Morph &amp; Configurator some of the options may not make immediate sense, so we have added extensive contextual help to assist you every step of the way!</p>
			<p><img src="../administrator/components/com_configurator/images/splash-contextual-bg.png" alt="maskot" border="0" align="right" style="margin: -2px 0px 0 15px" />Every single option in Configurator has either an <strong>info or help icon</strong> next to it.</p>
			<p>The <strong>info icon</strong> indicates there is a standard tooltip available. These are generally for options which are more common and easier to understand.</p>
			<p>The <strong>help icon</strong> indicates there is a pop-up help page available. These are used when a simple info tooltip just isn't enough.</p>
			<p>If there is anything that does not make sense or could be improved on, please let us know using the "Send Feedback" link on the top right of your screen.</p>
		</div>
		<div id="splashtab-shortcuts" class="splashtabs">
			<h3>Using the built in keyboard shortcuts</h3>
			<p class="intro">We all love keyboard shortcuts, as they often boost your productivity. With this in mind, we have added a number of different keyboard shortcuts to increase your productivity when using Configurator.</p>
			<p><img src="../administrator/components/com_configurator/images/splash-shortcuts-bg.png" alt="maskot" border="0" align="right" style="margin: 0px 0px 0 15px" /></p>
			<p>
			<strong><?php echo whichKey(get_os()); ?> + P</strong> Preferences<br />
			<strong><?php echo whichKey(get_os()); ?> + 1</strong> Open the Quick Start guide<br />
			<strong><?php echo whichKey(get_os()); ?> + O</strong> Open your site in new window<br />
			<strong><?php echo whichKey(get_os()); ?> + 2</strong> Open the Blocks reference map<br />
			<strong><?php echo whichKey(get_os()); ?> + /</strong> Preview your sites module positions<br />
			<strong><?php echo whichKey(get_os()); ?> + 3</strong> Open the Position reference map<br />
			<strong><?php echo whichKey(get_os()); ?> + S</strong> Save your changes<br />				
			<strong><?php echo whichKey(get_os()); ?> + 4</strong> Open the Troubleshooting guide<br />
			<strong><?php echo whichKey(get_os()); ?> + E</strong> Send feedback (bug or suggestion)<br />
			<strong><?php echo whichKey(get_os()); ?> + 5</strong> Open the ModuleFX guide<br />
			<strong><?php echo whichKey(get_os()); ?> + L</strong> Logout of Configurator<br />
			<strong><?php echo whichKey(get_os()); ?> + 6</strong> Open the PageFX guide<br />
			<strong><?php echo whichKey(get_os()); ?> + F</strong> Toggle between fullscreen mode<br />
			<strong><?php echo whichKey(get_os()); ?> + 7</strong> Open the MenuFX guide<br />
			<strong><?php echo whichKey(get_os()); ?> + 0</strong> Toggle the top shelf<br />
			<strong><?php echo whichKey(get_os()); ?> + 8</strong> Open the ContentFX guide<br />			
			</p>			
		</div>
		<div id="splashtab-prefs" class="splashtabs">
			<h3>Setting your preferences</h3>
			<p class="intro">The preferences pane can be accessed from either the link in the top shelf or using the built in keyboard shortcut <strong><?php echo whichKey(get_os()); ?> + P</strong>.</p>			
			<h4>Preferences options:</h4>
			<ul>
			<li>Enable / disable quick tips</li>
			<li>Enable / disable tab introductions</li>
			<li>Enable / disable sortable tabs</li>
			<li>Enable / disable automatic check for updates</li>
			<li>Enable / disable keyboard shortcuts</li>			
			</ul>
		</div>
		<div id="splashtab-feedback" class="splashtabs">
			<h3>Submitting a bug or suggestion</h3>
			<p class="intro">We believe that submitting a bug or sending a suggestion should be super easy and NOT take you away from the interface you are providing feedback on. </p>
			<p><img src="../administrator/components/com_configurator/images/splash-feedback-bg.png" alt="maskot" border="0" align="right" style="margin: -5px 0px 0 15px" /> With this in mind we built a quick and easy way for you to submit a bug or suggestion.</p>
			<p>You can either click on the <strong>Send Feedback</strong> link in the top shelf, or use the built in keyboard shortcut <strong><?php echo whichKey(get_os()); ?> + E</strong>.</p>
			<p class="important">Due to the vast number of users, we are not able to reply to emails received through Configurator. If you requires a response, please use <a href="http://www.joomlajunkie.com/member">the support forum</a> instead.</p>
		</div>
		<div id="splashtab-docs" class="splashtabs">
			<h3>Extensive online documentation</h3>
			<p class="intro">We are working on extensive documentation and tutorials covering all aspects of both Morph &amp; Configurator. However...</p>
			<p><img src="../administrator/components/com_configurator/images/splash-docs-bg.png" alt="maskot" border="0" align="right" style="margin: 0px 0px 0 15px" /></p>
			<p>Due to the fact that both Morph &amp; Configurator are changing daily while in beta, we have decided to rather focus on the inline documentation within Configurator.</p>
			<p>We will be launching the dedicated Morph documentation site once Morph &amp; Configurator reach a stable release.</p>
			<p>We will also be adding a video tutorials section to Configurator once the layout is complete.</p>
			<p>Please use the inline documentation until the new documentation site is ready and <a id="report-bug-link" href="#">let us know</a> if there's anything you are missing.</p>
		</div>
	</div>
</div>