<?php
$eh = $_GET['eh']; // editor highlighting
$sk = $_GET['sk']; // Session keepalive
$lt = (int) $_GET['slt']; // Session time
header('content-type: text/javascript; charset: UTF-8');
?>

(function($){
// Configurator base class
this.Configurator = {
	
	//Utility function for reducing the amount of repeated code when initiating a dialog
	dialog: function(options){
		return $.extend({
			minHeight: 20,
			modal: true,
			stack: false,
		}, options);
	}
	
};
})(jQuery);

function submitform(pressbutton){
    if (pressbutton) {
        jQuery('[name=action]', document.adminForm).attr('value', pressbutton);
    }
    if (typeof document.adminForm.onsubmit == "function") {
        document.adminForm.onsubmit();
    }
    document.adminForm.submit();
}

jQuery.noConflict()(function($){

	//Define the Nooku token for all ajax requests, by grabbing the value of the DOM for now
	$.ajaxSetup({beforeSend: function(xhr){
		xhr.setRequestHeader('X-Token', $('input[name=_token]').val());
	}});

	$('#innersidebarinner_width_type-lbl').parent().addClass('append-select');
	<?php include 'functions/common.js' ?>
	$.preloadCssImages();
	

	$("input[type=text], textarea").focus(function(){
		this.select();
	});
	
	if($.cookie('save_msg')){
		$('#element-box').before('<dl id="system-message"><dt class="message">Message</dt><dd class="message message fade"><ul><li>Successfully saved your settings</li></ul></dd></dl>');	
		$('#system-message').delay(3000, function(){ $('#system-message').fadeOut().remove(); });
		$.cookie('save_msg', null);
	}
	
	<?php if($sk == 'warn' && $lt > 5) : ?>
		<?php $timeout = max(($lt - 5) * 60000, 300000) ?>
		function endsession()
		{
			$.ajax({
				method: 'get', 
				data:{
					option: 'com_login', 
					task: 'logout'
				}, 
				complete: function(){ 
					window.location.reload(true); 
				}
			});
		};
		$('#content-box').after('<div id="session-message" class="dialog-msg" style="display:none;"><p>If your session ends, you\'re automatically logged out of the admin. And will see a login form after the page is refreshed. </p>'
								+'<p><strong>Your session ends in<br /><span id="keepalive-minute"><span id="keepalive-minutes" class="keepalive-countdown">05</span> minutes and </span><span id="keepalive-seconds" class="keepalive-countdown">00</span> seconds.</strong></p></div>');
		var keepalive = function()
		{
			var minutes = 5,
				seconds = 60,
				countdown = setTimeout(function(){ endsession(); }, 300000);
			
			hideScroll();
			$('#session-message').dialog(Configurator.dialog({
					bgiframe: true, 
					resizable: false,
					draggable: false,
					width: 350,
					title: 'Your session is about to timeout',
					overlay: {
						backgroundColor: '#000', 
						opacity: 0.5
					},
					close: function(){
						showScroll();
					},
				buttons: {
					'End Session': function(){
						endsession();
					},
					'Renew Session': function(){
						$(this).dialog('destroy');
						$.ajax({method: 'get'});
						minutes = 5;
						seconds = 60;

						$('#keepalive-minutes').text('05');
						$('#keepalive-seconds').text('00');

						$('#keepalive-minute').show();
						clearInterval(sectimer);
						clearTimeout(countdown);
						var sessiontimer = setTimeout(keepalive, <?php echo $timeout ?>);
					}
				}
			}));
			var sectimer = setInterval(function(){
				if(seconds == 0) seconds = 60;
				if(seconds == 60 && minutes > 0) $('#keepalive-minutes').text('0'+(--minutes));
				if(minutes === 0) $('#keepalive-minute').hide();
				--seconds;
				text = new String(seconds).length > 1 ? seconds : '0' + seconds;
				$('#keepalive-seconds').text(text);
			}, 1000);
		};
		var sessiontimer = setTimeout(keepalive, <?php echo $timeout ?>);
	<?php endif ?>

	<?php if($sk == 'keepalive' || $sk == 'warn' && $lt <= 5) : ?>
		var keepalive = function(){ $.ajax({method: 'get'}); };
		var sessiontimer = setInterval(keepalive, <?php echo (int) max(($lt * 60000) / 2, 30000) ?>);
	<?php endif ?>

	$('.itoggle-ready').iToggle({
		easing:'easeOutExpo',
		type:'toggle',
		keepLabel:false,
		easing:'easeInExpo',
		speed:300
	});


	<?php include 'functions/user.js'; ?>
	
	/* Generic ----------------------------
	------------------------------------ */
	$("#tabs ol.forms li:first-child").addClass("first");
	
	$("#submenu li:last, #blocks-tabs .ui-tabs-nav li:last, #tabs ol.forms li:last-child, #preferences-form .prefs li:last").addClass("last");
	
	$("#submenu li:first").addClass("dashboard");
	$("#tabs .options-panel").wrapInner('<div class="options-inner"></div>');


	$("#tabs ol.forms li:odd").addClass("alt");	


	
	$("#help").hover(function () {
	  $(this).switchClass("on", "off", 15000);
		}, function() {
	  $(this).switchClass("off", "on", 15000);
	});

	$('#system-message').delay(3000, function(){
		$('#system-message').fadeOut();
	});
	$('.cfg-message a.close-msg').click(function(){
		$(this).parent().parent().fadeOut();
		$.cookie('notice', 'memory', { expires: 730 });
		return false;
	})
	
	function notice_dialog(title, file, link_id){
		$('<div class="toolguides"></div>').dialog(Configurator.dialog({
			bgiframe: true,
			autoOpen: false,
			width: 400,
			height: 280,
			title: title,
			overlay: {
				'background-color': '#000', 
				opacity: 0.8 
			}
	   	}));
	
		$('a'+link_id).click(function(){
			$('.toolguides').load('../administrator/components/com_configurator/tooltips/'+file, function(){
				$('.toolguides').dialog('open');
			});
			return false;
		});
	}
	
	notice_dialog('Memory Limit', 'memory_limit.html', '#readmore-memory');

	if ($("#toolbar-box div.header").val() == " Configurator "){
		$("#toolbar-box div.header").text(" Configurator Manage ");
	}
	
	if ($("#backgroundsbg_image option:first").val() == ""){
	$("#backgroundsbg_image option:first").text("None");
	}

	$("#footer").fadeTo("slow", 0.3).hover(
		function(){ $(this).fadeTo("slow", 1); },	// mousein
		function(){ $(this).fadeTo("slow", 0.3); }  // mouseout
	);

	$(".upload-themelet").live("click", function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#tools-tabs").tabs();
		maintabs.tabs("select",4);
		subtabs.tabs("select",0);
		$('#install-type label.label-selected').removeClass('label-selected');
		$("#upload_themelet").attr("checked",true).parent().addClass('label-selected');
		return false;
	});
			
	$(".upload-logo").live("click", function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#tools-tabs").tabs();
		maintabs.tabs("select",4);
		subtabs.tabs("select",0);
		$('#install-type label.label-selected').removeClass('label-selected');
		$("#upload_logo").attr("checked",true).parent().addClass('label-selected');
		return false;
	});

	$(".upload-bg").live("click", function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#tools-tabs").tabs();
		maintabs.tabs("select",4);
		subtabs.tabs("select",0);
		$('#install-type label.label-selected').removeClass('label-selected');
		$("#upload_background").attr("checked",true).parent().addClass('label-selected');
		return false;
	});
	
	$(".upload-iphone").live("click", function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#tools-tabs").tabs();
		maintabs.tabs("select",4);
		subtabs.tabs("select",0);
		$('#install-type label.label-selected').removeClass('label-selected');
		$("#upload_iphone").attr("checked",true).parent().addClass('label-selected');
		return false;
	});

	$(".logo-tab").live("click", function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#customize-tabs").tabs();
		maintabs.tabs("select",1);
		subtabs.tabs("select",1);
		return false;
	});
	
	$(".masthead-tab").live("click", function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#blocks-tabs").tabs();
		maintabs.tabs("select",2);
		subtabs.tabs("select",1);
		return false;
	});		

	$(".backgrounds-tab").live("click", function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#customize-tabs").tabs();
		maintabs.tabs("select",1);
		subtabs.tabs("select",2);
		return false;
	});

	$(".themelet-tab").live("click", function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#customize-tabs").tabs();
		maintabs.tabs("select",1);
		subtabs.tabs("select",0);
		return false;
	});
	
	$(".topnav-tab").live("click", function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#blocks-tabs").tabs();
		maintabs.tabs("select",2);
		subtabs.tabs("select",3);
		return false;
	});		

	$(".menu-tab").live("click", function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#customize-tabs").tabs();
		maintabs.tabs("select",1);
		subtabs.tabs("select",3);
		return false;
	});	
	
	$("#utilities .menuitem").bind("click", function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#site-tabs").tabs();
		maintabs.tabs("select",0);
		subtabs.tabs('select','menuitems-tab');
		return false;
	});	

	$(".sidebar-tab").live("click", function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#blocks-tabs").tabs();
		maintabs.tabs("select",2);
		subtabs.tabs("select",7);
		return false;
	});	
	
	if($.cookie('fullscreen') == 'yes'){
		$('#minwidth-body').addClass('fullscreen');
		$('#toolbar-fullscreen a').text('Normal Mode');
	}
	
	$('#toolbar-fullscreen a').click(function(){
		$('#minwidth-body').toggleClass("fullscreen");
		$('#toolbar-fullscreen').toggleClass("normal-mode");
		if($('#toolbar-fullscreen a').text() == 'Fullscreen'){ 
			$('#toolbar-fullscreen a').text('Normal Mode'); 
			$.cookie('fullscreen', 'yes', { path: '/', expires: 30 });
		}else{ 
			$('#toolbar-fullscreen a').text('Fullscreen'); 
			$.cookie('fullscreen', 'no', { path: '/', expires: 30 });
		}
		return false; 
	});

	$('#quicktips a').click(function(){
		$(this).after('<div id="tips-dialog">Tips can be re-enabled in the Preferences.</div>');
		$('#tips-dialog').dialog({
			bgiframe: true,
			modal: true,
			maxHeight: 100,
			buttons: {
				'Ok': function(){
					$(this).dialog('destroy');
				}
			},
			overlay: {
				'background-color': '#000',
				opacity: 0.9
			},
			title: 'Tips'
		});
		$('#cfgquick_tips1').removeAttr('checked');
		$('#cfgquick_tips0').attr('checked', 'checked');
		$('#preferences-form').submit(function(){
   			$(this).ajaxSubmit({
   				type: 'POST',
   				url: '?option=com_configurator&view=configuration&format=raw',
   				data: {
   					option: 'com_configurator',
   					action: 'saveprefs'
   				},
	   			success: function(data, textStatus){
					$('#tips').remove();
	   			}
   			});
   			return false;
   		});
   		$('#preferences-form').trigger('submit');
		return false; 
	});		
	$('#site-desc a.close').click(function(){
		$('#site-desc').hide('slow');
		$('#site-tabs .desc-overlay').fadeTo('fast',0).remove();
		$.cookie('site-desc', true,{path:'/',expires:30});
		$.cookie('hideintros', true);
		return false; 
	});
	$('#themelet-desc a.close').click(function(){
		$('#themelet-desc').hide('slow');
		$('#customize-tabs .desc-overlay').fadeTo('fast',0).remove();
		$.cookie('themelet-desc', true,{path:'/',expires:30});
		$.cookie('hideintros', true);
		return false; 
	});
	$('#plugins-desc a.close').click(function(){
		$('#plugins-desc').hide('slow');
		$('#plugins-tabs .desc-overlay').fadeTo('fast',0).remove();
		$.cookie('plugins-desc', true,{path:'/',expires:30});
		$.cookie('hideintros', true);
		return false; 
	});
	$('#tools-desc a.close').click(function(){
		$('#tools-desc').hide('slow');
		$('#tools-tabs .desc-overlay').fadeTo('fast',0).remove();
		$.cookie('tools-desc', true,{path:'/',expires:30});
		$.cookie('hideintros', true);
		return false; 
	});
	$('#assets-desc a.close').click(function(){
		$('#assets-desc').hide('slow');
		$('#assets-tabs .desc-overlay').fadeTo('fast',0).remove();
		$.cookie('assets-desc', true,{path:'/',expires:30});
		$.cookie('hideintros', true);
		return false; 
	});
	$('#blocks-desc a.close').click(function(){
		$('#blocks-desc').hide('slow');
		$('#blocks-tabs .desc-overlay').fadeTo('fast',0).remove();
		$.cookie('blocks-desc', true,{path:'/',expires:30});
		$.cookie('hideintros', true);
		return false; 
	});
	
	// disable active asset links
	$('.tl-active ul.buttons li.btn-activate a, .tl-active ul.buttons li.btn-delete a')
	.fadeTo('fast', 0.5)
	.attr('href', '#inactive')
	.click(function(e){ e.preventDefault; return false; });
	
	$("input, textarea", $("form")).focus(function(){
	$(this).addClass("focus");
	$(this).parents("ol.forms").addClass("cur");
	});
	$("input, textarea", $("form")).blur(function(){
		$(this).removeClass("focus");
		$(this).parents("ol.forms").removeClass("cur");
	});
	
