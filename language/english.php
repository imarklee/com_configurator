<?php defined('_JEXEC') or die('Restricted access');
// English language file for Ninjoomla Morph
//
// Distributed under the terms of the GNU General Public License
// This software may be used without warrany provided and
// copyright statements are left intact.

// Frontend language strings
DEFINE('_T_PAGETITLE', 'Prothemer Morph');

// Admin language strings
DEFINE('_T_A_TEMPLATELIST', 'Morph Template List');


/*****Settings for the helpers*****/
//The component name, used to build directories
DEFINE('_HLPR_COM_NAME', 'com_morph');
//The component name, used to for descriptions
DEFINE('_HLPR_COM_REAL_NAME', 'Prothemer Morph');
//The optional buttons ot show at the bottom of the component
//options are : xhtml,css,gpl,lgpl
DEFINE('_HLPR_BUTTONS', 'xhtml,css,gpl');


/************
*Information for the Dashboard pages
*************/
/***Text For the Dashboard pages - shouldn't change***/
//Created By text
DEFINE('_HLPR_DASH_CREATEBY_TXT', 'Created By: ');
//License Information 
DEFINE('_HLPR_DASH_CODE_REL_UNDR_TXT', 'Programming Code License: ');
DEFINE('_HLPR_DASH_CONT_REL_UNDR_TXT', 'Textual Content License: ');
DEFINE('_HLPR_DASH_CSS_REL_UNDR_TXT', 'CSS, Names and Images: ');
//'Rate it at' question and text
DEFINE('_HLPR_DASH_RATE_QN', 'Do you like this extension? ');
DEFINE('_HLPR_DASH_RATE_TXT', 'Rate it at ');
DEFINE('_HLPR_DASH_RATE_TXT2', 'Joomla.org');
//Support Text
DEFINE('_HLPR_DASH_SUPPT_TXT', ' If you require support for this component please visit the ninjoomla forums.');
//Copyright Information - used in the copyRight function
DEFINE('_HLPR_DASH_COPY_TXT', 'Extension Copyright: ');
DEFINE('_HLPR_DASH_COPY', 'Ninjoomla.com');
DEFINE('_HLPR_DASH_COPY_URL', 'http://www.ninjoomla.com');
//Description title
DEFINE('_HLPR_DASH_DESC_TXT', 'Description: ');
//Usage Instructions page title
DEFINE('_HLPR_DASH_USAGE_TITLE', 'Usage Instructions');

DEFINE('_HLPR_DASH_USAGE_BASIC_TITLE', 'Basic Setup');
DEFINE('_HLPR_DASH_USAGE_TIPS_TITLE', 'Tips and Advanced Usage');
DEFINE('_HLPR_DASH_USAGE_TS_TITLE', 'Trouble Shooting FAQ');

//Changelog Page Title
DEFINE('_HLPR_DASH_CHANGE_TITLE', 'Changelog & Version Information');


