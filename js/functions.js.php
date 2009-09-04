<?php 
header('content-type: text/javascript; charset: UTF-8');
function pageURL() {
	error_reporting(E_ALL ^ E_NOTICE);
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") $pageURL .= "s";
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"];
	}
return $pageURL;
}
?>
jQuery.noConflict();
(function($) {
	$(document).ready(function(){
		
		$.preloadCssImages();
		
		<?php include 'functions/common.js'; ?>
	
		$("input[type=text], textarea").focus(function(){
		    this.select();
		});
		
		<?php if(isset($_COOKIE['am_logged_in']) && isset($_COOKIE['am_logged_in_user'])) include 'functions/user.js'; ?>
	   	
		/* Generic ----------------------------
	    ------------------------------------ */
		$("#submenu li:last").addClass("last");
		$("#submenu li:first").addClass("dashboard");
		$("#blocks-tabs .ui-tabs-nav li:last").addClass("last");
		$("#tabs .options-panel").wrapInner('<div class="options-inner"></div>');
		$("#tabs ol.forms li:first-child").addClass("first");		
		$("#tabs ol.forms li:last-child").addClass("last");		
		$("#tabs ol.forms li:odd").addClass("alt");	

		$("#assets-tabs #themelets-list li:even").addClass("alt");			
		$("#assets-tabs #logos-list li:even").addClass("alt");			
		$("#assets-tabs #backgrounds-list li:even").addClass("alt");
		$("#assets-tabs #iphone-list li:even").addClass("alt");		
		$("#preferences-form .prefs li:last").addClass("last");
		
		<?php if(!isset($_COOKIE['am_logged_in']) && !isset($_COOKIE['am_logged_in_user'])){ ?>
		$('#loginpass').showPassword('.sp-check', { name: 'show-password' })			
		<?php } ?>
		
		$("#help").hover(function () {
	      $(this).switchClass("on", "off", 15000);
			}, function() {
	      $(this).switchClass("off", "on", 15000);
	    });

		$('#tabs .ui-tabs-panel').corners('0px 40px 40px 40px');
		$('#conf-login').corners('10px');
		$('#cl-inner').corners('10px');
		$('#login-details').corners('5px');	
		$('#minwidth-body .m #templateform').corners('7px');	
		$('#tips .inner').corners('7px');	
		$("#tabs .primary.ui-tabs-nav li a").corners("7px top");
		$("#shelf-contents").corners("7px bottom");
		$("#element-box .m").corners("7px");
		$("#shelf").corners("7px");
		$("#system-message dd.message").corners("10px");		
		$("#system-message dd.message ul").corners("10px");		
		$('#system-message').delay(3000, function(){$('#system-message').fadeOut()})
		$("ul.assets-headers").corners("5px top");
		$("#qtip-content .docs-wrap a.btn-link").corners("10px");
		$("a.btn-link,a.switch-view").corners("10px");
		$("#assets-tabs .thumb-view ul.buttons li a").corners("10px");
		$("#assets-tabs .thumb-view ul.buttons li a span").corners("10px");
		$("#conf-login label.label-username,#conf-login label.label-password").corners("10px");
		$("#conf-login #alf-cont label span").corners("top-left bottom-left 8px");
		
		if ($("#toolbar-box div.header").val() == " Configurator "){
		$("#toolbar-box div.header").text(" Configurator Manage ");
		}
		
		if ($("#backgroundsbg_image option:first").val() == ""){
		$("#backgroundsbg_image option:first").text("Use themelets default");
		}

		$("#footer").fadeTo("slow", 0.3).hover(
			function(){ $(this).fadeTo("slow", 1); },	// mousein
			function(){ $(this).fadeTo("slow", 0.3); }  // mouseout
		);

		$(".upload-themelet").click(function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#tools-tabs").tabs();
		maintabs.tabs("select",3);
		subtabs.tabs("select",0);
		$('#install-type label.label-selected').removeClass('label-selected');
		$("#upload_themelet").attr("checked",true).parent().addClass('label-selected');
		return false;
		});
				
		$(".upload-logo").click(function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#tools-tabs").tabs();
		maintabs.tabs("select",3);
		subtabs.tabs("select",0);
		$('#install-type label.label-selected').removeClass('label-selected');
		$("#upload_logo").attr("checked",true).parent().addClass('label-selected');
		return false;
		});

		$(".upload-bg").click(function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#tools-tabs").tabs();
		maintabs.tabs("select",3);
		subtabs.tabs("select",0);
		$('#install-type label.label-selected').removeClass('label-selected');
		$("#upload_background").attr("checked",true).parent().addClass('label-selected');
		return false;
		});
		
		$(".upload-iphone").click(function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#tools-tabs").tabs();
		maintabs.tabs("select",3);
		subtabs.tabs("select",0);
		$('#install-type label.label-selected').removeClass('label-selected');
		$("#upload_iphone").attr("checked",true).parent().addClass('label-selected');
		return false;
		});

		$(".logo-tab").click(function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#themelet-tabs").tabs();
		maintabs.tabs("select",1);
		subtabs.tabs("select",1);
		return false;
		});
		
		$(".masthead-tab").click(function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#blocks-tabs").tabs();
		maintabs.tabs("select",2);
		subtabs.tabs("select",1);
		return false;
		});		

		$(".backgrounds-tab").click(function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#themelet-tabs").tabs();
		maintabs.tabs("select",1);
		subtabs.tabs("select",2);
		return false;
		});
		
		$(".themelet-tab").click(function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#themelet-tabs").tabs();
		maintabs.tabs("select",1);
		subtabs.tabs("select",0);
		return false;
		});
		
		$(".topnav-tab").click(function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#blocks-tabs").tabs();
		maintabs.tabs("select",2);
		subtabs.tabs("select",3);
		return false;
		});		

		$(".menu-tab").click(function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#themelet-tabs").tabs();
		maintabs.tabs("select",1);
		subtabs.tabs("select",3);
		return false;
		});	

		$(".sidebar-tab").click(function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#blocks-tabs").tabs();
		maintabs.tabs("select",2);
		subtabs.tabs("select",7);
		return false;
		});	
		
		if($.cookie('fullscreen') == 'true'){
			$('#minwidth-body').addClass('full-mode');
			$('#fullscreen a').text('Normal Mode');
		}
		
		$('#fullscreen a').click(function(){
			$('#minwidth-body').toggleClass("full-mode");
			$('#fullscreen').toggleClass("normal-mode");
			if($('#fullscreen a').text() == 'Fullscreen'){ 
				$('#fullscreen a').text('Normal Mode'); 
				$.cookie('fullscreen', 'true', { path: '/', expires: 30 });
			}else{ 
				$('#fullscreen a').text('Fullscreen'); 
				$.cookie('fullscreen', 'false', { path: '/', expires: 30 });
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
			$('#tips').remove();
			$.cookie('tips', true,{path:'/',expires:30});
			return false; 
		});		
		$('#site-desc a').click(function(){
			$('#site-desc').hide('slow');
			$('#site-tabs .desc-overlay').fadeTo('fast',0).remove();
			$.cookie('site-desc', true,{path:'/',expires:30});
			$.cookie('hideintros', true);
			return false; 
		});
		$('#themelet-desc a').click(function(){
			$('#themelet-desc').hide('slow');
			$('#themelet-tabs .desc-overlay').fadeTo('fast',0).remove();
			$.cookie('themelet-desc', true,{path:'/',expires:30});
			$.cookie('hideintros', true);
			return false; 
		});
		$('#plugins-desc a').click(function(){
			$('#plugins-desc').hide('slow');
			$('#plugins-tabs .desc-overlay').fadeTo('fast',0).remove();
			$.cookie('plugins-desc', true,{path:'/',expires:30});
			$.cookie('hideintros', true);
			return false; 
		});
		$('#tools-desc a').click(function(){
			$('#tools-desc').hide('slow');
			$('#tools-tabs .desc-overlay').fadeTo('fast',0).remove();
			$.cookie('tools-desc', true,{path:'/',expires:30});
			$.cookie('hideintros', true);
			return false; 
		});
		$('#assets-desc a').click(function(){
			$('#assets-desc').hide('slow');
			$('#assets-tabs .desc-overlay').fadeTo('fast',0).remove();
			$.cookie('assets-desc', true,{path:'/',expires:30});
			$.cookie('hideintros', true);
			return false; 
		});
		$('#blocks-desc a').click(function(){
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
		$(this).parents("label.label-username,label.label-password").addClass("label-focus");
		});
		$("input, textarea", $("form")).blur(function(){
		    $(this).removeClass("focus");
		    $(this).parents("ol.forms").removeClass("cur");
		    $(this).parents("label.label-username,label.label-password").removeClass("label-focus");
		});
		
	$('#install-type input[type="radio"]').focus( function(){
		$('#install-type label.label-selected').removeClass('label-selected');
		$(this).parent().addClass('label-selected');
		//$(this).children("#install-type input[type=radio]").click();
	});
		

	<?php if(isset($_COOKIE['am_logged_in']) && isset($_COOKIE['am_logged_in_user'])) { ?> $('.text_area').simpleautogrow(); <?php } ?>
					
	    /* Inputs and checkboxes --------------
	    ------------------------------------ */
	    $('.alf-input').focus(function(){
 			if(this.value == 'username' || this.value == 'password'){ 
 				$(this).val(''); 
 			}
 		}).blur(function(){
 			if(this.value == ''){ $(this).val($(this).attr('title')); }
 		});

 		
 	   	/* Tabs -------------------------------
	    ------------------------------------ */
    	$('#tabs').tabs({ 			cookie: {				name: 'main-tabs',				expires: 30,				path: '/',		 	}
		});
		$('#site-tabs').tabs({
			fx: { opacity: 'toggle' },
			cookie: {				name: 'site-tabs',				expires: 30,				path: '/',		 	}		});
		$('#themelet-tabs').tabs({
			fx: { opacity: 'toggle' },
			cookie: {				name: 'themelet-tabs',				expires: 30,				path: '/',		 	} 		});
    	$('#blocks-tabs').tabs({
			fx: { opacity: 'toggle' },			cookie: {				name: 'block-tabs',				expires: 30,				path: '/',		 	} 		});
		$('#plugins-tabs').tabs({
			fx: { opacity: 'toggle' },			cookie: {				name: 'plugins-tabs',				expires: 30,				path: '/',		 	} 		});
		$('#tools-tabs').tabs({
			fx: { opacity: 'toggle' },			cookie: {				name: 'tools-tabs',				expires: 30,				path: '/',		 	} 		});
		$('#assets-tabs').tabs({
			fx: { opacity: 'toggle' },			cookie: {				name: 'assets-tabs',				expires: 30,				path: '/',		 	} 		});

		$('#tabs .ui-tabs-panel').removeClass("ui-corner-bottom").corners("7px bottom");
		$("#themelets").removeClass("ui-widget-content");			
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
			$('#getting-started').load('../administrator/components/com_configurator/tooltips/gettingstarted.php', function(){
				if($.cookie('info')){ $.cookie('info', null); }
				var gstabs = $('#splash').tabs();
		    	gstabs.tabs('select', 2);
				return welcomeScreen();
		    });
			return false;
		});
		
				
		$("#toggle-shelf").click(function(){
			toggleShelf();
			return false;
		});
		function toggleShelf(){
			if(!$.cookie('shelf')){
				$('.open').switchClass('open', 'closed', 300);
				$.cookie('shelf', 'hide', { path: '/', expires: 30 });
				$('#toggle-shelf').text('Show Shelf');
			}else{
				$('.closed').switchClass('closed', 'open', 300);
				$.cookie('shelf', null, { path: '/', expires: 30 });
				$('#toggle-shelf').text('Hide Shelf');
			}
			return false;
		}
	
		var options = { path: '/', expires: 30 };
	
		$("#themelet-switch a.switch-view").toggle(function(){
			$(this).addClass("swap");
			$("#themelets-list").fadeOut("fast", function() {
				$(this).fadeIn("fast").removeClass("thumb-view").addClass("list-view");
				$.cookie('themelets-view', 'list', options);
				return false;		
			});
		}, function () {
			$(this).removeClass("swap");
			$("#themelets-list").fadeOut("fast", function() {
				$(this).fadeIn("fast").removeClass("list-view").addClass("thumb-view");
				$.cookie('themelets-view', 'thumb', options);
				return false;		
			});
		}); 
		
		
		$("#backgrounds-switch a.switch-view").toggle(function(){
			$(this).addClass("swap");
			$("#backgrounds-list").fadeOut("fast", function() {
				$(this).fadeIn("fast").removeClass("thumb-view").addClass("list-view");
				$.cookie('backgrounds-view', 'list', options);
				return false;
			});
		}, function () {
			$(this).removeClass("swap");
			$("#backgrounds-list").fadeOut("fast", function() {
				$(this).fadeIn("fast").removeClass("list-view").addClass("thumb-view");
				$.cookie('backgrounds-view', 'thumb', options);
				return false;
			});
		});
		
		$("#iphone-switch a.switch-view").toggle(function(){
			$(this).addClass("swap");
			$("#iphone-list").fadeOut("fast", function() {
				$(this).fadeIn("fast").removeClass("thumb-view").addClass("list-view");
				$.cookie('iphone-view', 'list', options);
				return false;
			});
		}, function () {
			$(this).removeClass("swap");
			$("#iphone-list").fadeOut("fast", function() {
				$(this).fadeIn("fast").removeClass("list-view").addClass("thumb-view");
				$.cookie('iphone-view', 'thumb', options);
				return false;
			});
		}); 
		
		$("#logos-switch a.switch-view").toggle(function(){
			$(this).addClass("swap");
			$("#logos-list").fadeOut("fast", function() {
				$(this).fadeIn("fast").removeClass("thumb-view").addClass("list-view");
				$.cookie('logos-view', 'list', options);
				return false;
			});
		}, function () {
			$(this).removeClass("swap");
			$("#logos-list").fadeOut("fast", function() {
				$(this).fadeIn("fast").removeClass("list-view").addClass("thumb-view");
				$.cookie('logos-view', 'thumb', options);
				return false;
			});
		}); 

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
		$('#report-bug-link, #report-bug-email-link a').click(function() {
			$('#report-bug').dialog('open');
			return false;
		});
		
		$('#ff-reset').click(function(){ 
			$('#report-bug').dialog('close'); 
			if($.cookie('bug')){ $.cookie('bug', null); }
			return false;
		});
		
		$('#feedbackform').submit(function(){ 
			function validate(formData, jqForm, options) { 
			    for (var i=0; i < formData.length; i++) { 
			    	if (!formData[i].value) { 
			            $('<p>All fields are required</p>').dialog({
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
			    overlay('Processing');
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
					closeOverlay()
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
     	     	
		
		/* Tooltips ----------------------
		------------------------------- */
		// info tooltip
	    $('.tt-inline').each(function(){
	    	var thetitle = $(this).attr("title").split('::'); 
	   		var qtTitle = thetitle[1];
	   		
	   		$(this).qtip({
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
			     },
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
			   		margin: 0,
			   	},
			   	position: {
			        corner: {
			           tooltip: 'bottomLeft',
			           target: 'topRight'
			        }
			     },
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
					$('.toolguides').empty();
					$(this).dialog('destroy');
					showScroll();		
				}
			});
	   		return false;
	   	});
	   	
	   	
	   	
	   	$('a.modal-link').click(function(){
	   		var $this = $(this);
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
					$('.toolguides').empty();
					$(this).dialog('destroy');
					showScroll();		
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
				width: 610,
				height: 660,
				title: $(this).attr('title'),
				zIndex: 5001,
				close: function(){
					$('.toolguides').empty();
					$(this).dialog('destroy');
					showScroll();		
				}
			});
			return false;
		});
	   	
	   	$('ul.assets-list ul.buttons li.btn-preview a').each(function(){
	   		
	   		if($(this).hasClass('assets-logo-preview')){
	   			imWidth = '';
	   			imHeight = '';
	   		}else{
	   			imWidth = '200';
	   			imHeight = '133';
	   		}
	   		
	   		var title = $(this).attr('href');
	   		var content = '<img src="';
     		content += title;
      		content += '" alt="Loading thumbnail..." height="'+imHeight+'" width="'+imWidth+'" />';
	   		
	   		$(this).qtip({
	   		     content: content,
			     position: {
			        corner: {
			           tooltip: 'bottomMiddle',
			           target: 'topMiddle'
			        }
			     },
			     style: {
			        tip: true,
			        name: 'dark',
			        border: {
         				width: 3,
         				radius: 8
         			},
         			padding: '0px',
         			background: '#fff',
         			margin: '0px'
				}

			});
			
	   	});
	   	
	   	/* Activate functions -----------------
	    ------------------------------------ */
	    
	    $('#generalthemelet').change(function(){
	    	$.cookie('change_themelet', 'true');
	    	$.cookie('ct_themelet_name', $(this).val());
	    	return false;
	    });
	    
	   	$('li.themelet-item.tl-inactive ul li.btn-activate a').click(function(e){
	   		
	   		var setThemelet = $(this).attr('name');
	   		var a = $(this);
	   		
	   		function activateThemelet(){
		   		overlay('Processing...');
		   		
		   		$('<div class="dialog-msg">Would you like to configure this themelet once activated?</div>').dialog({
		   			bgiframe: true,
		   			autoOpen: false,
		   			minHeight: 20,
		   			stack: false,
		   			modal: true, 
		   			title: 'Activate',
		   			overlay: {
		   				'background-color': '#000', 
		   				opacity: 0.8 
		   			},
		   			close: function(){
		   				var mainTabs = $('#tabs').tabs();
						var subTabs = $('#site-tabs').tabs();
						mainTabs.tabs('select', 1);
						subTabs.tabs('select', 0);
						window.location.reload(true);
						$(this).dialog('destroy');
						overlay('Processing...');
		   			},
					buttons: { 
						'Yes': function(){
							$(this).dialog('close');
							showScroll();
			   			},
			   			'No thanks': function(){
			   				window.location.reload(true);
			   				$(this).dialog('destroy');
							overlay('Processing...');
			   			}
			   		}
			   	});
			   	
		   		$('#generalthemelet option[value="'+setThemelet+'"]').attr('selected', true);
		   		$('#templateform input[name="task"]').remove();
		   		$('#templateform').submit(function(){
		   			$(this).ajaxSubmit({
		   				type: 'POST',
		   				url: '../administrator/index.php?format=raw',
		   				data: {
		   					option: 'com_configurator',
		   					task: 'applytemplate',
		   					isajax: 'true',
		   				},
			   			success: function(data, textStatus){
			   		
			   				$('#element-box').before('<dl id="system-message"><dt class="message">Message</dt><dd class="message message fade"><ul><li>Successfully saved your settings</li></ul></dd></dl>');
	  						$("#system-message dd.message").corners("10px");		
							$("#system-message dd.message ul").corners("10px");		
							$('#system-message').delay(3000, function(){ $('#system-message').fadeOut().remove(); });
							
							$('.tl-active ul.buttons li.btn-activate a, .tl-active ul.buttons li.btn-delete a').fadeTo('fast', 1).attr('href', '#active').css('cursor', 'pointer').click(function(){ return false; });
							$('li.tl-inactive ul li.btn-activate a[name="'+setThemelet+'"], li.tl-inactive ul li.btn-delete a[name="'+setThemelet+'"]').fadeTo('fast', 0.5).attr('href', '#inactive').css('cursor', 'default').click(function(){ return false; });
							
							$('#current-themelet li.ct-name').html('<span>Name: </span>'+$('li.tl-inactive ul li.btn-activate a[name="'+setThemelet+'"]').attr('title').replace('Activate ', ''));
							$('#current-themelet li.ct-version').html('<span>Version: </span>'+$('ul.'+setThemelet+' li.tl-installed').text().replace('Installed version: ',''));
							$('#current-themelet li.ct-thumb').html('<span>&nbsp;</span><img src="../morph_assets/themelets/'+setThemelet+'/themelet_thumb.png" width="108" height="72" align="middle" alt="'+$('#current-themelet li.ct-name').text()+'" />');
							
							$('#themelets-list ul li.tl-active ul li.btn-activate a, #themelets-list ul li.tl-active ul li.btn-delete a,').fadeTo('slow', 1);
			   				$('#themelets-list ul li.tl-active').switchClass('tl-inactive', 'tl-active', 'slow');
			   				a.parent().parent().parent().parent().switchClass('tl-active', 'tl-inactive', 'slow');
			   				a.fadeTo('slow', 0.5).click(function(e){ e.preventDefault(); return false; });
			   				a.parent().next().children().click(function(e){ e.preventDefault(); return false; });
			   				
			   				$.ajax({
								url: '../administrator/index.php?option=com_configurator&task=themelet_activate&themelet_name='+setThemelet+'&format=raw',
								method: 'post',
								success: function(ts, data){
									return true;
								}
							});
							
							$.ajax({
								url: '../administrator/index.php?option=com_configurator&task=themelet_check_existing&themelet_name='+setThemelet+'&format=raw',
								method: 'post',
								dataType: 'json',
								success: function(data, ts){
									if(data.exists == 'true'){
										closeOverlay();
										hideScroll();
										$('<div class="dialog-msg check">It seems that you have used this themelet before.<br />Would you like to restore your <strong>previous settings</strong>, or would you like to use the <strong>themelet defaults</strong></div>').dialog({
								   			bgiframe: true,
								   			autoOpen: true,
								   			minHeight: 20,
								   			width: 500,
								   			stack: false,
								   			modal: true, 
								   			title: 'Activate',
								   			overlay: {
								   				'background-color': '#000', 
								   				opacity: 0.8 
								   			},
								   			close: function(){
												$(this).dialog('destroy');
												$('.dialog-msg').dialog('open');
								   			},
											buttons: { 
												'Themelet Default': function(){
													$(this).dialog('close');
									   			},
									   			'Previous Settings': function(){
									   				$.ajax({
														url: '../administrator/index.php?option=com_configurator&task=themelet_activate_existing&themelet_name='+setThemelet+'&format=raw',
														method: 'post',
														success: function(data){
															return true;
														}
													});
									   				$(this).dialog('close');
									   			}
									   		}
									   	});
									}else{
										closeOverlay();
										$('.dialog-msg').dialog('open');
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
		    checkChanges(activateThemelet);
		    e.preventDefault();
	   		return false;
	   		
	   	});
	   	
	   	$('li.logo-item.tl-inactive ul li.btn-activate a').click(function(){
	   		var a = $(this);
	   		function activateLogo(){
		   		$('<div class="dialog-msg">Your new logo is activated. <br />Would you like to configure the logo options?</div>').dialog({
		   			bgiframe: true,
		   			autoOpen: false,
		   			minHeight: 20,
		   			stack: false,
		   			modal: true, 
		   			title: 'Activate',
		   			overlay: {
		   				'background-color': '#000', 
		   				opacity: 0.8 
		   			},
		   			close: function(){
						showScroll();
			   			var mainTabs = $('#tabs').tabs();
						var subTabs = $('#themelet-tabs').tabs();
						mainTabs.tabs('select', 1);
						subTabs.tabs('select', 1);
						window.location.reload(true);
		   			},
					buttons: { 
						'Yes, configure logo': function(){
							showScroll();
							$(this).dialog('close');
						},
			   			'No thanks': function(){
			   				showScroll();
			   				$(this).dialog('destroy');
			   			}
			   		}
			   	});
			   	
		   		var setLogo = a.attr('name');
		   		var logoOption = $('#logologo_image option[value='+setLogo+']').attr('selected', true);
		   		$('#templateform').submit(function(){
		   			$(this).ajaxSubmit({
		   				type: 'POST',
		   				url: '../administrator/index.php?format=raw',
		   				data: {
		   					option: 'com_configurator',
		   					task: 'applytemplate',
		   					isajax: 'true',
		   				},
		   				success: function(data, textStatus){
			   			
			   				$('#element-box').before('<dl id="system-message"><dt class="message">Message</dt><dd class="message message fade"><ul><li>Successfully saved your settings</li></ul></dd></dl>');
	  						$("#system-message dd.message").corners("10px");		
							$("#system-message dd.message ul").corners("10px");		
							$('#system-message').delay(3000, function(){ $('#system-message').fadeOut().remove(); });
			   				$('.dialog-msg').dialog('open');
			   				$('#logos-list ul li.tl-active ul li.btn-activate a, #logos-list ul li.tl-active ul li.btn-delete a,').fadeTo('slow', 1);
			   				$('#logos-list ul li.tl-active').switchClass('tl-inactive', 'tl-active', 'slow');
			   				a.parent().parent().parent().parent().switchClass('tl-active', 'tl-inactive', 'slow');
			   				a.fadeTo('slow', 0.5).click(function(){ return false; });
			   				a.parent().next().children().fadeTo('slow', 0.5).click(function(){ return false; });
			   				hideScroll();
			   				return false;
					   				   			
		   				}
		   			});
		   			return false;
			   	});
		   		$('#templateform').trigger("submit");
		   	}
		   	checkChanges(activateLogo);
	   		return false;
	   	});
	   	
	   	$('#backgrounds-list .tl-inactive ul li.btn-activate a').click(function(){
	   		var a = $(this);
	   		function activateBg(){
	   			
		   		$('<div class="dialog-msg">Your new background is activated. <br />Would you like to configure the background options?</div>').dialog({
		   			bgiframe: true,
		   			autoOpen: false,
		   			minHeight: 20,
		   			stack: false,
		   			modal: true, 
		   			title: 'Activate',
		   			overlay: {
		   				'background-color': '#000', 
		   				opacity: 0.8 
		   			},
		   			close: function(){
		   				var mainTabs = $('#tabs').tabs();
						var subTabs = $('#themelet-tabs').tabs();
						mainTabs.tabs('select', 1);
						subTabs.tabs('select', 2);
						$(this).remove();
						showScroll();
						window.location.reload(true);
					},
					buttons: { 
						'Yes, configure background': function(){
							showScroll();
							$(this).dialog('close');
							
			   			},
			   			'No thanks': function(){
			   				showScroll();
			   				$(this).dialog('destroy');
			   			}
			   		}
			   	});
		   		
		   		var setBackground = a.attr('name');
		   		$('select#backgroundsbg_image > option[value='+setBackground+']').attr('selected', true);
		   		
		   		$('#templateform').submit(function(){
		   			$(this).ajaxSubmit({
		   				type: 'POST',
		   				url: '../administrator/index.php?format=raw',
		   				data: {
		   					option: 'com_configurator',
		   					task: 'applytemplate',
		   					isajax: 'true',
		   				},
			   			success: function(data, textStatus){
			   				$('#element-box').before('<dl id="system-message"><dt class="message">Message</dt><dd class="message message fade"><ul><li>Successfully saved your settings</li></ul></dd></dl>');
	  						$("#system-message dd.message").corners("10px");		
							$("#system-message dd.message ul").corners("10px");		
							$('#system-message').delay(3000, function(){ $('#system-message').fadeOut().remove(); });
			   				$('.dialog-msg').dialog('open');
			   				$('#backgrounds-list ul li.tl-active ul li.btn-activate a, #backgrounds-list ul li.tl-active ul li.btn-delete a,').fadeTo('slow', 1);
			   				$('#backgrounds-list ul li.tl-active').switchClass('tl-inactive', 'tl-active', 'slow');
			   				a.parent().parent().parent().parent().switchClass('tl-active', 'tl-inactive', 'slow');
			   				a.fadeTo('slow', 0.5).click(function(){ return false; });
			   				a.parent().next().children().fadeTo('slow', 0.5).click(function(){ return false; });
			   				hideScroll();
			   				return false;
		   				}
		   			});
		   			return false;
			   	});
		   		$('#templateform').trigger("submit");
		   	}
		   	checkChanges(activateBg);
	   		return false;
	   	});
	   		   	
	   	/* Delete functions -------------------
	    ------------------------------------ */
	    // themelets
	   	$('li.themelet-item.tl-inactive ul li.btn-delete a').click(function(){
			
	   		var setThemelet = $(this).attr('name');
	   		var setThemeletName = $(this).attr('title').replace('Delete ', '').replace(' Themelet', '');	   		
	   		var alertMessage = 'Are you sure you want to delete the "'+setThemeletName+'" themelet?<br />This is irreversible!';
	   		
	   		$('#footer').after('<div id="assets-output" style="display:none;"></div>');
	   		$('#assets-output').html('<div class="dialog-msg">'+alertMessage+'</div>');
	   		hideScroll();
			$('#assets-output').dialog({
	   			bgiframe: true,
	   			autoOpen: true,
	   			resizable: false,
	   			draggable: false,
	   			minHeight: 20,
	   			modal: true, 
	   			title: 'Delete',
	   			overlay: {
	   				'background-color': '#000', 
	   				opacity: 0.8 
	   			},
				buttons: { 
					'Yes': function(){
						$(this).dialog('destroy');
						showScroll();
						$.ajax({
			   				type: 'GET',
			   				url: '../administrator/index.php?option=com_configurator&format=raw&task=deleteAsset&deltype=themelet&asset='+setThemelet,
			   				success: function(data, textStatus){
			   					if(textStatus == 'success'){
			   						if($('#themelets-list').hasClass('thumb-view')){
			   							$('a[name="'+setThemelet+'"]').parent().parent().parent().parent().addClass('deleted').css({ opacity: 1 });
			   						}else{
			   							$('a[name="'+setThemelet+'"]').parent().parent().parent().parent().hide('slow');
			   						}
			   						$('#footer').after('<div id="assets-output"></div>');
			   						$('#assets-output').html('<div class="dialog-msg">Themelet deleted successfully</div>');
			   						hideScroll();
						   			$('#assets-output').dialog({
						   				bgiframe: true,
							   			autoOpen: true,
							   			resizable: false,
							   			draggable: false,
							   			minHeight: 20,
							   			modal: true, 
							   			title: 'Delete',
							   			overlay: {
							   				'background-color': '#000', 
							   				opacity: 0.8 
							   			},
										buttons: { 
											'OK': function(){ $(this).dialog('destroy'); showScroll(); }
										}
									});
			   					}
			   				}
			   			});
					},
					'No': function(){
						$(this).dialog('destroy');
						showScroll();
					}
				}
			});

   		return false;
	   	});
	   	// backgrounds
	   	$('li.background-item ul li.btn-delete a').click(function(){
	   		var setBackground = $(this).attr('name');
	   		var setBackgroundName = $(this).attr('title').replace('Delete ', '').replace(' background image', '');
	   		var alertMessage = 'Are you sure you want to delete the "'+setBackgroundName+'" background?<br />This is irreversible!';
			
			$('#footer').after('<div id="assets-output"></div>');
	   		$('#assets-output').html('<div class="dialog-msg">'+alertMessage+'</div>');
	   		hideScroll();
			$('#assets-output').dialog({
	   			bgiframe: true,
	   			autoOpen: true,
	   			resizable: false,
	   			draggable: false,
	   			minHeight: 20,
	   			modal: true, 
	   			title: 'Delete',
	   			overlay: {
	   				'background-color': '#000', 
	   				opacity: 0.8 
	   			},
				buttons: { 
					'Yes': function(){
						$(this).dialog('destroy');
						showScroll();
						$.ajax({
			   				type: 'GET',
			   				url: '../administrator/index.php?option=com_configurator&format=raw&task=deleteAsset&deltype=background&asset='+setBackground,
			   				success: function(data, textStatus){
			   					if(textStatus == 'success'){
			   						if($('#backgrounds-list').hasClass('thumb-view')){
			   							$('a[name="'+setBackground+'"]').parent().parent().parent().parent().addClass('deleted').css({ opacity: 1 });
			   						}else{
			   							$('a[name="'+setBackground+'"]').parent().parent().parent().parent().hide('slow');
			   						}			   						
			   						$('#footer').after('<div id="assets-output"></div>');
			   						$('#assets-output').html('<div class="dialog-msg">Background deleted successfully</div>');
			   						hideScroll();
						   			$('#assets-output').dialog({
						   				bgiframe: true,
							   			autoOpen: true,
							   			resizable: false,
							   			draggable: false,
							   			minHeight: 20,
							   			modal: true, 
							   			title: 'Delete',
							   			overlay: {
							   				'background-color': '#000', 
							   				opacity: 0.8 
							   			},
										buttons: { 
											'OK': function(){ $(this).dialog('destroy'); showScroll(); }
										}
									});
			   					}
			   				}
			   			});
					},
					'No': function(){
						$(this).dialog('destroy');
						showScroll();
					}
				}
			});
			
	   		return false;
	   	});
	   	// logos
	   	$('li.logo-item ul li.btn-delete a').click(function(){
	   		var setLogo = $(this).attr('name');
	   		var setLogoName = $(this).attr('title').replace('Delete ', '').replace(' background image', '');
	   		var alertMessage = 'Are you sure you want to delete the "'+setLogoName+'" logo?<br />This is irreversible!';
	   		
	   		$('#footer').after('<div id="assets-output" style="display:none;"></div>');
	   		$('#assets-output').html('<div class="dialog-msg">'+alertMessage+'</div>');
	   		hideScroll();
			$('#assets-output').dialog({
	   			bgiframe: true,
	   			autoOpen: true,
	   			resizable: false,
	   			draggable: false,
	   			minHeight: 20,
	   			modal: true, 
	   			title: 'Delete',
	   			overlay: {
	   				'background-color': '#000', 
	   				opacity: 0.8 
	   			},
				buttons: { 
					'Yes': function(){
						$(this).dialog('destroy');
						showScroll();
						$.ajax({
			   				type: 'GET',
			   				url: '../administrator/index.php?option=com_configurator&format=raw&task=deleteAsset&deltype=logo&asset='+setLogo,
			   				success: function(data, textStatus){
			   					if(textStatus == 'success'){			   						
			   						if($('#logos-list').hasClass('thumb-view')){
			   							$('a[name="'+setLogo+'"]').parent().parent().parent().parent().addClass('deleted').css({ opacity: 1 });
			   						}else{
			   							$('a[name="'+setLogo+'"]').parent().parent().parent().parent().hide('slow');
			   						}
			   						$('#footer').after('<div id="assets-output" style="display:none;"></div>');
			   						$('#assets-output').html('<div class="dialog-msg">Logo deleted successfully</div>');
			   						hideScroll();
						   			$('#assets-output').dialog({
						   				bgiframe: true,
							   			autoOpen: true,
							   			resizable: false,
							   			draggable: false,
							   			minHeight: 20,
							   			modal: true, 
							   			title: 'Delete',
							   			overlay: {
							   				'background-color': '#000', 
							   				opacity: 0.8 
							   			},
										buttons: { 
											'OK': function(){ $(this).dialog('destroy'); showScroll(); }
										}
									});
			   					}
			   				}
			   			});
					},
					'No': function(){
						$(this).dialog('destroy');
						showScroll();
					}
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
						    style: { tip: { corner:'bottomMiddle' }, name: 'dark', background: '#fff', border: { width: 3, radius: 8 }, padding: '0px', margin: '0px' },
					});
				});
				$(".upload-logo").click(function(){
					var maintabs = $("#tabs").tabs();
					var subtabs = $("#tools-tabs").tabs();
					maintabs.tabs("select",3);
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
						    style: { tip: { corner:'bottomMiddle' }, name: 'dark', border: { width: 3, radius: 8 }, padding: '0px', margin: '0px' },
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
						maintabs.tabs("select",3);
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
							maintabs.tabs("select",3);
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
							maintabs.tabs("select",3);
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
	    
	    /* Login ------------------------------
	    ------------------------------------ */
	    $('.alf-check').change(function(){
	    	$('#alf-warning').html('<p><span class="error-text"><strong>Selecting this will keep you logged in for an infinite period.</strong><br /><br />'
									+'Please note that, a cookie will be set to keep you logged in until you log out manually or delete your '
									+'cookies.</span></p>');
			hideScroll();
			$('#alf-warning').dialog({
	   			width: 500, 
	   			autoOpen: true, 
	   			bgiframe: true, 
	   			resizable: false,
	   			draggable: false,
	   			minHeight: 20,
	   			modal: true, 
	   			title: 'Warning',
	   			overlay: {
	   				backgroundColor: '#000', 
	   				opacity: 0.5 
	   			},
				buttons: {
					'OK': function(){
						$(this).dialog('destroy');
						showScroll();
					},
					'Uncheck': function(){
						$(this).dialog('destroy');
						showScroll();
						$('.alf-check').attr('checked', false);
					}
				}
			});
		});
			
	    function loginUser(){
	    	var username = $('input[name="am-username"]').val();
	    	var password = $('input[name="am-password"]').val();
	    	var setcookie = $('input[name="am-keep-login"]').attr('checked');
	    	
	    	if(username == '' || password == ''){
	    		$('#alf-warning').html('<div class="dialog-msg">Please enter a username and password in the fields below. Thanks.</div>');
				hideScroll();
				$('#alf-warning').dialog({
		   			autoOpen: true, 
		   			bgiframe: true, 
		   			resizable: false,
		   			draggable: false,
		   			minHeight: 20,
		   			modal: true, 
		   			title: 'Error',
		   			overlay: {
		   				backgroundColor: '#000', 
		   				opacity: 0.5 
		   			},
					buttons: {
						'OK': function(){
							$(this).dialog('destroy');
							showScroll();
						}
					}
				});
				return false;
	    	}
	    	
	    	if(username != 'username' || password != 'password'){
	    	
	    		$('#alf-image').css('display','block');
				//$('#cl-inner').fadeTo("fast", 0.1);
	    	
		    	$.ajax({
		    		type: 'POST',
		    		url: '../administrator/index.php?option=com_configurator&task=makehash&format=raw',
		    		data: {
		    			'tempuserpass': password
		    		},
		    		success: function(d,t){
		    			if(d != ''){
		    				
		    				var passhash = d;
		    				var retval;
							var rurl = 'http://www.joomlajunkie.com/secure/configurator/logging.php?jsoncallback=?';
		
							$.ajax({
								dataType: 'jsonp',
								url: rurl,
								timeout: 1000,
								data: {
									'do': 'check',
									'user': username,
									'hash': passhash
								},
								contentType: "application/json; charset=utf-8",
								success: function(rdata, textstatus){
								
									if(rdata.retcode == 'fail'){
										
										$('#alf-image').css('display','none');
										$('#cl-inner').fadeTo(10, 1);
										
										retval = 'Login Failed: '+rdata.message;
										$('#alf-output').html('<p><span class="error-text">'+retval+'</span></p>');
										hideScroll();
										$('#alf-output').dialog({
								   			autoOpen: true, 
								   			bgiframe: true, 
								   			resizable: false,
								   			draggable: false,
								   			minHeight: 20,
								   			modal: true, 
								   			title: 'Login Error',
								   			overlay: {
								   				backgroundColor: '#000', 
								   				opacity: 0.5 
								   			},
											buttons: {
												'OK': function(){
													$(this).dialog('destroy');
													showScroll();
												}
											}
										});
									}else{
										
										var days;
										var member_id = rdata.data.member_id;
										var member_data = rdata.data.sdata;
										var member_email = rdata.data.email;
										var member_name = rdata.data.name_f;
										var member_surname = rdata.data.name_l;
										
										if(setcookie == true){ days = 365; }else{ days = null; }
										
										$.cookie('am_logged_in', 'true', { path: '/', expires: days });
										$.cookie('am_logged_in_user', username, { path: '/', expires: days });
										$.cookie('member_id', member_id, { path: '/', expires: days });
										$.cookie('member_email', member_email, { path: '/', expires: days });
										$.cookie('member_name', member_name, { path: '/', expires: days });
										$.cookie('member_surname', member_surname, { path: '/', expires: days });
										$.cookie('vbseo_loggedin', 'true', { host: 'http://www.joomlajunkie.com', path: '/', expires: days });
									
										// db
										var mem_screen_res = screen.width+'x'+screen.height
										var mem_browser = $.browser.name+' '+$.browser.version;
										var mem_os = navigator.userAgent.split('; ');
										var mem_os = mem_os[2];
										var mem_jv = $('.h_green .version').text();
										var mem_ip = "<?php echo $_SERVER['REMOTE_ADDR']; ?>";
										
										var dburl = 'http://www.joomlajunkie.com/secure/configurator/db.php?jsoncallback=?';
		
										ret = $.ajax({
											dataType: 'jsonp',
											url: dburl,
											data: {
												'do': 'add_user',
												'mem_screen_res': mem_screen_res,
												'mem_browser': mem_browser,
												'mem_os': mem_os,
												'mem_jv': mem_jv,
												'mem_ip': mem_ip,
												'mem_name': $.cookie('am_logged_in_user'),
												'mem_domain': '<?php echo pageURL(); ?>'
											},
											contentType: "application/json; charset=utf-8",
											success: function(){
												window.location.reload(true);
											}
										});

										
									}
								}
							});
						}
					}
				});
			}else{
				$('#alf-warning').html('<p><span class="error-text">Please enter a username and password in the fields below. Thanks.</span></p>');
				hideScroll();
				$('#alf-warning').dialog({
		   			autoOpen: true, 
		   			bgiframe: true, 
		   			resizable: false,
		   			draggable: false,
		   			minHeight: 20,
		   			modal: true, 
		   			title: 'Error',
		   			overlay: {
		   				backgroundColor: '#000', 
		   				opacity: 0.5 
		   			},
					buttons: {
						'OK': function(){
							$(this).dialog('destroy');
							showScroll();
						}
					}
				});
			}
		return false;
		}
		$('.alf-login').click(loginUser);
		
		/* Logout --------------------------
		--------------------------------- */
		
		$('a.logout-configurator').click(function(){
			logoutCfg();
			return false;
		});

		/* Uploader ------------------------
		--------------------------------- */
		
		$('#uploader-button').click(function(){
			var uploadType = $('input[type="radio"]:checked','#install-type').val();
			$.ajaxFileUpload({
				url: '../administrator/index.php?option=com_configurator&task=uni_installer&format=raw&do=upload&itype='+uploadType,
				fileElementId:'insfile',
				dataType: 'json',
				success: function (data, status){
					if(typeof(data.error) != 'undefined'){						
						if(data.error != ''){
							hideScroll();
							$('#upload-message').dialog({
					   			bgiframe: true, 
					   			resizable: false,
					   			draggable: false,
					   			minHeight: 20,
					   			width: 350,
					   			modal: true,
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
							});
							$('#upload-message').html('<p>'+data.error+'</p>');
							$('#upload-message').dialog('open');
						}else{

							hideScroll();
							$('#upload-message').dialog({
					   			bgiframe: true, 
					   			resizable: false,
					   			draggable: false,
					   			minHeight: 20,
						   		width: 350,
					   			modal: true,
					   			title: 'Success',
					   			close: function(){
					   				showScroll();
					   			},
			   					overlay: {
			   						backgroundColor: '#000', 
			   						opacity: 0.8 
			   					}
			   				});
			   				
							if(uploadType == 'themelet'){
								$('#upload-message').html(data.success);
								$('#upload-message').dialog(
									'option', 'buttons', { 
										'Activate Themelet': function(){
											$(this).dialog('destroy');
											function actThemelet(){
												var setThemelet = data.themelet;
												var themeletOption = $('#generalthemelet option:last').after('<option selected="selected" value="'+setThemelet+'">'+setThemelet+'</option>');
												$.ajax({
													url: '../administrator/index.php?option=com_configurator&task=themelet_activate&themelet_name='+setThemelet+'&format=raw',
													method: 'post',
													success: function(ts, data){
														submitbutton('applytemplate');
												   		$(this).dialog('destroy');
												   		showScroll();
														return true;
													}
												});
										   	}
										   	checkChanges(actThemelet);
										},
										'Do Nothing': function(){
											$(this).dialog('destroy');
											showScroll();
										}
									}
								);
								$('#upload-message').dialog('open');
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
			   									submitbutton('applytemplate');
			   									var $tabs = $('#tabs').tabs();
												var logoTabs = $('#themelet-tabs').tabs();
												$tabs.tabs('select', 1);
												logoTabs.tabs('select', 1);
												$(this).dialog('destroy');
												showScroll();
											}
											checkChanges(actLogo);
										},
										'Configure': function(){
											var $tabs = $('#tabs').tabs();
											var logoTabs = $('#themelet-tabs').tabs();
											$tabs.tabs('select', 1);
											logoTabs.tabs('select', 1);
											window.location.reload(true); 
	  									  	$(this).dialog('destroy');
	  									  	showScroll();
										}
									}
								);
								$('#upload-message').dialog('moveToTop').dialog('open');
							}
							if(uploadType == 'background'){
								$('#upload-message').html(data.success);
								$('#upload-message').dialog(
									'option', 'buttons', { 
										'Activate': function(){
											$(this).dialog('destroy');
											function actBg(){
												var setBg = data.background;
												var logoBg = $('#backgroundsbg_image option:last').after('<option selected="selected" value="'+setBg+'">'+setBg+'</option>');
			   									submitbutton('applytemplate');
			   									var $tabs = $('#tabs').tabs();
												var bgTabs = $('#themelet-tabs').tabs();
												$tabs.tabs('select', 1);
												bgTabs.tabs('select', 2);
												$(this).dialog('destroy');
												showScroll();
											}
											checkChanges(actBg);
										},
										'Configure': function(){
											var $tabs = $('#tabs').tabs();
											var bgTabs = $('#themelet-tabs').tabs();
											$tabs.tabs('select', 1);
											bgTabs.tabs('select', 2);
											window.location.reload(true);
	  									  	$(this).dialog('destroy');
	  									  	showScroll();
										}
									}
								);
								$('#upload-message').dialog('moveToTop').dialog('open');
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
									$('#upload-message').dialog('moveToTop').dialog('open');
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
									$('#upload-message').dialog('moveToTop').dialog('open');
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
								$('#upload-message').dialog('moveToTop').dialog('open');
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
								$('#upload-message').dialog('moveToTop').dialog('open');
							}
						}
					}
				}
			});
			return false;
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
		$('#templateform').change(function(){
			if(!$.cookie('formChanges')){ $.cookie('formChanges', true); }
		});
		
		function checkChanges(action){
			var target;
			if($.cookie('formChanges')){			
				$('<div id="changesDialog"><p>You have made changes to Configurator that will be saved upon activation. Are you sure you want to activate and save these changes?</p><p><strong>If you cancel, this page will reload and your changes will be lost.</strong></p></div>').dialog({
					autoOpen: true,
					bgiframe: true,
					modal: true,
					width: 350,
					title: 'Warning!',
					close: action,
					buttons: {
						'Save & activate': function(){
							$.cookie('formChanges', null);
							$(this).dialog('close');
							return true;
						},
						'Activate only': function(){
							$.cookie('formChanges', null);
							if($this.attr('target') == ''){ 
								window.location.href($this.attr('href'));
			   				}else{ 
			   					target = $this.attr('target');
			   					window.open($this.attr('href'), target);
			   				}
							return false;
						}
					}
				});
			}else{
				action();
			}
		}
		
		$('td#toolbar-apply a, #bottom-save a').attr('onclick', '').click(function(){
			overlay('Saving Settings...');
			if($.cookie('change_themelet')){
				$.ajax({
					url: '../administrator/index.php?option=com_configurator&task=themelet_activate&themelet_name='+$.cookie('ct_themelet_name')+'&format=raw',
					method: 'post',
					success: function(ts, data){
						return true;
					}
				});
				$.ajax({
					url: '../administrator/index.php?option=com_configurator&task=themelet_check_existing&themelet_name='+$.cookie('ct_themelet_name')+'&format=raw',
					method: 'post',
					dataType: 'json',
					success: function(data, ts){
						if(data.exists == 'true'){
							<strong>closeOverlay()</strong>
							$('<div class="dialog-msg">It seems that you have used this themelet before.<br />Would you like to restore your <strong>previous settings</strong>, or would you like to use the <strong>themelet defaults</strong></div>').dialog({
					   			bgiframe: true,
					   			autoOpen: true,
					   			minHeight: 20,
					   			width: 500,
					   			stack: false,
					   			modal: true, 
					   			title: 'Activate',
					   			overlay: {
					   				'background-color': '#000', 
					   				opacity: 0.8 
					   			},
					   			close: function(){
									$(this).dialog('destroy');
									setTimeout(function(){ submitbutton('applytemplate'); }, 1000);
					   			},
								buttons: { 
									'Themelet Defaults': function(){
										$(this).dialog('close');
						   			},
						   			'Previous Settings': function(){
						   				$.ajax({
											url: '../administrator/index.php?option=com_configurator&task=themelet_activate_existing&themelet_name='+$.cookie('ct_themelet_name')+'&format=raw',
											method: 'post',
											success: function(data){
												return true;
											}
										});
						   				$(this).dialog('close');
						   			}
						   		}
						   	});
						}else{
							setTimeout(function(){ submitbutton('applytemplate'); }, 1000);
						}
					}
				});
			}else{
				setTimeout(function(){ submitbutton('applytemplate'); }, 1000);
			}
			return false;
		});
		
		$('td#toolbar-Link a, ul#submenu li.dashboard a, #header-box a').click(function(){
			var $this = $(this);
			var target;
			if($.cookie('formChanges')){			
				$('<div id="changesDialog">You have made changes to Configurator that will be lost if you navigate from this page. Are you sure you want to continue without saving?</div>').dialog({
					autoOpen: true,
					bgiframe: true,
					modal: true,
					title: 'Warning!',
					buttons: {
						'Save & continue': function(){
							$.cookie('formChanges', null);
							$(this).dialog('destroy');
							overlay('Saving Settings...');
							$('#templateform').submit(function(){
					   			$(this).ajaxSubmit({
					   				type: 'POST',
					   				url: '../administrator/index.php?format=raw',
					   				data: {
					   					option: 'com_configurator',
					   					task: 'applytemplate',
					   					isajax: 'true',
					   				},
					   				success: function(data, textStatus){
						   				$('#element-box').before('<dl id="system-message"><dt class="message">Message</dt><dd class="message message fade"><ul><li>Successfully saved your settings</li></ul></dd></dl>');
				  						$("#system-message dd.message").corners("10px");		
										$("#system-message dd.message ul").corners("10px");		
										$('#system-message').delay(3000, function(){ $('#system-message').fadeOut().remove(); });
						   				hideScroll();
						   				if($this.attr('target') == ''){ 
   											window.location.href($this.attr('href'));
						   				}else{ 
						   					target = $this.attr('target');
						   					window.open($this.attr('href'), target);
						   				}
						   				return false;		   			
					   				}
					   			});
					   			return false;
						   	});
					   		$('#templateform').trigger("submit");
							return false;
						},
						'Continue': function(){
							$.cookie('formChanges', null);
							$(this).dialog('destroy');
							if($this.attr('target') == ''){ 
			   					window.location.href($this.attr('href'));
			   				}else{ 
			   					target = $this.attr('target');
			   					window.open($this.attr('href'), target);
			   				}
							return false;
						}
					}
				});
			}else{
   				if($this.attr('target') == ''){ 
   					window.location.href($this.attr('href'));
   				}else{ 
   					target = $this.attr('target');
   					window.open($this.attr('href'), target);
   				}
			}
			return false;
		});
		
		<?php include('functions/blocks.js'); ?>
		<?php include('functions/keyboard.js'); ?>
		
		// ajax content for dialog
	    // welcome screen
	    function welcomeScreen(){
	    	$('#getting-started').dialog({
	    		width: '920px',
	    		bgiframe: true,
	   			autoOpen: true,
	   			minHeight: 20,
	   			stack: false,
	   			modal: true, 
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
	    	});
	    	hideScroll();
	    	$(".close-welcome").click(function(){
				$('#getting-started').dialog('destroy');
				showScroll();
				if($.cookie('info')){ $.cookie('info', null); }
				return false;
			});
			$('#splash').tabs({
				fx: { opacity: 'toggle' },				cookie: {					name: 'welcome-screen',					expires: 30,					path: '/',			 	}			});
	    }
	    
	    $('.info-link').click(function(){
			$('#getting-started').load('../administrator/components/com_configurator/tooltips/gettingstarted.php', function(){
		    	return welcomeScreen();
		    });
		    return false;
		});
	    
	    if(!$.cookie('welcome_screen') && $.cookie('am_logged_in')){
	    	$('#getting-started').load('../administrator/components/com_configurator/tooltips/gettingstarted.php', function(){
		    	return welcomeScreen();
		    });
	    	$.cookie('welcome_screen', 'hide', { path: '/', expires: 366 });			
	    }
	    
	    // prefs
		function preferencesScreen(){
			hideScroll();   
		    $('#preferences-screen').dialog({
	    		width: '450px',
	    		bgiframe: true,
	   			autoOpen: true,
	   			minHeight: 20,
	   			stack: false,
	   			modal: true,
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
	    	});
	    	$('#preferences-screen a.close-preferences').corners('bottom-left 10px');
	    	$(".close-preferences").click(function(){
				$('#preferences-screen').dialog("close");
				showScroll();
				if($.cookie('prefs')){ $.cookie('prefs', null); }
				return false;
			});
			
			$('.btn-prefs').click(function(){
				
				$('#preferences-screen').dialog('option', 'title', 'Saving...');
				overlay('Processing...');

				$('#preferences-form').submit(function(){
		   			$(this).ajaxSubmit({
		   				type: 'POST',
		   				url: '../administrator/index.php?format=raw',
		   				data: {
		   					option: 'com_configurator',
		   					task: 'saveprefs'
		   				},
			   			success: function(data, textStatus){
			   				$('#preferences-screen').dialog('close');
			    			window.location.reload(true);
			   				return false;
			   			}
		   			});
		   			return false;
		   		});
			});
	    }
	    
    	$('td#preferences a').click(function(){ 
		    preferencesScreen();
			return false;
    	});
    	
    	// keyboard screen
		function keyboardScreen(){
			overlay();
			hideScroll();
		    $('#keyboard-screen').dialog({
	    		width: '700px',
	    		bgiframe: true,
	   			autoOpen: true,
	   			minHeight: 20,
	   			//modal: true,
	   			dialogClass: 'keyboard', 
	   			title: 'Keyboard Shortcuts',
	   			overlay: {
	   				'background-color': '#000', 
	   				opacity: 0.8 
	   			},
	   			close: function(){
	   				showScroll();
	   				closeOverlay();
	   				$(this).dialog('destroy');
	   			},
	   			zIndex: 9999
	    	});
	    }
	    
    	$('#keyboard-toggle').click(function(){ 
	    	$('#keyboard-screen').load('../administrator/components/com_configurator/includes/keyboard.php', function(){
		    	return keyboardScreen();
		    }); 
			return false;
    	});
    	
    	function logoutCfg() {
    		$('#content-box').after('<div id="logout-message" class="dialog-msg" style="display:none;"><p>You are about to logout. Please ensure you have saved your changes.</p>'
									+'<p><strong>Please remember: You will need to be connected to the internet to login again.</strong></p></div>');
			hideScroll();
			$('#logout-message').dialog({
	   			autoOpen: true, 
	   			bgiframe: true, 
	   			resizable: false,
	   			draggable: false,
	   			minHeight: 20,
	   			width: 350,
	   			modal: true, 
	   			title: 'Logout',
	   			overlay: {
	   				backgroundColor: '#000', 
	   				opacity: 0.5 
	   			},
	   			close: function(){
	   				$.cookie('logout-toggle', null);
	   				$(this).remove();
					showScroll();
	   			},
				buttons: {
					'Logout': function(){
						$.cookie('am_logged_in', null, { path: '/', expires: -1 });
						$.cookie('am_logged_in_user', null, { path: '/', expires: -1 });
						$.cookie('member_id', null, { path: '/', expires: -1 });
						$.cookie('member_data', null, { path: '/', expires: -1 });
						$.cookie('logout-toggle', null);
						window.location.reload(true);
					},
					'Stay logged in': function(){
						$(this).dialog('close');
					}
				}	
			});
    	}
		
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
					$(this).dialog('destroy');
					$('.toolguides').empty();
					closeOverlay();
					showScroll();		
				}
			});
    		
    		if(!$.cookie('tooltip'+tid)){
    			overlay();
				$.cookie('tooltip'+tid, 'open');
				$('.toolguides').load(toolPage);
				$('.toolguides').dialog('open');
			}else{
				$.cookie('tooltip'+tid, null);
				$('.toolguides').dialog('close');
				$('.toolguides').empty();
				closeOverlay();
			}
			
    	}
		
		/* Lost Password ------------------
		-------------------------------- */
		$('#lost-pass').click(function(){
			hideScroll();
			$('#lost-password-form').dialog({
				autoOpen: true,
				modal: true,
				bgiframe: true,
				width: 400,
				close: function(){
					showScroll();
					$(this).dialog('destroy');
				}
			});
			$('#sendpass').submit(function(){
				function validate(formData, jqForm, options) { 
				    for (var i=0; i < formData.length; i++) { 
				    	if (!formData[i].value) { 
				            $('<div><strong>Username or email address is required.</strong></div>').dialog({
				            	bgiframe: true,
								autoOpen: true,
								stack: true,
								title: 'Error',
								buttons: {
									'Ok': function(){
										$(this).dialog('destroy');
									}
								},
								close: function(){
									$(this).dialog('destroy');
									showScroll();
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
				    overlay('Processing...');				    
				    return true; 
				}
				
				$(this).ajaxSubmit({
					beforeSubmit: validate,
					type: 'GET',
					dataType: 'jsonp',
					data: {
						format: 'json'
					},
					success: function(data, status, error){
						closeOverlay()
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
							$('<div>'+data.success+'</div>').dialog({
				            	bgiframe: truex,
								autoOpen: true,
								stack: true,
								title: 'Success',
								buttons: {
									'Ok': function(){
										showScroll();
										$(this).dialog('destroy');
										$('#lost-password-form').dialog('close');
									}
								},
								close: function(){
									$(this).dialog('destroy');
									$('#lost-password-form').dialog('close');
									showScroll();
								},
								modal: true,
								overlay: {
									'background-color': '#000',
									opacity: 0.8
								}
							});
						}
					}
				});
				return false;
			});
			return false;
		});		
	});
})(jQuery);