$('#install-type input[type="radio"]').click( function(){
	$(this).attr('checked', 'checked');
	$('#install-type label.label-selected').removeClass('label-selected');
	$(this).parent().addClass('label-selected');
});
	

$('.text_area').simpleautogrow();
	
	if(!$.cookie('configurator-tabs')) $.cookie('configurator-tabs', '{}', {expires: 30});
	var tabs = $.parseJSON($.cookie('configurator-tabs'));

	   	/* Tabs -------------------------------
	------------------------------------ */
	[
		'tabs',
		'site-tabs',
		'customize-tabs',
		'blocks-tabs',
		'plugins-tabs',
		'tools-tabs',
		'assets-tabs'
	].each(function(tab){
		var selected = tabs[tab] ? tabs[tab] : 0;
		$('#'+tab).tabs({ 
			selected: selected,
			select: function(event, ui){
				var tabs = $.parseJSON($.cookie('configurator-tabs'));
				tabs[tab] = ui.index;
				$.cookie('configurator-tabs', $.toJSON(tabs));
			}
		});
	});

	$('#tabs .ui-tabs-panel').removeClass("ui-corner-bottom");
	$("#customize").removeClass("ui-widget-content");			
	$("#assets-tabs li.icon-backup").removeClass("ui-state-disabled");	

	<?php include 'functions/colorpicker.js'; ?>
 	
 	//all hover and click logic for buttons
	$(".fg-button:not(.ui-state-disabled)")
	.mousedown(function(){
			$(this).parents('.fg-buttonset-single:first').find(".fg-button.ui-state-active").removeClass("ui-state-active");
			if( $(this).is('.ui-state-active.fg-button-toggleable, .fg-buttonset-multi .ui-state-active') ){ $(this).removeClass("ui-state-active"); }
			else { $(this).addClass("ui-state-active"); }	
	})
	.mouseup(function(){
		if(! $(this).is('.fg-button-toggleable, .fg-buttonset-single .fg-button,  .fg-buttonset-multi .fg-button') ){
			$(this).removeClass("ui-state-active");
		}
	});
	
	$('.updates-help-link').click(function(){
		$('#getting-started').load('?option=com_configurator&view=help&layout=gettingstarted&format=raw', function(){
			if($.cookie('info')){ $.cookie('info', null); }
			var gstabs = $('#splash').tabs();
			gstabs.tabs('select', 2);
			return welcomeScreen();
		});
		return false;
	});
			
	$("#toggle-shelf").click(function(){
		toggleShelf($(this));
		return false;
	});
	function toggleShelf(e){
		if(typeof $.cookie('shelf') == undefined || $('#toggle-shelf').attr('toggle') == 'show'){
			$('#shelf-contents').slideUp('normal');
			$('#shelf').addClass('closed').removeClass('open');
			$('#toggle-shelf').text('Show Shelf');
			$('#toggle-shelf').attr('toggle', 'hide');
			$.cookie('shelf', 'hide', { path: '/', expires: 30 });
		}else{
			$('#shelf-contents').slideDown('normal');
			$('#shelf').addClass('open').removeClass('closed');
			$('#toggle-shelf').text('Hide Shelf');
			$('#toggle-shelf').attr('toggle', 'show');
			$.cookie('shelf', null, { path: '/', expires: 30 });
		}
		return false;
	}
	
	<?php include 'functions/assets.js'; ?> 

	$("#report-bug").dialog({
		bgiframe: true,
		autoOpen: false,
		minHeight: 300,
		buttons: false,
		width: 600,
		modal: true,
		overlay: {
			'background-color': '#000',
			opacity: 0.8
		}
	});
	$('.report-bug, #toolbar-report-bug-link, #toolbar-report-bug-email-link a').click(function() {
		$('#report-bug').dialog('open');
		return false;
	});
	
	$('#ff-reset').click(function(){ 
		$('#report-bug').dialog('close'); 
		if($.cookie('bug')){ $.cookie('bug', null); }
		return false;
	});
	
	$('.ff-submit').click(function(){
		
		$('#feedbackform').submit(function(){
			function validate(formData, jqForm, options) { 
				for (var i=0; i < formData.length; i++) { 
					if (!formData[i].value) { 
						$('<div class="dialog-msg">All fields are required</div>').dialog({
							bgiframe: true,
							autoOpen: true,
							stack: true,
							title: 'Error',
							buttons: {
								'Ok': function(){
									$(this).dialog('destroy');
								}
							},
							modal: true,
							overlay: {
								'background-color': '#000',
								opacity: 0.8
							}
						});
						return false; 
					} 
				}
				ptOverlay('Processing');
				return true; 
			}
		
			$(this).ajaxSubmit({
				beforeSubmit: validate,
				type: 'GET',
				dataType: 'jsonp',
				contentType: "application/json; charset=utf-8",
				url: 'http://www.joomlajunkie.com/secure/configurator/bug-report.php?jsoncallback=?',
				data: {
					'do': 'send-feedback',
					'ff-name': $('#feedbackform input[name="name"]').val(),
					'ff-email': $('#feedbackform input[name="email"]').val(),
					'ff-type': $('#feedbackform input[name="type"]').val(),
					'ff-category': $('#feedbackform input[name="category"]').val(),
					'ff-title': $('#feedbackform input[name="title"]').val(),
					'ff-message': $('#feedbackform textarea[name="description"]').val(),
					'ff-specs': $('#feedbackform textarea[name="specs"]').val($('#ff-specs').text())
				},
				success: function(data, status, error){
					close_ptOverlay()
					if(typeof(data.error) != 'undefined'){						
						if(data.error != ''){
							$('<div>'+data.error+'</div>').dialog({
								bgiframe: true,
								autoOpen: true,
								stack: true,
								title: 'Error',
								buttons: {
									'Ok': function(){
										$(this).dialog('destroy');
									}
								},
								modal: true,
								overlay: {
									'background-color': '#000',
									opacity: 0.8
								}
							});
						}
					}else{
						$('<div class="dialog-msg">'+data.message+'</div>').dialog({
							bgiframe: true,
							autoOpen: true,
							stack: true,
							title: 'Success',
							buttons: {
								'Ok': function(){
									$(this).dialog('destroy');
								}
							},
							modal: true,
							overlay: {
								'background-color': '#000',
								opacity: 0.8
							}
						});
						$('#feedbackform').resetForm();
						$('#report-bug').dialog('close');
						if($.cookie('bug')){ $.cookie('bug', null); }
					}
				},
				error: function(data){
					$('<div>'+data+'</div>').dialog({
						bgiframe: true,
						autoOpen: true,
						stack: true,
						title: 'Error',
						buttons: {
							'Ok': function(){
								$(this).dialog('destroy');
							}
						},
						modal: true,
						overlay: {
							'background-color': '#000',
							opacity: 0.8
						}
					});
				}
			});
			return false;
		});
		$('#feedbackform').trigger('submit');
		return false;
	});
 		 	
	
	/* Tooltips ----------------------
	------------------------------- */
	// info tooltip
	$('.tt-inline').each(function(){
		$this = $(this);
		var thetitle = $(this).attr("title").split('::'); 
   		var qtTitle = thetitle[1];
   		$this.qtip({
				content: qtTitle ,
		   	show: 'mouseover',
		   	hide: 'mouseout',
			style: { 
				  width: 300,
				  padding: 10,
				  background: '#9AC5DF',
				  color: '#111',
				  textAlign: 'left',
				  border: {
					 width: 1,
					 radius: 5,
					 color: '#006699'
				  },
		   		tip: 'bottomLeft'
		   	},
		   	position: {
				corner: {
				   tooltip: 'bottomLeft',
				   target: 'topRight'
				}
			 }
		});
		
		$(this).attr('title', '');
	});
	// info tooltip
   	$('.ttim').each(function(){
		var thetitle = $(this).attr("title");
   		
   		$(this).qtip({
				content: thetitle ,
		   	show: 'mouseover',
		   	hide: 'mouseout',
		   	style: {
				width: 300,
				padding: 10,
		   		name: 'light',
				background: '#CAEFA5',			   		
				color: '#111',
		   		border: {
					width: 1,
					radius: 5,
					color: '#536E28'
		   		},
		   		tip: true,
		   		margin: 0
		   	},
		   	position: {
				corner: {
				   tooltip: 'bottomLeft',
				   target: 'topRight'
				}
			 }
		});
		$(this).attr('title', '');
	});
			
	$('.tt-modal').click(function(){
		var docroot = '../administrator/components/com_configurator/tooltips/'; // define doc root for pulling the docs
   		var thetitle = $(this).attr("title").split('::'); 
   		var qtTitle = thetitle[0];
   		var qtLink = docroot+thetitle[1];
   		
   		hideScroll();
   		$('.toolguides').load(qtLink);
   		$('.toolguides').dialog({
			autoOpen: true,
			bgiframe: true,
			modal: true,
			width: 700,
			height: 700,
			title: qtTitle,
			zIndex: 5001,
			close: function(){
				$('.toolguides').dialog('destroy');
				showScroll();
				$('.toolguides').empty();
			}
		});
   		return false;
   	});
   	
   	
   	
   	$('a.modal-link').click(function(){
   		hideScroll();
   		$('.toolguides').load('../administrator/components/com_configurator/tooltips/'+$(this).attr('href'));
   		$('.toolguides').dialog({
			autoOpen: true,
			bgiframe: true,
			modal: true,
			width: 700,
			height: 700,
			title: $(this).attr('title'),
			zIndex: 5001,
			close: function(){
				$('.toolguides').dialog('destroy');
				showScroll();
				$('.toolguides').empty();
			}
		});
		return false;
	});
	
	$('a.modal-link-img').click(function(){
		hideScroll();
		$('.toolguides').load('../administrator/components/com_configurator/tooltips/'+$(this).attr('href'));
		$('.toolguides').dialog({
			autoOpen: true,
			bgiframe: true,
			modal: true,
			width: 661,
			height: 730,
			title: $(this).attr('title'),
			zIndex: 5001,
			close: function(event, ui){
				$('.toolguides').empty();
				$('.toolguides').dialog('destroy');
				showScroll();		
			}
		});
		return false;
	});
			
	/* Logo Options -----------------------
	------------------------------------ */
	function logoPreview(elid, type){
		if($(elid).val() != null && type != 'bg'){
			var imageTitle  = $(elid).val(); 
			var updatedTitle = imageTitle;
			$(elid).after('<span class="logo-preview" title="'+imageTitle+'">&nbsp;<span>Preview</span></span><span class="upload-logo-container">(<a href="#" class="upload-logo">Upload Logo</a>)</span>');
			$('.logo-preview').each(function(){
				$(this).attr('title', '');
				$(this).qtip({
		   			content: '<img class="logo-preview-image" src="../morph_assets/logos/'+updatedTitle+'" />',
					position: { corner: { tooltip: 'bottomMiddle', target: 'topMiddle' } },
					style: { tip: { corner:'bottomMiddle' }, name: 'dark', background: '#fff', border: { width: 3, radius: 8 }, padding: '0px', margin: '0px' }
				});
			});
			$(".upload-logo").click(function(){
				var maintabs = $("#tabs").tabs();
				var subtabs = $("#tools-tabs").tabs();
				maintabs.tabs("select",4);
				subtabs.tabs("select",0);
				$('#install-type label.label-selected').removeClass('label-selected');
				$("#upload_logo").attr("checked",true).parent().addClass('label-selected');
				return false;
			});
			$(elid).change(function(){
				$(elid +' option:selected').each(function(){
					$('.logo-preview').attr('title', $(this).val());
					$('.logo-preview').qtip("destroy");
					$('.logo-preview').attr('title', '');
					$('.logo-preview').qtip({
					   	content: '<img src="../morph_assets/logos/'+this.value+'" />',
						position: { corner: { tooltip: 'bottomMiddle', target: 'topMiddle' } },
						style: { tip: { corner:'bottomMiddle' }, name: 'dark', border: { width: 3, radius: 8 }, padding: '0px', margin: '0px' }
					});
					return updatedTitle = this.value;
				});
			});
		}else{
			if(type != 'bg'){
				$(elid).css('display', 'none').after('<span class="no-logo">No Logos. <a href="#" class="upload-logo">Upload?</a></span>');
				$(".upload-logo").click(function(){
					var maintabs = $("#tabs").tabs();
					var subtabs = $("#tools-tabs").tabs();
					maintabs.tabs("select",4);
					subtabs.tabs("select",0);
					$('#install-type label.label-selected').removeClass('label-selected');
					$("#upload_logo").attr("checked",true).parent().addClass('label-selected');
					return false;
				});
			}else{
				if($(elid).val() == '' && $(elid).children().size() == 1){
					$(elid).css('display', 'none').after('<span class="no-logo">No Backgrounds. <a href="#" class="upload-bg">Upload?</a></span>');
					$(".upload-bg").click(function(){
						var maintabs = $("#tabs").tabs();
						var subtabs = $("#tools-tabs").tabs();
						maintabs.tabs("select",4);
						subtabs.tabs("select",0);
						$('#install-type label.label-selected').removeClass('label-selected');
						$("#upload_background").attr("checked",true).parent().addClass('label-selected');
						return false;
					});
				}else{
					$(elid).after('<span class="upload-bg-container">(<a href="#" class="upload-bg">Upload BG</a>)</span>');
					$(".upload-bg").click(function(){
						var maintabs = $("#tabs").tabs();
						var subtabs = $("#tools-tabs").tabs();
						maintabs.tabs("select",4);
						subtabs.tabs("select",0);
						$('#install-type label.label-selected').removeClass('label-selected');
						$("#upload_background").attr("checked",true).parent().addClass('label-selected');
						return false;
					});
				}
			}
		}
		
	}
	
	logoPreview('#logologo_image');
	logoPreview('#backgroundsbg_image', 'bg'); 

	/* Uploader ------------------------
	--------------------------------- */
	
	$('#uploader-btn').click(function(){
		
		ptOverlay('Installing...');
		
		var uploadType = $('input[type="radio"]:checked','#install-type').val();
		$.ajaxFileUpload({
			url: '?option=com_configurator&view=configuration&format=raw&do=upload&itype='+uploadType,
			fileElementId:'insfile',
			dataType: 'json',
			success: function (data, status){
				close_ptOverlay();
				if(typeof(data.error) != 'undefined'){
					if(data.error != ''){
						hideScroll();
						$('#upload-message').dialog(Configurator.dialog({
				   			bgiframe: true, 
				   			resizable: false,
				   			draggable: false,
				   			width: 350,
							autoOpen: false,
				   			title: 'Error',
		   					overlay: {
		   						backgroundColor: '#000000', 
		   						opacity: 0.8 
		   					},
							buttons: {
								'OK': function(){
									$(this).dialog('close');
									showScroll();
								}
							}
						}));
						$('#upload-message').html('<p>'+data.error+'</p>');
						$('#upload-message').dialog('open');
					}else{

						hideScroll();
						$('#upload-message').dialog(Configurator.dialog({
				   			bgiframe: true, 
				   			resizable: false,
				   			draggable: false,
					   		width: 350,
							autoOpen: false,
				   			title: 'Success',
				   			close: function(){
				   				showScroll();
				   			},
		   					overlay: {
		   						backgroundColor: '#000', 
		   						opacity: 0.8 
		   					}
		   				}));
		   				
		   				if(uploadType == 'template'){
							$('#upload-message').html(data.success);
							$('#upload-message').dialog(
								'option', 'buttons', { 
									'Ok': function(){
										$(this).dialog('destroy');
  									  	showScroll();
									}
								}
							);
							$('#upload-message').dialog('open');
						}
						if(uploadType == 'themelet_assets'){
							$('#upload-message').html(data.success);
							$('#upload-message').dialog(
								'option', 'buttons', { 
									'Ok': function(){
										$(this).dialog('destroy');
  									  	ptOverlay('Reloading interface...');
										var $tabs = $('#tabs').tabs();
										var assetsTabs = $('#assets-tabs').tabs();
										$tabs.tabs('select', 5);
										assetsTabs.tabs('select', 0);
										window.location.reload(true);
									}
								}
							);
							$('#upload-message').dialog('open');
						}
						if(uploadType == 'themelet'){
							var backupmsg;
							// check if uploaded themelet is the same as the active themelet.
							$.ajax({
								url: '?option=com_configurator&view=configuration&format=raw',
								data: {
									action: 'get_current_themelet',
									_token: $('input[name=_token]').val()
								},
								type: 'POST',
								success: function(d){
									if(data.themelet == d){
										close_ptOverlay();
										$('#upload-message').html('<div class="dialog-msg">Themelet upgraded successfully.</div>');
										$('#upload-message').dialog(
											'option', 'buttons', { 
												'Ok': function(){
													$(this).dialog('destroy');
													var $tabs = $('#tabs').tabs();
													var assetsTabs = $('#assets-tabs').tabs();
													$tabs.tabs('select', 5);
													assetsTabs.tabs('select', 0);
												}
											}
										);
										$('#upload-message').dialog('open');											
									}else{
										if(data.backuploc != '') { backupmsg = '<p><br /><strong>Your existing themelet files were backed up to: </strong><small>'+data.backuploc+'</small></p>'; }else{ backupmsg = ''; }
										$('#upload-message').html('<div class="dialog-msg">'+data.success+backupmsg+'</div>');
										$('#upload-message').dialog(
											'option', 'buttons', { 
												'Activate Themelet': function(){
													$(this).dialog('destroy');
													function actThemelet(){
														ptOverlay('Processing...');
														var setThemelet = data.themelet;
														var themeletOption = $('#generalthemelet option:last').after('<option selected="selected" value="'+setThemelet+'">'+setThemelet+'</option>');
														$('#templateform').submit(function(){
												   			$(this).ajaxSubmit({
												   				type: 'POST',
												   				url: '?format=raw',
												   				data: {
												   					option: 'com_configurator',
												   					action: 'apply',
												   					isajax: 'true'
												   				},
													   			success: function(data, textStatus){
													   				$.ajax({
													   					url: '?option=com_configurator&view=configuration&themelet='+setThemelet+'&format=raw',
													   					data: {
													   						themelet: setThemelet,
													   						action: 'themelet_activate',
													   						_token: $('input[name=_token]').val()
													   					},
													   					type: 'POST',
													   					success: function(ts, data){
													   						return true;
													   					}
													   				});
																	$.ajax({
																		url: '?option=com_configurator&view=configuration&themelet='+setThemelet+'&format=raw',
																		type: 'POST',
																		data: {
																			themelet: setThemelet,
																			action: 'themelet_check_existing',
																			_token: $('input[name=_token]').val()
																		},
																		dataType: 'json',
																		success: function(data, ts){
																			if(data.exists == 'true'){
																				close_ptOverlay();
																				hideScroll();
																				$('<div class="dialog-msg check">It seems that you have used this themelet before.<br />Would you like to restore your <strong>previous settings</strong>, or would you like to use the <strong>themelet defaults</strong></div>').dialog(Configurator.dialog({
																		   			bgiframe: true,
																		   			width: 500,
																		   			title: 'Activate',
																		   			overlay: {
																		   				'background-color': '#000', 
																		   				opacity: 0.8 
																		   			},
																		   			close: function(){
																						$(this).dialog('destroy');
																						// change to assets tab
																						ptOverlay('Reloading Management Interface...');
																						var mainTabs = $('#tabs').tabs();
																						var subTabs = $('#assets-tabs').tabs();
																						mainTabs.tabs('select', 5);
																						subTabs.tabs('select', 0);
																						window.location.reload(true);
																		   			},
																					buttons: { 
																						'Themelet Default': function(){
																							var $this = $(this);
																							$this.dialog('close');
																			   			},
																			   			'Previous Settings': function(){
																							$this = $(this);
																			   				$.ajax({
																								url: '?option=com_configurator&view=configuration&themelet='+setThemelet+'&format=raw',
																								data: {
																									themelet: setThemelet,
																									action: 'themelet_activate_existing',
																									_token: $('input[name=_token]').val()
																								},
																								type: 'POST',
																								success: function(data){
																									$this.dialog('close');
																									return true;
																								}
																							});
																			   			}
																			   		}
																			   	}));
																			}else{
																				// change to assets tab
																				ptOverlay('Processing...');
																				var mainTabs = $('#tabs').tabs();
																				var subTabs = $('#assets-tabs').tabs();
																				mainTabs.tabs('select', 5);
																				subTabs.tabs('select', 0);
																				window.location.reload(true);
																			}
																		}
																	});
																	return false;
																}
												   			});

												   			return false;
												   		});
														$('#templateform').trigger("submit");												
												   	}
												   	checkChanges(actThemelet);
												},
												'Cancel': function(){
													$(this).dialog('destroy');
													ptOverlay('Processing...');
													var $tabs = $('#tabs').tabs();
													var assetsTabs = $('#assets-tabs').tabs();
													$tabs.tabs('select', 5);
													assetsTabs.tabs('select', 0);									
													window.location.reload();
												}
											}
										);
										$('#upload-message').dialog('open');
									}
								}
							});
						}
						
						if(uploadType == 'logo'){
							$('#upload-message').html(data.success);
							$('#upload-message').dialog(
								'option', 'buttons', { 
									'Activate': function(){
										$(this).dialog('destroy');
										function actLogo(){
											var setLogo = data.logo;
											var logoOption = $('#logologo_image option:last').after('<option selected="selected" value="'+setLogo+'">'+setLogo+'</option>');
		   									submitbutton('apply');
		   									var $tabs = $('#tabs').tabs();
											var logoTabs = $('#customize-tabs').tabs();
											$tabs.tabs('select', 1);
											logoTabs.tabs('select', 1);
											$(this).dialog('destroy');
											showScroll();
										}
										checkChanges(actLogo);
									},
									'Configure': function(){
										var $tabs = $('#tabs').tabs();
										var logoTabs = $('#customize-tabs').tabs();
										$tabs.tabs('select', 1);
										logoTabs.tabs('select', 1);
										window.location.reload(true); 
  									  	$(this).dialog('destroy');
  									  	showScroll();
									}
								}
							);
							$('#upload-message').dialog('open');
						}
						if(uploadType == 'background'){
							$('#upload-message').html('<div class="dialog-msg">'+data.success+'</div>');
							$('#upload-message').dialog(
								'option', 'buttons', { 
									'Activate': function(){
										$(this).dialog('destroy');
										function actBg(){
											var setBg = data.background;
											var logoBg = $('#backgroundsbg_image option:last').after('<option selected="selected" value="'+setBg+'">'+setBg+'</option>');
		   									submitbutton('apply');
		   									var $tabs = $('#tabs').tabs();
											var bgTabs = $('#customize-tabs').tabs();
											$tabs.tabs('select', 1);
											bgTabs.tabs('select', 2);
											$(this).dialog('destroy');
											showScroll();
										}
										checkChanges(actBg);
									},
									'Configure': function(){
										var $tabs = $('#tabs').tabs();
										var bgTabs = $('#customize-tabs').tabs();
										$tabs.tabs('select', 1);
										bgTabs.tabs('select', 2);
										window.location.reload(true);
  									  	$(this).dialog('destroy');
  									  	showScroll();
									}
								}
							);
							$('#upload-message').dialog('open');
						}
						if(uploadType == 'favicon'){
							if(typeof(data.overwrite) == 'undefined'){
								$('#upload-message').html(data.success);
								$('#upload-message').dialog(
									'option', 'buttons', { 
										'OK': function(){
											$(this).dialog('destroy');
											showScroll();
										}
									}
								);
								$('#upload-message').dialog('open');
							}else{
								$('#upload-message').html(data.overwrite);
								$('#upload-message').dialog('option', 'title', 'Overwrite Warning');
								$('#upload-message').dialog(
									'option', 'buttons', { 
										'Yes': function(){
											$(this).dialog('destroy');
											showScroll();
										},
										'No': function(){
											$(this).dialog('destroy');
											showScroll();
										}
									}
								);
								$('#upload-message').dialog('open');
							}
						}
						if(uploadType == 'iphone'){
							$('#upload-message').html(data.success);
							$('#upload-message').dialog(
								'option', 'buttons', { 
									'Ok': function(){
										$(this).dialog('destroy');
  									  	showScroll();
									}
								}
							);
							$('#upload-message').dialog('open');
						}
						if(uploadType == 'sample'){
							$('#upload-message').html(data.success);
							$('#upload-message').dialog(
								'option', 'buttons', { 
									'Ok': function(){
										$(this).dialog('destroy');
  									  	showScroll();
									}
								}
							);
							$('#upload-message').dialog('open');
						}
					}
				}
			}
		//Callback that adds the token and action
		}, function(form){
			form.append($('<input />', {name: 'action', value: 'uni_installer'}))
				.append($('<input />', {name: '_token', value: $('input[name=_token]').val()}));
		});
	});	
	
	/* Tips ----------------------------
	--------------------------------- */
	fader = function (selector, speed, seconds) {
		$(selector).hide();
		var i = $(selector).length - 1;
		var toggle = function() {
				$(selector).eq(i).fadeOut(speed, function() {
						i = ++i % $(selector).length;
						$(selector).eq(i).fadeIn(speed, function() {
								setTimeout(toggle, seconds*1000)
						});

				});
		};                      
		toggle();
	};
	new fader('#tips-content p', 'slow', 3);
	
	/* Check for Changes ---------------
	--------------------------------- */
	$('#templateform').change(function(event, data){
		var uploaderid = (event.target.id);
		if(!$.cookie('formChanges')){
			if(uploaderid == 'insfile') { return false; event.preventDefault(); }
			$.cookie('formChanges', true);
			$('#utilities li.changes').html('<span class="shelf-notice">You have unsaved changes</span>');
		}
	});
	
	function checkChanges(action){	
		action();
		return false;

		var target;
		var $this = $(this);
		if($.cookie('formChanges')){			
			$('<div id="changesDialog"><p>You have made some changes to Configurator that will be saved upon activation of this themelet. Are you sure you want to activate this themelet and save these changes?</p></div>').dialog({
				autoOpen: true,
				bgiframe: true,
				modal: true,
				width: 350,
				title: 'Warning!',
				buttons: {
					'Activate': function(){
						$.cookie('formChanges', null);
						$(this).dialog('close');
						action();
						return true;
					},
					'Cancel': function(){
						$.cookie('formChanges', null);
						$(this).dialog('destroy');
						var $tabs = $('#tabs').tabs();
						var assetsTabs = $('#assets-tabs').tabs();
						$tabs.tabs('select', 5);
						assetsTabs.tabs('select', 0);
						ptOverlay('Processing...')
						window.location.reload(true);
						return false;
					}
				}
			});
		}else{
			action();
		}
	}
	
	$('td#toolbar-apply a, #bottom-save a').attr('onclick', '').click(function(event){
		ptOverlay('Saving Settings...');
		submitbutton('apply');
		event.preventDefault();
	});
	
	/* @TODO make this fully ajax later */
	$('#menuitems-options .save-and-reload').click(function(event){
		ptOverlay('Changing current menu item&hellip;');
		submitbutton('setMenuItem');
		event.preventDefault();
	});
	$('#menuitems-options .reset-menuitems').click(function(event){
		ptOverlay('Resetting menu item settings&hellip;');
		submitbutton('resetMenuItems');
		event.preventDefault();
	});
	
	<?php include('functions/blocks.js'); ?>
	<?php include('functions/keyboard.js'); ?>

	// ajax content for dialog
	// welcome screen
	function welcomeScreen(){
		$('#getting-started').dialog(Configurator.dialog({
			width: '920px',
			bgiframe: true,
   			dialogClass: 'welcome',
   			title: 'Welcome to Configurator',
   			overlay: {
   				'background-color': '#000', 
   				opacity: 0.8 
   			},
   			close: function(){
   				if($.cookie('info')){ $.cookie('info', null); }
   				showScroll();
   				$(this).dialog('destroy');
   			}
		}));
		hideScroll();
		$(".close-welcome").click(function(){
			$('#getting-started').dialog('destroy');
			showScroll();
			if($.cookie('info')){ $.cookie('info', null); }
			return false;
		});
		$('#splash').tabs({
			fx: { opacity: 'toggle' }
		});
	}
	
	$('.info-link').click(function(){
		$('#getting-started').load('?option=com_configurator&view=help&layout=gettingstarted&format=raw', function(){
			return welcomeScreen();
		});
		return false;
	});
	
	$('#toolbar-credits-link').click(function(){
		$('<div id="credits-dialog"></div>').appendTo('body');
		$('#credits-dialog').load('../administrator/components/com_configurator/tooltips/credits.html', function(){
			hideScroll();
			$('#credits-dialog').dialog(Configurator.dialog({
				width: '800px',
				bgiframe: true,
	   			dialogClass: 'credits', 
	   			title: 'Credits',
	   			overlay: {
	   				'background-color': '#000', 
	   				opacity: 0.8 
	   			},
	   			close: function(){
	   				showScroll();
	   				$(this).dialog('destroy');
	   			}
			}));
		});
		return false;
	});

	if(!$.cookie('welcome_screen')){
		$('#getting-started').load('?option=com_configurator&view=help&layout=gettingstarted&format=raw', function(){
			return welcomeScreen();
		});
		$.cookie('welcome_screen', 'hide', { expires: 360 });			
	}
	
	// prefs
	function preferencesScreen(){
		hideScroll();
		$('#preferences-screen').dialog(Configurator.dialog({
			width: '450px',
			bgiframe: true,
   			dialogClass: 'preferences', 
   			title: 'Configurator Preferences',
   			overlay: {
   				'background-color': '#000', 
   				opacity: 0.8 
   			},
   			close: function(){
   				showScroll();
   				$.cookie('prefs', null);
   				$(this).dialog('destroy');
   			}
		}));
		$(".close-preferences").click(function(){
			$('#preferences-screen').dialog("close");
			showScroll();
			if($.cookie('prefs')){ $.cookie('prefs', null); }
			return false;
		});
		
		$('.btn-prefs').click(function(){
			
			$('#preferences-screen').dialog('close');
			ptOverlay('Processing...');

			$('#preferences-form').submit(function(){
	   			$(this).ajaxSubmit({
	   				type: 'POST',
	   				url: '?option=com_configurator&view=configuration&format=raw',
	   				data: {
	   					option: 'com_configurator',
	   					action: 'saveprefs'
	   				},
		   			success: function(data, textStatus){
		   				
						window.location.reload(true);
		   				return false;
		   			}
	   			});
	   			return false;
	   		});
			$('#preferences-form').trigger('submit');
	
			return false;
		});
	}
	
	$('#toolbar-preferences a').click(function(){
		if($.browser.name == 'opera'){
			$('#cfgshort_keys1').parent().remove();
		}
		preferencesScreen();
		return false;
	});
	
	// keyboard screen
	function keyboardScreen(){
		ptOverlay();
		if($.browser.name == 'opera'){
			$('#keyboard-screen').empty();
			$('#keyboard-screen').load('?option=com_configurator&view=help&layout=keyboard-opera&format=raw');
		}
		$('#keyboard-screen').dialog(Configurator.dialog({
			width: '700px',
			bgiframe: true,
   			draggable: false,
   			//modal: true,
   			dialogClass: 'keyboard', 
   			title: 'Keyboard Shortcuts',
   			overlay: {
   				'background-color': '#000', 
   				opacity: 0.8 
   			},
   			close: function(){
   				$.cookie('keys', null);
   				close_ptOverlay();
   				$(this).dialog('destroy');
   			},
   			zIndex: 9999
		}));
	}
	
	$('#keyboard-toggle').click(function(){ 
		$('#keyboard-screen').load('?option=com_configurator&view=help&layout=keyboard&format=raw', function(){
			return keyboardScreen();
		}); 
		return false;
	});
	
	function toolGuides(tid){
		var toolPage;
		var toolTitle;
		
		switch(tid){
			case 2:
			toolPage = '../administrator/components/com_configurator/tooltips/visual-blocks.html';
			toolTitle = 'Visual Reference: Blocks';
			break;
			case 3:
			toolPage = '../administrator/components/com_configurator/tooltips/visual-positions.html';
			toolTitle = 'Visual Reference: Positions';
			break;
			case 4:
			toolPage = '../administrator/components/com_configurator/tooltips/troubleshooting.html';
			toolTitle = 'Troubleshooting';
			break;
			case 5:
			toolPage = '../administrator/components/com_configurator/tooltips/modfx.html';
			toolTitle = 'ModFX';
			break;
			case 6:
			toolPage = '../administrator/components/com_configurator/tooltips/pagefx.html';
			toolTitle = 'PageFX';
			break;
			case 7:
			toolPage = '../administrator/components/com_configurator/tooltips/menufx.html';
			toolTitle = 'MenuFX';
			break;
			case 8:
			toolPage = '../administrator/components/com_configurator/tooltips/contentfx.html';
			toolTitle = 'ContentFX';
			break;
		}
		
		$('.toolguides').dialog({
			autoOpen: false,
			bgiframe: true,
			width: 700,
			height: 700,
			title: toolTitle,
			zIndex: 5001,
			close: function(){
				$.cookie('tooltip'+tid, null);
				$('.toolguides').dialog('destroy');
				$('.toolguides').empty();
				close_ptOverlay();
				showScroll();		
			}
		});
		
		if(!$.cookie('tooltip'+tid)){
			ptOverlay();
			$.cookie('tooltip'+tid, 'open');
			$('.toolguides').load(toolPage);
			$('.toolguides').dialog('open');
		}else{
			$.cookie('tooltip'+tid, null);
			$('.toolguides').dialog('close');
			$('.toolguides').empty();
			close_ptOverlay();
		}
		
	}

	<?php include 'functions/bottom_save.js'; ?>
	<?php include 'functions/dbmanager.js'; ?>
	<?php include 'functions/reset.js'; ?>
	<?php include 'functions/recycle.js'; ?>
	var editor_highlighting = <?php echo $eh . "\n"; ?>
	<?php include 'functions/editor.js'; ?>
	<?php include 'functions/migrator.js'; ?>
	<?php include 'menuitems.js' ?>
});