/***Variables For the Dashboard pages - should change***/
//Catch Phrase
DEFINE('_HLPR_DASH_CATCHPHRASE', 'Templates Made Easy.');
//Who wrote the extension 
DEFINE('_HLPR_DASH_CREATEBY', 'Daniel Chapman');
//License Information 
DEFINE('_HLPR_DASH_CODE_REL_UNDR', 'GNU GPL');
DEFINE('_HLPR_DASH_CONT_REL_UNDR', 'Creative Commons, Attribution, Non-Commercial, Share Alike');
DEFINE('_HLPR_DASH_CSS_REL_UNDR', 'Copyright, <a href="http://www.ninjoomla.com">Ninjoomla.com</a>');
//'Rate it at' url
DEFINE('_HLPR_DASH_RATE_URL', 'http://extensions.joomla.org/');
//Description content
DEFINE('_HLPR_DASH_DESC', '<p>
Tired of editing php and HTML every time you want to change the parameters of your template?
</p>
<p>
Want to give your customers a little bit of control over their site template without <i>them </i>having to write any php code, or <i>you</i> having to do it for them?
</p>
<p>
Wish there was a way to add advanced parameter options, such as a color picker, validation on the parameters or a calendar picker? Or do you need to dynamically offer lists from the database? Perhaps you jsut wish you could offer your clients an attractive interface for their template customising?
</p>
<p>
Well, now you can. The Prothemer Morph component allows you to control your template parameters using a familiar component interface instead of having to edit your template code every time you want to make a change. </p>
<p>On top of this, for template designers it offers powerful functionality such as JS, CSS and PHP file inclusion, to add those extra touches to your parameters. 
</p>
<p>Have a big list of parameters and want users to be able to change large groups of them at once? Morph also includes functionality to support groups of parameter presets. So you could for example define 3 presets -> light, dark and blue. If your customer wants 90% of the light preset parameters but wants to change only the font color, then they can. </p>
<p>They just select the light preset from the presets drop down list, which updates all of the appropriate parameters to the light settings, then they simply change the setting they want to.</p>');
//Usage Instructions page HTML
DEFINE('_HLPR_DASH_USAGE_BASIC', '<p>
If your template has been modified to work with Morph, then all you need to do is:
</p>
<ul>
	<li>Install this component </li>
	<li>Install the template</li>
	<li>Select your template from the morph template listing</li>
	<li>Make your changes in the spiffy new parameter manager and save </li>
</ul>
<p>
And you&#39;re done! 
</p>
<p>
If however, your template wasn&#39;t designed to work with Morph, the process is a little more complicated. It looks like a lot of work, but once you are familiar with the process it will take only a few minutes to update most templates.
</p>
<ol>
	<li>Find the file <i>/components/com_morph/morphDetails_sample.xml</i> </li>
	<li>Find the file <i>/templates/templatename</i><i>/templateDetails.xml*</i></li>
	<li>Copy the <i>morphDetails_sample.xml</i> to <i>/templates/templatename</i><i>/*</i></li>
	<li>Rename the <b>copy</b> <i>morphDetails_sample.xml</i> to <i>morphDetails.xml</i></li>
	<li>Edit the <i>morphDetails.xml</i> file and copy all the fields from <i>name </i>to<i> description</i> from <i>templateDetails.xml </i>into <i>morphDetails.xml</i></li>
	<li>Find the relevant parameters in your <i>/templates/templatename</i><i>/index.php*</i> file&nbsp; and create these in <i>morphDetails.xml</i></li>
	<li>Copy the <i>/components/com_morph/</i><i>morphLoader.php</i> file to <i>/templates/templatename</i><i>/*</i></li>
	<li>Add <i>include_once(&#39;morphLoader.php&#39;);</i> to the top of the <i>index.php</i> file<i><br />
	</i></li>
	<li>Adjust the parameters in the index.php file to:&nbsp; $variableName = $TATAMI-&gt;variableName**</li>
	<li>Install the component <br />
	</li>
</ol>
<p>Then follow the steps given above to install and use the component and template.</p>
<p>
For a finished example see the included template - Elegant Prothemer </p>
<p>
Expect to see more Morph enabled templates soon. Morph is already supported by some <a href="http://www.joomlajunkie.com">Joomla Junkie</a> templates, and will soon be supported by newer <a href="http://www.joomlabamboo.com">Joomla Bamboo</a> Templates too. We are sure that as people catch onto the benefits of using Prothemer Morph, then other clubs will follow suit shortly.
</p>');
//Tips and Advanced Usage
DEFINE('_HLPR_DASH_USAGE_TIPS', '<dl>
        <dt>How do I use presets?</dt>
        <dd><p>Presets require a tiny bit more coding than just setting up the parameters, but they give you a lot more power.</p> 
        <p>They are really just a way to update some or all of the parameters at once with pre decided values. This is to allow template developers the ability to pick good color/image combinations in advance so your users do not have to try and guess what will look good.</p>
        <p>To use them, do the following in the morphDetails.xml file.</p>
        <ul>
        <li>Below your main &lt;/params&gt; tag create &lt;presets&gt; &lt;/presets&gt; tags</li>
        <li>Inside this tagset, create a &lt;preset name="Preset Name"&gt; &lt;/preset&gt; tagset for each preset you want, changing Prest Name for each one.</li>
        <li>Inside each &lt;preset&gt; tag set, create a &lt;param name="param_name" default="Preset Value"&gt;&lt;/param&gt; tagset for each parameter you want to change.
        </ul>
        </dd>
        <dt>Why would I use a custom php file?</dt>
        <dd><p>Custom php files are used when a template designer wants to dynamically create paramaters based on the environment of the person running it. Inside the file you can do anything you do in a normal Joomla PHP file.</p>
        <p>This could be used to do selects from the database, or hide/show a parameter based on the access level of the person viwing the page, or change parameters based on the enviroment of the server. Anything you like</p>.
        </dd>
        <dt>How do I add a custom php file?</dt>
        <dd><p>To add a custom php file, simply put a file named morphCustom.php in the template root. This file will be picked up automatically by Morph.</p>
        <p>The only requirements are that everything is wrapped inside a function called -> getCustomMorphParams() and the function returns a set of &lt;param &gt;&lt;/param&gt; tags formated the same as any other Morph parameter tagset.</p>
        </dd>
        <dt>Why would I use a custom JavaScript file?</dt>
		<dd><p>Custom Javascript files are used to add advanced options to your parameters. The most likely candidates being color or date pickers, or validation scripts. But really you could do anything, create drag and drop parameters, ajax functios, whatever you like.</p></dd>
		<dt>How do I use a custom JavaScript file?</dt>
		<dd><p>All morph parameters carry a css id when they are displayed in the editing screen. This id can be used by your javascripts to attach themselves to any parameter they like and any action they like.</p>
		<p>To actually get your scripts into Morph, create a file called morph.js in the template root and put yoru js code inside this file. It will get picked up by morph automatically.</p></dd>
		<dt>Why would I use a custom CSS file?</dt>
		<dd><p>Custom CSS files are used to add extra styling to your parameters. You can add images, a company logo, highlights on particular parameters, tooltip styling, or even add the styling neded by a date or color picker which was in your custom JavaScript file.</p></dd>
		<dt>How do I use a custom CSS file?</dt>
		<dd><p>All morph parameters carry a css id, and most classes as well, when they are displayed in the editing screen. This id can be referenced by your CSS to make any required changes.</p>
		<p>To actually get your CSS into Morph, create a file called morph.css in the template root and put your js code inside this file. It will get picked up by morph automatically.</p></dd>
    </dl>');
//Trouble Shooting FAQ
DEFINE('_HLPR_DASH_USAGE_TS', '<dl>
        <dt>My parameters don&apos;t show up, or stop halfway down the page.</dt>
        <dd>Check that all your xml tags are closed properly.</dd>
        </dl>');
//Changelog HTML
DEFINE('_HLPR_DASH_CHANGE', 
     '<b>Version:</b> 1.0 <br/>
      <b>Date:</b> May 2008  <br/>
      <b>State:</b> Initial Release<br/>
      <ul>
        <li>Edit parameters with an easy to use component interface.</li>
        <li>Include custom JavaScript files to add validation or advanced interaction to parameters.</li>
        <li>Include custom css files to style your parameters.</li>
        <li>Include custom php files to create dynamic parameters.</li>
      </ul>');

?>