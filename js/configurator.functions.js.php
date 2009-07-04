<?php 
header('content-type: text/html; charset: UTF-8');
function pageURL() {
	error_reporting(E_ALL ^ E_NOTICE);
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
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
	
		jQuery.fn.delay = function(time,func){
    		return this.each(function(){
	    	    setTimeout(func,time);
    		});
		};
	
  		$.preloadCssImages();	
		/* Generic ----------------------------
	    ------------------------------------ */
		$("#submenu li:last").addClass("last");
		$("#blocks-tabs .ui-tabs-nav li:last").addClass("last");
		
		$("#tabs .options-panel").wrapInner('<div class="options-inner"></div>');
		$("#tabs ol.forms li:first-child").addClass("first");		
		$("#tabs ol.forms li:last-child").addClass("last");		
		$("#tabs ol.forms li:odd").addClass("alt");	

		$("#assets-tabs #themelets-list li:even").addClass("alt");			
		$("#assets-tabs #logos-list li:even").addClass("alt");			
		$("#assets-tabs #backgrounds-list li:even").addClass("alt");
		
		$('#loginpass').showPassword('.sp-check', { name: 'show-password' })			

//		$('#help').hover(function() {
//		  $(this).addClass('hover');
//		}, function() {
//		  $(this).removeClass('hover');
//		});

		// var items = ['list item 1', 'list item 2', 'list item 3'];
		// var UL = $('#submenu-box <ul/>').append( '<li>' + items.join('</li><li>') + '</li>' );
		
		$("#submenu").append('<li class="preferences"><a href="#">Preferences</a></li>','<li class="feedback"><a href="#" id="report-bug-link">Send Feedback</a></li>','<li class="full-mode" id="fullscreen"><a href="#" id="screenmode">Fullscreen Mode</a></li>');
		
		$("#minwidth-body.full-mode #submenu").append('<li class="save"><a href="#">Save</a></li>');

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

//		$("#loginpass").each(function(){
//			$(this).attr('type', 'text');
//		});
//		$("#showpass").click(function(){
//		if ($("#showpass").attr("checked")){
//			$("#loginpass").attr("type","text");
//		}else {
//		$("#loginpass").attr("type","password");
//		}
//		});

	   $("#footer").fadeTo("slow", 0.3); // This sets the opacity of the thumbs to fade down to 30% when the page loads
	   $("#footer").hover(function(){
	   $(this).fadeTo("slow", 1.0); // This should set the opacity to 100% on hover
	   },function(){
	   $(this).fadeTo("slow", 0.3); // This should set the opacity back to 30% on mouseout
	   });

//		if ($("#install-type input").hasClass("focus")){
//		$("#install-type label").addClass("active-radio");
//		}
		$(".upload-themelet").click(function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#tools-tabs").tabs();
		maintabs.tabs("select",3);
		subtabs.tabs("select",0);
		$("#upload_themelet").attr("checked",true);
		return false;
		});
				
		$(".upload-logo").click(function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#tools-tabs").tabs();
		maintabs.tabs("select",3);
		subtabs.tabs("select",0);
		$("#upload_logo").attr("checked",true);
		return false;
		});

		$(".upload-bg").click(function(){
		var maintabs = $("#tabs").tabs();
		var subtabs = $("#tools-tabs").tabs();
		maintabs.tabs("select",3);
		subtabs.tabs("select",0);
		$("#upload_background").attr("checked",true);
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
			$('#screenmode').text('Normal Mode');
		}
		
		$('#fullscreen').click(function(){
			$('#minwidth-body').toggleClass("full-mode");
			$('#fullscreen').toggleClass("normal-mode");
			if($('#screenmode').text() == 'Fullscreen Mode'){ 
				$('#screenmode').text('Normal Mode'); 
				$.cookie('fullscreen', 'true', { path: '/', expires: 30 });
			}else{ 
				$('#screenmode').text('Fullscreen Mode'); 
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
			return false; 
		});
		$('#themelet-desc a').click(function(){
			$('#themelet-desc').hide('slow');
			$('#themelet-tabs .desc-overlay').fadeTo('fast',0).remove();
			$.cookie('themelet-desc', true,{path:'/',expires:30});
			return false; 
		});
		$('#tools-desc a').click(function(){
			$('#tools-desc').hide('slow');
			$('#tools-tabs .desc-overlay').fadeTo('fast',0).remove();
			$.cookie('tools-desc', true,{path:'/',expires:30});
			return false; 
		});
		$('#assets-desc a').click(function(){
			$('#assets-desc').hide('slow');
			$('#assets-tabs .desc-overlay').fadeTo('fast',0).remove();
			$.cookie('assets-desc', true,{path:'/',expires:30});
			return false; 
		});
		$('#blocks-desc a').click(function(){
			$('#blocks-desc').hide('slow');
			$('#blocks-tabs .desc-overlay').fadeTo('fast',0).remove();
			$.cookie('blocks-desc', true,{path:'/',expires:30});
			return false; 
		});
		
		function hideScroll(){
			$(document).bind('scroll', function(){return false;});
			$('html').css({'overflow-y': 'hidden', paddingRight: '15px'});
			$('#qtip-blanket, #alf-image').css({ width: arrPageSizes[0]+15 });
		}
		
		function showScroll(){
			$(document).bind('scroll', function(){return false;});
			$('html').css({'overflow-y': 'scroll', paddingRight: '0'});
//			$('#qtip-blanket').css({ width: arrPageSizes[0]+15 });
		}
	
		
		$('.tl-active ul.buttons li.btn-activate, .tl-active ul.buttons li.btn-delete').each(function(){
			$(this).children().fadeTo('fast', 0.5);
			$('.tl-active ul.buttons li.btn-activate a, .tl-active ul.buttons li.btn-delete a').each(function(){
				$(this).attr('href', '#inactive');
				$(this).click(function(){ 
					return false; 
				});
			});
		});
		
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
		
		$('textarea').autoResize({ extraSpace:40, animate:false });
					
	    /* Inputs and checkboxes --------------
	    ------------------------------------ */
	    /*$("input.input-installer").filestyle({ 
     		image: "components/com_configurator/images/select-btn.png",
     		imageheight : 27,
     		imagewidth : 81,
     		width : 217
 		});*/
 		
 		$('.alf-input').focus(function(){
 			if(this.value == 'username' || this.value == 'password'){ 
 				$(this).val(''); 
 			}
 		}).blur(function(){
 			if(this.value == ''){ $(this).val($(this).attr('title')); }
 		});

 		
 		/* Backup Message ---------------------
 		------------------------------------ */
 		$('input[name="themeletbackup"]').click(function(){
 			alert('This will be available in the second beta phase. Please backup your folder manually');
 			$(this).attr('checked', false);
 		})
	   
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
		$('#tools-tabs').tabs({
			fx: { opacity: 'toggle' },			cookie: {				name: 'tools-tabs',				expires: 30,				path: '/',		 	} 		});
		$('#assets-tabs').tabs({
			fx: { opacity: 'toggle' },			cookie: {				name: 'assets-tabs',				expires: 30,				path: '/',		 	} 		});

		$('#getting-started').tabs({
			fx: { opacity: 'toggle' },			cookie: {				name: 'welcome-screen',				expires: 30,				path: '/',		 	}
		 			});

		
		$('#tabs .ui-tabs-panel').removeClass("ui-corner-bottom").corners("7px bottom");
		$("#themelets").removeClass("ui-widget-content");			
		
//		/* Colour Picker ----------------------
//	    ------------------------------------ */
//		function loadColourPicker(elid) {
//			
			// keep applied colour
//			if($(elid).prev().val() != 'default'){
//    			$(elid).css({
//    				'background-color': '#'+$(elid).prev().val()
//    			});
//    		}
			// load the colour picker
//    		$(elid).ColorPicker({
//       			flat: true,
//    			onSubmit: function(hsb, hex, rgb){
//					var cp = $(elid).children().attr('id');
//					$(this).prev().val('#'+hex);
//					$('#'+cp).fadeOut(500);
//				},
//				onHide: function () {
					//
//				},
//				onChange: function (hsb, hex, rgb) {
//					$(elid).prev().val('#'+hex);
//					$(elid).css('background-color', '#' + hex);
//				}
//    		}).bind('keyup', function(){ // set colour picker to use current value
//				$(elid).ColorPickerSetColor($(this).prev().val());
//			});
//    	}
//    	
//    	$('a.picker').click(function(){
//       		loadColourPicker($(this).prev());
//    		$('.colorpicker').css({
//    			'display': 'block',
//    			'z-index': '9999',
//    			'position': 'relative',
//    			'bottom': '33px',
//    			'right': '-23px'
//    		});
//    		cp = $(this).prev().children().attr('id');
//    		$('#'+cp).css('display','block');
//    		return false;
//    	});
     	
     	//all hover and click logic for buttons
		$(".fg-button:not(.ui-state-disabled)")
//		.hover(
//			function(){ 
//				$(this).addClass("ui-state-hover"); 
//			},
//			function(){ 
//				$(this).removeClass("ui-state-hover"); 
//			}
//		)
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
					
	
	
		$("#toggle-shelf").click(function(){
			if(!$.cookie('shelf')){
				$('.open').switchClass('open', 'closed', 300);
				$.cookie('shelf', 'hide', { path: '/', expires: 30 });
				$(this).text('Show Shelf');
			}else{
				$('.closed').switchClass('closed', 'open', 300);
				$.cookie('shelf', null, { path: '/', expires: 30 });
				$(this).text('Hide Shelf');
			}
			return false;
		});
	
		var options = { path: '/', expires: 30 };
	
		$("#themelet-switch a.switch-view").toggle(function(){
			$(this).addClass("swap");
			$("#themelets-list").fadeOut("fast", function() {
				$(this).fadeIn("fast").removeClass("thumb-view").addClass("list-view");
				$.cookie('themelets-view', 'list', options);
				return(false);		
			});
		}, function () {
			$(this).removeClass("swap");
			$("#themelets-list").fadeOut("fast", function() {
				$(this).fadeIn("fast").removeClass("list-view").addClass("thumb-view");
				$.cookie('themelets-view', 'thumb', options);
				return(false);		
			});
		}); 
		
		
		$("#backgrounds-switch a.switch-view").toggle(function(){
			$(this).addClass("swap");
			$("#backgrounds-list").fadeOut("fast", function() {
				$(this).fadeIn("fast").removeClass("thumb-view").addClass("list-view");
				$.cookie('backgrounds-view', 'list', options);
				return(false);
			});
		}, function () {
			$(this).removeClass("swap");
			$("#backgrounds-list").fadeOut("fast", function() {
				$(this).fadeIn("fast").removeClass("list-view").addClass("thumb-view");
				$.cookie('backgrounds-view', 'thumb', options);
				return(false);
			});
		}); 
		
		$("#logos-switch a.switch-view").toggle(function(){
			$(this).addClass("swap");
			$("#logos-list").fadeOut("fast", function() {
				$(this).fadeIn("fast").removeClass("thumb-view").addClass("list-view");
				$.cookie('logos-view', 'list', options);
				return(false);
			});
		}, function () {
			$(this).removeClass("swap");
			$("#logos-list").fadeOut("fast", function() {
				$(this).fadeIn("fast").removeClass("list-view").addClass("thumb-view");
				$.cookie('logos-view', 'thumb', options);
				return(false);
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
		$('#report-bug-link').click(function() {
			$('#report-bug').dialog('open');
		});
		
		$('#ff-reset').click(function(){ $('#report-bug').dialog('close'); });
		
		$('#feedbackform').submit(function(){ 
			
			$(this).ajaxSubmit({
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
					if(typeof(data.error) != 'undefined'){						
						if(data.error != ''){
							alert(data.error);
						}
					}else{
						alert(data.message);
						$('#feedbackform').resetForm();
						$('#report-bug').dialog('close');	
					}
				},
				error: function(data){
					alert(data);
				}
			});
			return false;
		});
     	     	
		
		/* Tooltips ----------------------
		------------------------------- */
		var arrPageSizes = ___getPageSize();
		$(window).resize(function() {
				// Get page sizes
				var arrPageSizes = ___getPageSize();
				// Style overlay and show it
				$('#qtip-blanket, #alfimage').css({
					width:		arrPageSizes[0],
					height:		arrPageSizes[1]
				});
		});
		$('<div id="qtip-blanket">').css({
			position: 'absolute',
	        top: 0,
	        left: 0,
	        width: arrPageSizes[0],
			height: arrPageSizes[1],
	        opacity: 0.7,
	       	backgroundColor: 'black',
	        zIndex: 5000
		})
	    .appendTo($('body')) // Append to the document body
	    .hide();
	    
	    if(!$.cookie('welcome_screen') && $.cookie('am_logged_in')){
	    	$('#getting-started').dialog({
	    		width: '920px',
	    		bgiframe: true,
	   			autoOpen: false,
	   			minHeight: 20,
	   			stack: false,
	   			modal: true, 
	   			dialogClass: 'welcome',
	   			title: '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span><span style="float:left;padding-top: 2px">Welcome to Configurator</span>',
	   			overlay: {
	   				'background-color': '#000', 
	   				opacity: 0.8 
	   			}
	    	});
	    	$('#getting-started').dialog('open');
	    	$.cookie('welcome_screen', 'hide', { path: '/', expires: 366 });

			$(".close-welcome").click(function(){
				$('#getting-started').dialog("destroy");
				return false;
			});
	    }
	    
	    $('.info-link').click(function(){
	    	$('#getting-started').dialog('open');
	    	return false;
	    });
	    
	    // prefs
	    $('#preferences').dialog({
    		width: '700px',
    		bgiframe: true,
   			autoOpen: false,
   			minHeight: 20,
   			stack: false,
   			modal: true, 
   			title: '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span><span style="float:left;padding-top: 2px">Activate</span>',
   			overlay: {
   				'background-color': '#000', 
   				opacity: 0.8 
   			}
    	});
    	$('li.preferences a').click(function(){ $('#preferences').dialog('open'); return false; });
	    $('#getting-started a.close-welcome').corners('bottom-left 10px');
	    
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
				      background: '#BEDCE7',
				      color: 'black',
				      textAlign: 'left',
				      border: {
				         width: 7,
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
	    
	    $('.tt-modal').each(function(){
	    
	    	var docroot = '../administrator/components/com_configurator/tooltips/'; // define doc root for pulling the docs
	   		var thetitle = $(this).attr("title").split('::'); 
	   		var qtTitle = thetitle[0];
	   		var qtLink = docroot+thetitle[1];
	   		
	   		$(this).attr("title", '');
	   			   		
	   		$(this).qtip({
				content: {
					title: {
						text: qtTitle,
						button: 'Close'
					},
					url: qtLink
				},
				position: {
					target: $(document.body), // Position it via the document body...
					corner: 'center' // ...at the center of the viewport
				},
				show: {
					when: 'click', // Show it on click
					solo: true // And hide all other tooltips
				},
				hide: false,
				style: {
				      width: 300,
				      padding: 10,
				      background: '#E8DF96',
				      color: 'black',
				      textAlign: 'left',
				      border: {
				         width: 7,
				         radius: 5,
				         color: '#536E28'
				      },
					name: 'light'
				},
				api: {
					beforeShow: function(){	
						hideScroll();	
						$('#qtip-blanket').fadeIn(this.options.show.effect.length);
					},
					beforeHide: function(){
						showScroll();
						$('#qtip-blanket').fadeOut(this.options.hide.effect.length);
					},
					onShow: function(){
					
						$('.modal-preview').each(function(){
	   		
				   		var title = $(this).attr('title');
				   		$(this).attr('title', ''); 
				   		
				   		var content = '<img src="';
			     		content += title;
			      		content += '" alt="Loading thumbnail..." height="144" width="176" />';
				   		
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
			         			padding: '0 0 0 0',
			         			width: {
			         				max: '193'
			         			}
							}
			
						});
						
				   	});
					
					}
				}
			});
			
	   	});
	   	
	   	$('a.modal-link').each(function(){
	   	
	   		$(this).click(function(){ return false; });
	    
	    	var docroot = '../administrator/components/com_configurator/tooltips/'; // define doc root for pulling the docs
	   		var qtLink = docroot+$(this).attr("href");
	   		var qtTitle = $(this).attr('title');
	   		
			$(this).qtip({
				content: {
					title: {
						text: qtTitle,
						button: 'Close'
					},
					url: qtLink
				},
				position: {
					target: $(document.body), // Position it via the document body...
					corner: 'center' // ...at the center of the viewport
				},
				show: {
					when: 'click'
				},
				hide: false,
				style: {
					padding: 0,
					background: '#fff',
					color: '#111',
					border: {
	     				width: 3,
	     				radius: 8
	     			},
         			width: {
         				max: '780'
         			},
					name: 'dark'
				},
				api: {
					beforeShow: function(){	
						hideScroll();	
						$('#qtip-blanket').fadeIn(this.options.show.effect.length);
					},
					beforeHide: function(){
						showScroll();
						$('#qtip-blanket').fadeOut(this.options.hide.effect.length);
					},
					onShow: function(){
					
						$('.modal-preview').each(function(){
	   		
				   		var title = $(this).attr('title');
				   		$(this).attr('title', ''); 
				   		
				   		var content = '<img src="';
			     		content += title;
			      		content += '" alt="Loading thumbnail..." height="144" width="176" />';
				   		
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
			         			padding: '0 0 0 0',
			         			width: {
			         				max: '193'
			         			}
							}
			
						});
						
				   	});
					
					}
				}
			});
			
	   	});
	   	
	   	$('.ttim').each(function(){
	    	var thetitle = $(this).attr("title");
	   		
	   		$(this).qtip({
   				content: thetitle ,
			   	show: 'mouseover',
			   	hide: 'mouseout',
			   	style: {
			   		name: 'dark',
			   		border: {
			   			width: 5,
			   			radius: 5
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
         			margin: '0px',
         			//width: '200px',
         			//height: '133px'
				}

			});
			
	   	});
	   	
	   	$('.refimage-block').qtip({
   			content: {
   				title: {
   					text: 'Visual Reference - Blocks',
   					button: 'Close'
   				},
   				text: '<img src="../administrator/components/com_configurator/images/visual-reference-blocks.png" alt="Visual Reference - Blocks" height="608" width="600" />'
   			},
   			position: {
				target: $(document.body), // Position it via the document body...
				corner: 'center' // ...at the center of the viewport
			},
   			show: {
   				when: 'click'
   			},
			hide: false,
			style: {
				name: 'dark',
				border: {
     				width: 3,
     				radius: 8
     			},
     			width: {
     				max: '600'
     			},
     			height: {
     				max: '608'
     			},
     			padding: '0'
			},
			api: {
				beforeShow: function(){	
					hideScroll();	
					$('#qtip-blanket').fadeIn(this.options.show.effect.length);
				},
				beforeHide: function(){
					showScroll();
					$('#qtip-blanket').fadeOut(this.options.hide.effect.length);
				},
			}
   		});
	   	
	   	$('.refimage-position').qtip({
   			content: {
   				title: {
   					text: 'Visual Reference - Positions',
   					button: 'Close'
   				},
   				text: '<img src="../administrator/components/com_configurator/images/visual-reference-positions.png" alt="Visual Reference - Positions" height="608" width="600" />'
   			},
   			position: {
				target: $(document.body), // Position it via the document body...
				corner: 'center' // ...at the center of the viewport
			},
   			show: {
   				when: 'click'
   			},
			hide: false,
			style: {
				name: 'dark',
				border: {
     				width: 3,
     				radius: 8
     			},
     			width: {
     				max: '600'
     			},
     			height: {
     				max: '608'
     			},
     			padding: '0'
			},
			api: {
				beforeShow: function(){	
					hideScroll();	
					$('#qtip-blanket').fadeIn(this.options.show.effect.length);
				},
				beforeHide: function(){
					showScroll();
					$('#qtip-blanket').fadeOut(this.options.hide.effect.length);
				},
			}
   		});

	   	/* Activate functions -----------------
	    ------------------------------------ */
	   	$('li.tl-inactive ul li.btn-activate a').click(function(){
	   	
	   		$('<div class="thdlg" style="display:none;">Your new themelet is activated. <br />Would you like to configure this themelet?</div>').dialog({
	   			bgiframe: true,
	   			autoOpen: false,
	   			minHeight: 20,
	   			stack: false,
	   			modal: true, 
	   			title: '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span><span style="float:left;padding-top: 2px">Activate</span>',
	   			overlay: {
	   				'background-color': '#000', 
	   				opacity: 0.8 
	   			},
	   			close: function(){
	   				var mainTabs = $('#tabs').tabs();
					var subTabs = $('#site-tabs').tabs();
					mainTabs.tabs('select', 1);
					subTabs.tabs('select', 0);
					$(this).remove();
	   			},
				buttons: { 
					'Yes, configure themelet': function(){
						$(this).dialog('close');
		   			},
		   			'No thanks': function(){
		   				$(this).remove();
		   			}
		   		}
		   	});
	   		
	   		var setThemelet = $(this).attr('name');
	   		$('#generalthemelet option[value="'+setThemelet+'"]').attr('selected', true);
	   		$('#templateform input[name="task"]').remove();
	   		$('#templateform').submit(function(){
	   			$(this).ajaxSubmit({
	   				type: 'POST',
	   				url: '../administrator/index.php?option=com_configurator&task=applytemplate&format=raw&isajax=true',
		   			success: function(data, textStatus){
		   			
		   				$('#element-box').before('<dl id="system-message"><dt class="message">Message</dt><dd class="message message fade"><ul><li>Successfully saved your settings</li></ul></dd></dl>');
  						$("#system-message dd.message").corners("10px");		
						$("#system-message dd.message ul").corners("10px");		
						$('#system-message').delay(3000, function(){ $('#system-message').fadeOut().remove(); });
		   				
						$('.tl-active ul.buttons li.btn-activate a, .tl-active ul.buttons li.btn-delete a').fadeTo('fast', 1).each(function(){
							$(this).attr('href', '#active');
							$(this).css('cursor', 'pointer');
						});
						$('li.tl-inactive ul li.btn-activate a[name="'+setThemelet+'"], li.tl-inactive ul li.btn-delete a[name="'+setThemelet+'"]').fadeTo('fast', 0.5).each(function(){
							$(this).attr('href', '#inactive');
							$(this).css('cursor', 'default');
							$(this).click(function(){
								return false;
							});
						});
						
						$('#current-themelet li.ct-name').html('<span>Name: </span>'+$('li.tl-inactive ul li.btn-activate a[name="'+setThemelet+'"]').attr('title').replace('Activate ', ''));
						$('#current-themelet li.ct-version').html('<span>Version: </span>'+$('ul.'+setThemelet+' li.tl-installed').text().replace('Installed version: ',''));
						$('#current-themelet li.ct-thumb').html('<span>&nbsp;</span><img src="../templates/morph/assets/themelets/'+setThemelet+'/themelet_thumb.png" width="108" height="72" align="middle" alt="'+$('#current-themelet li.ct-name').text()+'" />');
						$('.thdlg').dialog('open');
						
					}
	   			});
	   			return false;
	   		});
		    $('#templateform').trigger("submit");
	   		return false;
	   	});
	   	
	   	$('li.logo-item ul li.btn-activate a').click(function(){
	   	
	   		$('<div class="lgdlg" style="display:none;">Your new logo is activated. <br />Would you like to configure the logo options?</div>').dialog({
	   			bgiframe: true,
	   			autoOpen: false,
	   			minHeight: 20,
	   			stack: false,
	   			modal: true, 
	   			title: '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span><span style="float:left;padding-top: 2px">Activate</span>',
	   			overlay: {
	   				'background-color': '#000', 
	   				opacity: 0.8 
	   			},
	   			close: function(){
		   			var mainTabs = $('#tabs').tabs();
					var subTabs = $('#themelet-tabs').tabs();
					mainTabs.tabs('select', 1);
					subTabs.tabs('select', 1);
	   			},
				buttons: { 
					'Yes, configure logo': function(){
						$(this).dialog('close');
					},
		   			'No thanks': function(){
		   				$(this).remove();
		   			}
		   		}
		   	});
		   	
	   		var setLogo = $(this).attr('name');
	   		var logoOption = $('#logologo_image > option[value='+setLogo+']').attr('selected', true);
	   		$('#templateform').submit(function(){
	   			$(this).ajaxSubmit({
	   				type: 'POST',
	   				url: '../administrator/index.php?option=com_configurator&task=applytemplate&format=raw&isajax=true',
		   			success: function(data, textStatus){
		   			
		   				$('#element-box').before('<dl id="system-message"><dt class="message">Message</dt><dd class="message message fade"><ul><li>Successfully saved your settings</li></ul></dd></dl>');
  						$("#system-message dd.message").corners("10px");		
						$("#system-message dd.message ul").corners("10px");		
						$('#system-message').delay(3000, function(){ $('#system-message').fadeOut().remove(); });
		   				$('.lgdlg').dialog('open');
				   				   			
	   				}
	   			});
	   			return false;
		   	});
	   		$('#templateform').trigger("submit");
	   		return false;
	   	});
	   	
	   	$('li.background-item ul li.btn-activate a').click(function(){
	   	
	   		$('<div class="bgdlg" style="display:none;">Your new background is activated. <br />Would you like to configure the background options?</div>').dialog({
	   			bgiframe: true,
	   			autoOpen: false,
	   			minHeight: 20,
	   			stack: false,
	   			modal: true, 
	   			title: '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span><span style="float:left;padding-top: 2px">Activate</span>',
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
				},
				buttons: { 
					'Yes, configure background': function(){
						$(this).dialog('close');
		   			},
		   			'No thanks': function(){
		   				$(this).remove();
		   			}
		   		}
		   	});
	   		
	   		var setBackground = $(this).attr('name');
	   		var backgroundOption = $('#backgroundsbg_image > option[value='+setBackground+']');
	   		backgroundOption.attr('selected', true);
	   		
	   		$('#templateform').submit(function(){
	   			$(this).ajaxSubmit({
	   				type: 'POST',
	   				url: '../administrator/index.php?option=com_configurator&task=applytemplate&format=raw&isajax=true',
		   			success: function(data, textStatus){
		   			
		   				$('#element-box').before('<dl id="system-message"><dt class="message">Message</dt><dd class="message message fade"><ul><li>Successfully saved your settings</li></ul></dd></dl>');
  						$("#system-message dd.message").corners("10px");		
						$("#system-message dd.message ul").corners("10px");		
						$('#system-message').delay(3000, function(){ $('#system-message').fadeOut().remove(); });
		   				$('.bgdlg').dialog('open');
		   				
	   				}
	   			});
	   			return false;
		   	});
	   		$('#templateform').trigger("submit");
	   		return false;
	   	});
	   		   	
	   	/* Delete functions -------------------
	    ------------------------------------ */
	    // themelets
	   	$('li.tl-inactive ul li.btn-delete a').click(function(){
			
	   		var setThemelet = $(this).attr('name');
	   		var setThemeletName = $(this).attr('title').replace('Delete ', '').replace(' Themelet', '');	   		
	   		var alertMessage = 'Are you sure you want to delete the "'+setThemeletName+'" themelet?<br />This is irreversible!';
	   		
	   		$('#footer').after('<div id="assets-output" style="display:none;"></div>');
	   		$('#assets-output').html(alertMessage);
	   		
			$('#assets-output').dialog({
	   			bgiframe: true,
	   			autoOpen: true,
	   			resizable: false,
	   			draggable: false,
	   			minHeight: 20,
	   			modal: true, 
	   			title: '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span><span style="float:left;padding-top: 2px">Delete</span>',
	   			overlay: {
	   				'background-color': '#000', 
	   				opacity: 0.8 
	   			},
				buttons: { 
					'Yes': function(){
						$(this).dialog('destroy');
						$.ajax({
			   				type: 'GET',
			   				url: '../administrator/index.php?option=com_configurator&format=raw&task=deleteAsset&deltype=themelet&asset='+setThemelet,
			   				success: function(data, textStatus){
			   					if(textStatus == 'success'){
			   						$('a[name="'+setThemelet+'"]').parent().parent().parent().hide('slow');			   						
			   						$('#footer').after('<div id="assets-output" style="display:none;"></div>');
			   						$('#assets-output').html('Themelet deleted successfully');
						   			$('#assets-output').dialog({
						   				bgiframe: true,
							   			autoOpen: true,
							   			resizable: false,
							   			draggable: false,
							   			minHeight: 20,
							   			modal: true, 
							   			title: '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span><span style="float:left;padding-top: 2px">Delete</span>',
							   			overlay: {
							   				'background-color': '#000', 
							   				opacity: 0.8 
							   			},
										buttons: { 
											'OK': function(){ $(this).dialog('destroy'); }
										}
									});
			   					}
			   				}
			   			});
					},
					'No': function(){
						$(this).dialog('destroy');
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
			
			$('#footer').after('<div id="assets-output" style="display:none;"></div>');
	   		$('#assets-output').html(alertMessage);
	   		
			$('#assets-output').dialog({
	   			bgiframe: true,
	   			autoOpen: true,
	   			resizable: false,
	   			draggable: false,
	   			minHeight: 20,
	   			modal: true, 
	   			title: '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span><span style="float:left;padding-top: 2px">Delete</span>',
	   			overlay: {
	   				'background-color': '#000', 
	   				opacity: 0.8 
	   			},
				buttons: { 
					'Yes': function(){
						$(this).dialog('destroy');
						$.ajax({
			   				type: 'GET',
			   				url: '../administrator/index.php?option=com_configurator&format=raw&task=deleteAsset&deltype=background&asset='+setBackground,
			   				success: function(data, textStatus){
			   					if(textStatus == 'success'){
			   						$('a[name="'+setBackground+'"]').parent().parent().parent().hide('slow');			   						
			   						$('#footer').after('<div id="assets-output" style="display:none;"></div>');
			   						$('#assets-output').html('Background deleted successfully');
						   			$('#assets-output').dialog({
						   				bgiframe: true,
							   			autoOpen: true,
							   			resizable: false,
							   			draggable: false,
							   			minHeight: 20,
							   			modal: true, 
							   			title: '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span><span style="float:left;padding-top: 2px">Delete</span>',
							   			overlay: {
							   				'background-color': '#000', 
							   				opacity: 0.8 
							   			},
										buttons: { 
											'OK': function(){ $(this).dialog('destroy'); }
										}
									});
			   					}
			   				}
			   			});
					},
					'No': function(){
						$(this).dialog('destroy');
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
	   		$('#assets-output').html(alertMessage);
	   		
			$('#assets-output').dialog({
	   			bgiframe: true,
	   			autoOpen: true,
	   			resizable: false,
	   			draggable: false,
	   			minHeight: 20,
	   			modal: true, 
	   			title: '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span><span style="float:left;padding-top: 2px">Delete</span>',
	   			overlay: {
	   				'background-color': '#000', 
	   				opacity: 0.8 
	   			},
				buttons: { 
					'Yes': function(){
						$(this).dialog('destroy');
						$.ajax({
			   				type: 'GET',
			   				url: '../administrator/index.php?option=com_configurator&format=raw&task=deleteAsset&deltype=logo&asset='+setLogo,
			   				success: function(data, textStatus){
			   					if(textStatus == 'success'){			   						
			   						$('a[name="'+setLogo+'"]').parent().parent().parent().hide('slow');
			   						$('#footer').after('<div id="assets-output" style="display:none;"></div>');
			   						$('#assets-output').html('Logo deleted successfully');
						   			$('#assets-output').dialog({
						   				bgiframe: true,
							   			autoOpen: true,
							   			resizable: false,
							   			draggable: false,
							   			minHeight: 20,
							   			modal: true, 
							   			title: '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span><span style="float:left;padding-top: 2px">Delete</span>',
							   			overlay: {
							   				'background-color': '#000', 
							   				opacity: 0.8 
							   			},
										buttons: { 
											'OK': function(){ $(this).dialog('destroy'); }
										}
									});
			   					}
			   				}
			   			});
					},
					'No': function(){
						$(this).dialog('destroy');
					}
				}
			});
	   		
	   		return false;
	   	});
	   	
	   	/* Version checker --------------------
	    ------------------------------------ */

	   	function getUpdateStatus(elm,isOtherThemelet){
	   		if(!$.cookie('noupdates')){
		   		if($(elm).attr('class') !== undefined){
			   		var classes = $(elm).attr('class').split(' ');
			   		var type = classes[0];
			   		var name = classes[1];
			   		var updateURL;
			   		
			   		if(name !== 'no-themelets'){
			   		
				   		if(!isOtherThemelet){
					   		updateURL = 'https://www.joomlajunkie.com/versions/mhups.php?return=json&type='+type+'&type_name='+name+'&callback=?';
					   	}else{
					   		updateURL = 'https://www.joomlajunkie.com/versions/mhups.php?return=json&type=themelet&type_name='+name+'&callback=?';
					   	}
				   		
					   	$.getJSON(updateURL, function(obj){
				   			if(!isOtherThemelet){ 
				   				var installedVersion = $(elm).next('dd.current').text();
					   			var outputVersion = $(elm+'+ dd.current + dd.latest');
							   	var outputButton = $(elm+'+ dd.current + dd.latest + dd.icon');
					   	
				   				if(obj.version > installedVersion){
				   					outputVersion.html('<a href="'+obj.download+'">'+obj.version+'</a>');
				   					outputButton.html('<span class="update-no" title="There is an update available">Update Available</span>');
				   				} else {
				   					outputVersion.html(obj.version);
				   					outputButton.html('<span class="update-yes" title="You are up to date">Up to date</span>');
				   				}
				   			}else{
				   				var installedVersion = $(elm +'> li.tl-installed').text();
							   	var outputVersion = $(elm+'> li.tl-current');
							   	
							   	if(obj.version > installedVersion){
				   					outputVersion.html('<strong>Current version: </strong><a href="'+obj.download+'">'+obj.version+'</a>');
				   				} else {
				   					outputVersion.html('<strong>Current version: </strong>'+obj.version);
				   				}
				   			}
				   		});
			   		}
		   		}
			}else{
				return false;
			}	   		
	   	};
	   	
	   	getUpdateStatus('dt#us-configurator');
	   	getUpdateStatus('dt#us-morph');
		getUpdateStatus('dt#us-themelet');
	   	getUpdateStatus('.themelet-summary','true');
				
		/* Logo Options -----------------------
	    ------------------------------------ */
	    function logoPreview(elid){
	    	var imageTitle  = $(elid).val(); 
	    	var updatedTitle = imageTitle;
	    	$(elid).after('<span class="logo-preview" title="'+imageTitle+'">&nbsp;<span>Preview</span></span>');
	    	$('.logo-preview').each(function(){
				$(this).attr('title', '');
	    		$(this).qtip({
	       		    content: '<img src="../templates/morph/assets/logos/'+updatedTitle+'" />',
				    position: { corner: { tooltip: 'bottomMiddle', target: 'topLeft' } },
					    style: { tip: { corner:'bottomMiddle' }, name: 'dark', border: { width: 3, radius: 8 }, padding: '0 0 0 0', margin: '0 0 0 0' },
				});
			});
	    	$(elid).change(function(){
	    		$(elid +' option:selected').each(function(){
	    			$('.logo-preview').attr('title', $(this).val());
	    			$('.logo-preview').qtip("destroy");
	    			$('.logo-preview').attr('title', '');
	    			$('.logo-preview').qtip({
					   	content: '<img src="../templates/morph/assets/logos/'+this.value+'" />',
					    position: { corner: { tooltip: 'bottomMiddle', target: 'topMiddle' } },
					    style: { tip: { corner:'bottomMiddle' }, name: 'dark', border: { width: 3, radius: 8 }, padding: '0 0 0 0', margin: '0 0 0 0' },
					});
					return updatedTitle = this.value;
	    		});
			});
	    }
	    
	    logoPreview('#logologo_image');
	    
	    /* Login ------------------------------
	    ------------------------------------ */
	    $('.alf-check').change(function(){
	    	$('#alf-warning').html('<p><span class="error-text"><strong>Selecting this will keep you logged in for an infinite period.</strong><br /><br />'
									+'Please note that, a cookie will be set to keep you logged in until you log out manually or delete your '
									+'cookies.</span></p>');
			
			$('#alf-warning').dialog({
	   			width: 500, 
	   			autoOpen: true, 
	   			bgiframe: true, 
	   			resizable: false,
	   			draggable: false,
	   			minHeight: 20,
	   			modal: true, 
	   			title: '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span><span style="float:left;">Warning</span>',
	   			overlay: {
	   				backgroundColor: '#000', 
	   				opacity: 0.5 
	   			},
				buttons: {
					'OK': function(){
						$(this).dialog('destroy');
					},
					'Uncheck': function(){
						$(this).dialog('destroy');
						$('.alf-check').attr('checked', false);
					}
				}
			});
		});
			
	    function loginUser(){
	    	var username = $('input[name="am-username"]').val();
	    	var password = $('input[name="am-password"]').val();
	    	var setcookie = $('input[name="am-keep-login"]').attr('checked')
	    	
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
										$('#alf-output').dialog({
								   			autoOpen: true, 
								   			bgiframe: true, 
								   			resizable: false,
								   			draggable: false,
								   			minHeight: 20,
								   			modal: true, 
								   			title: '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span><span style="float:left;padding-top: 2px">Login Error</span>',
								   			overlay: {
								   				backgroundColor: '#000', 
								   				opacity: 0.5 
								   			},
											buttons: {
												'OK': function(){
													$(this).dialog('destroy');
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
				$('#alf-warning').dialog({
		   			autoOpen: true, 
		   			bgiframe: true, 
		   			resizable: false,
		   			draggable: false,
		   			minHeight: 20,
		   			modal: true, 
		   			title: '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span><span style="float:left;padding-top: 2px">Error</span>',
		   			overlay: {
		   				backgroundColor: '#000', 
		   				opacity: 0.5 
		   			},
					buttons: {
						'OK': function(){
							$(this).dialog('destroy');
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
		
			$('#content-box').after('<div id="logout-message" style="display:none;">You are about to logout. Please ensure you have saved your changes.<br /></br />'
									+'<strong>Please remember: You will need to be connected to the internet to login again.</strong></div>');
			$('#logout-message').dialog({
	   			autoOpen: true, 
	   			bgiframe: true, 
	   			resizable: false,
	   			draggable: false,
	   			minHeight: 20,
	   			modal: true, 
	   			title: '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span><span style="float:left;padding-top: 2px">Logout</span>',
	   			overlay: {
	   				backgroundColor: '#000', 
	   				opacity: 0.5 
	   			},
				buttons: {
					'Log Out': function(){
						$.cookie('am_logged_in', null, { path: '/', expires: -1 });
						$.cookie('am_logged_in_user', null, { path: '/', expires: -1 });
						$.cookie('member_id', null, { path: '/', expires: -1 });
						$.cookie('member_data', null, { path: '/', expires: -1 });
						window.location.reload(true);
					},
					'Remain Logged In': function(){
						$(this).dialog('destroy');
					}
				}	
			});
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
							$('#upload-message').dialog({
					   			bgiframe: true, 
					   			resizable: false,
					   			draggable: false,
					   			minHeight: 20,
					   			modal: true,
					   			title: '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span><span style="float:left;padding-top: 2px">Error</span>',
			   					overlay: {
			   						backgroundColor: '#000000', 
			   						opacity: 0.8 
			   					},
								buttons: {
									'OK': function(){
										$(this).dialog('destroy');
									}
								}
							});
							$('#upload-message').html(data.error);
							$('#upload-message').dialog('show');
						}
					}else{
						$('#upload-message').dialog({
				   			bgiframe: true, 
				   			resizable: false,
				   			draggable: false,
				   			minHeight: 20,
				   			modal: true,
				   			title: '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span><span style="float:left;padding-top: 2px">Success</span>',
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
										var setThemelet = data.themelet;
										var themeletOption = $('#generalthemelet option:last').after('<option selected="selected" value="'+setThemelet+'">'+setThemelet+'</option>');
	   									submitbutton('applytemplate');
								   		$(this).dialog('destroy');
									},
									'Do Nothing': function(){
										$(this).dialog('destroy');
									}
								}
							);
							$('#upload-message').dialog('show');
						}
						
						if(uploadType == 'logo'){
							$('#upload-message').html(data.success);
							$('#upload-message').dialog(
								'option', 'buttons', { 
									'Activate Logo': function(){
										var setLogo = data.logo;
										var logoOption = $('#logologo_image option:last').after('<option selected="selected" value="'+setLogo+'">'+setLogo+'</option>');
	   									submitbutton('applytemplate');
	   									var $tabs = $('#tabs').tabs();
										var logoTabs = $('#site-tabs').tabs();
										$tabs.tabs('select', 0);
										logoTabs.tabs('select', 1);
										$(this).dialog('destroy');
									},
									'Goto Logo Settings': function(){
										var $tabs = $('#tabs').tabs();
										var logoTabs = $('#site-tabs').tabs();
										$tabs.tabs('select', 0);
										logoTabs.tabs('select', 1); 
  									  	$(this).dialog('destroy');
									}
								}
							);
							$('#upload-message').dialog('moveToTop').dialog('show');
						}
						if(uploadType == 'background'){
							$('#upload-message').html(data.success);
							$('#upload-message').dialog(
								'option', 'buttons', { 
									'Activate Background': function(){
										var setBg = data.background;
										var logoBg = $('#backgroundsbg_image option:last').after('<option selected="selected" value="'+setBg+'">'+setBg+'</option>');
	   									submitbutton('applytemplate');
	   									var $tabs = $('#tabs').tabs();
										var bgTabs = $('#site-tabs').tabs();
										$tabs.tabs('select', 1);
										bgTabs.tabs('select', 1);
										$(this).dialog('destroy');
									},
									'Goto Background Settings': function(){
										var $tabs = $('#tabs').tabs();
										var bgTabs = $('#site-tabs').tabs();
										$tabs.tabs('select', 1);
										bgTabs.tabs('select', 1); 
  									  	$(this).dialog('destroy');
									}
								}
							);
							$('#upload-message').dialog('moveToTop').dialog('show');
						}
						if(uploadType == 'favicon'){
							if(typeof(data.overwrite) == 'undefined'){
								$('#upload-message').html(data.success);
								$('#upload-message').dialog(
									'option', 'buttons', { 
										'OK': function(){
											$(this).dialog('destroy');
										}
									}
								);
								$('#upload-message').dialog('moveToTop').dialog('show');
							}else{
								$('#upload-message').html(data.overwrite);
								$('#upload-message').dialog('option', 'title', '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span><span style="float:left;padding-top: 2px">Overwrite Warning</span>');
								$('#upload-message').dialog(
									'option', 'buttons', { 
										'Yes': function(){
											$(this).dialog('destroy');
										},
										'No': function(){
											$(this).dialog('destroy');
										}
									}
								);
								$('#upload-message').dialog('moveToTop').dialog('show');
							}
						}
					}
					
				},
				error: function (data, status, e){
					console.log(e);
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
		
		
		/* Conditionals --------------------
		--------------------------------- */	
		
		function LogoOptions(){
			switcher($('#logologo_type > option:selected').val());
			
			$('#logologo_type').change(function(){
				var logoType = $(this).val();
				switcher(logoType);
			});
			

			$('#logo-options li #logodisplay_slogan1').click(function(){
				$('#logo-options li #logoslogan_text').parent().css('display', 'block');
				$('#logo-options li #logoslogan_textcolor').parent().css('display', 'block');
				$('#logo-options li #logoslogan_fontsize').parent().css('display', 'block');
				$('#logo-options li #logoslogan_fontfamily').parent().css('display', 'block');
			});
			$('#logo-options li #logodisplay_slogan0').click(function(){
				$('#logo-options li #logoslogan_text').parent().css('display', 'none');
				$('#logo-options li #logoslogan_textcolor').parent().css('display', 'none');
				$('#logo-options li #logoslogan_fontsize').parent().css('display', 'none');
				$('#logo-options li #logoslogan_fontfamily').parent().css('display', 'none');
			});
			$('#logo-options li #logodisplay_ie_logo1').click(function(){
				$('#logo-options li #logologo_image_ie').parent().css('display', 'block');
			});
			$('#logo-options li #logodisplay_ie_logo0').click(function(){
				$('#logo-options li #logologo_image_ie').parent().css('display', 'none');
			});
			
			function switcher(v){
				switch(v){
					case '0':
					$('#logo-options li').css('display', 'none');
					$('#logo-options li.heading').css('display', 'block');
					$('#logologo_type').parent().css('display', 'block');
					$('#logo-options li #logologo_image').parent().css('display', 'block');
					$('#logo-options li #logodisplay_ie_logo0').parent().css('display', 'block');
					$('#logo-options li #logologo_alttext').parent().css('display', 'block');
					$('#logo-options li #logologo_linktitle').parent().css('display', 'block');
					$('#logo-options li #logodisplay_slogan0').parent().css('display', 'block');
					break;
					case '1':
					$('#logo-options li').css('display', 'none');
					$('#logo-options li.heading').css('display', 'block');
					$('#logologo_type').parent().css('display', 'block');
					$('#logo-options li #logologo_textcolor').parent().css('display', 'block');
					$('#logo-options li #logologo_fontsize').parent().css('display', 'block');
					$('#logo-options li #logologo_fontfamily').parent().css('display', 'block');
					$('#logo-options li #logodisplay_slogan0').parent().css('display', 'block');
					break;
					case '2':
					$('#logo-options li').css('display', 'none');
					$('#logo-options li.heading').css('display', 'block');
					$('#logologo_type').parent().css('display', 'block');
					$('#logo-options li #logologo_image').parent().css('display', 'block');
					$('#logo-options li #logodisplay_ie_logo0').parent().css('display', 'block');
					$('#logo-options li #logologo_linktitle').parent().css('display', 'block');
					$('#logo-options li #logodisplay_slogan0').parent().css('display', 'block');
					break;
					case '3':
					$('#logo-options li').css('display', 'none');
					$('#logo-options li.heading:first').css('display', 'block');
					$('#logologo_type').parent().css('display', 'block');
					break;
				}
				
				if($('#logo-options li #logodisplay_slogan0').attr('checked') == 'checked'){
					$('#logo-options li #logoslogan_text').parent().css('display', 'none');
					$('#logo-options li #logoslogan_textcolor').parent().css('display', 'none');
					$('#logo-options li #logoslogan_fontsize').parent().css('display', 'none');
					$('#logo-options li #logoslogan_fontfamily').parent().css('display', 'none');
				}
				if($('#logo-options li #logodisplay_slogan1').attr('checked')){
					$('#logo-options li #logoslogan_text').parent().css('display', 'block');
					$('#logo-options li #logoslogan_textcolor').parent().css('display', 'block');
					$('#logo-options li #logoslogan_fontsize').parent().css('display', 'block');
					$('#logo-options li #logoslogan_fontfamily').parent().css('display', 'block');
				}
				
				if($('#logo-options li #logodisplay_ie_logo1').attr('checked')){
					$('#logo-options li #logologo_image_ie').parent().css('display', 'block');
				}
				if($('#logo-options li #logodisplay_ie_logo0').attr('checked')){
					$('#logo-options li #logologo_image_ie').parent().css('display', 'none');
				}
					
			}	
		}
		$(function(){ LogoOptions(); });
		
		function blockSettingsOptions(elid, hideid){
		
			$(hideid+'_gridsplit').parent().css('display', 'none');
			$(hideid+'_equalize1').parent().css('display', 'none');
			
			$(elid).change(function(){
				var option = $(this).val();
				switcher(option);
			});
			
			switcher($(elid+' > option:selected').val());
			
			function switcher(v){
				switch(v){
					case 'custom2':
						$(hideid+'_gridsplit').parent().css('display', 'block');
						$(hideid+'_equalize1').parent().css('display', 'block');
					break;
					case 'custom3':
						$(hideid+'_gridsplit').parent().css('display', 'block');
						$(hideid+'_equalize1').parent().css('display', 'block');
					break;
					default:
						$(hideid+'_gridsplit').parent().css('display', 'none');
						$(hideid+'_equalize1').parent().css('display', 'none');
				}
			}
		}
		$(function(){ 
			blockSettingsOptions('#toolbartoolbar_chrome','#toolbartoolbar');
			blockSettingsOptions('#masterheadmasthead_chrome','#masterheadmasthead');
			blockSettingsOptions('#subheadsubhead_chrome','#subheadsubhead');
			blockSettingsOptions('#topnavtopnav_chrome','#topnavtopnav');
			blockSettingsOptions('#shelvestopshelf_chrome','#shelvestopshelf');
			blockSettingsOptions('#shelvesbottomshelf_chrome','#shelvesbottomshelf');
			blockSettingsOptions('#inlineshelvesuser1_chrome','#inlineshelvesuser1');
			blockSettingsOptions('#inlineshelvesuser2_chrome','#inlineshelvesuser2');
			blockSettingsOptions('#insetsinset1_chrome','#insetsinset1');
			blockSettingsOptions('#insetsinset2_chrome','#insetsinset2');
			blockSettingsOptions('#insetsinset3_chrome','#insetsinset3');
			blockSettingsOptions('#insetsinset4_chrome','#insetsinset4');
			blockSettingsOptions('#footerfooter_chrome','#footerfooter');
		});
		
		function sliderOptionsOn(elid, hideid){
			if($(elid).attr('checked')){
				$(hideid).parent().css('display', 'block');
			}
			$(elid).click(function(){
				$(hideid).parent().css('display', 'block');
			});
		}
		function sliderOptionsOff(elid, hideid){
			if($(elid).attr('checked')){
				$(hideid).parent().css('display', 'none');
			}
			$(elid).click(function(){
				$(hideid).parent().css('display', 'none');
			});
		}
		
		$(function(){
			sliderOptionsOn('#toolbartoolbar_slider1','#toolbartoolbar_slider_text');
			sliderOptionsOff('#toolbartoolbar_slider0','#toolbartoolbar_slider_text');
			sliderOptionsOn('#shelvesbottomshelf_slider1','#shelvesbottomshelf_slider_text');
			sliderOptionsOff('#shelvesbottomshelf_slider0','#shelvesbottomshelf_slider_text');
			sliderOptionsOn('#shelvestopshelf_slider1','#shelvestopshelf_slider_text');
			sliderOptionsOff('#shelvestopshelf_slider0','#shelvestopshelf_slider_text');
		});
		
		// Keyboard Shortcuts
		$(window).keydown(function(e){
			if($.cookie('am_logged_in') && !$.cookie('noshortkey')){
				var keycode = (e.keyCode || e.which);
				var os = $.os.name;
				
				function save(){
					$('<div id="alf-image"><div><img src="../administrator/components/com_configurator/images/loader3.gif" height="16" width="16" border="0" align="center" alt="Loading" /><span>Saving Settings...</span></div></div>').appendTo('body');
					hideScroll();
					$('#alf-image').css({
						'display': 'block',
						'z-index': '9998',
						position: 'absolute',
				        top: 0,
				        left: 0,
				        width: arrPageSizes[0],
						height: arrPageSizes[1],
					});
					setTimeout(function(){ submitbutton('applytemplate'); }, 1000);
					e.preventDefault();
					return false;
				}
				
				function fullscreen(){
					e.preventDefault();
					$('#minwidth-body').toggleClass("full-mode");
					$('#fullscreen').toggleClass("normal-mode");
					if($('#screenmode').text() == 'Fullscreen Mode'){ 
						$('#screenmode').text('Normal Mode'); 
						$.cookie('fullscreen', 'true', { path: '/', expires: 30 });
					}else{ 
						$('#screenmode').text('Fullscreen Mode'); 
						$.cookie('fullscreen', 'false', { path: '/', expires: 30 });
					}
					e.preventDefault();
					return false;
				}
				
				function preview(){
					var thisurl = $('.preview a').attr('href');
					window.open(thisurl);
					e.preventDefault();
					return false;
				}
				
				function info(){
					$('#getting-started').dialog('open');
					e.preventDefault();
					return false;
				}
				
				function bugreport(){
					$('#report-bug').dialog('open');
					e.preventDefault();
					return false;
				}
				
				function prefs(){
					$('#preferences').dialog('open'); 
					e.preventDefault();
					return false;
				}
				
				if(os == 'mac'){
					if(keycode == 224 || keycode == 91 || keycode == 17){ return false; } // disable keycode return on CMD key
					if(keycode == 83 && e.metaKey && !e.ctrlKey){ return save(); }
					if(keycode == 70 && e.metaKey && !e.ctrlKey){ return fullscreen(); }
					if(keycode == 86 && e.metaKey && !e.ctrlKey){ return preview(); }
					if(keycode == 73 && e.metaKey && !e.ctrlKey){ return info(); }
					if(keycode == 69 && e.metaKey && !e.ctrlKey){ return bugreport(); }
					if(keycode == 80 && e.metaKey && !e.ctrlKey){ return prefs(); }
				}else{
					if(keycode == 17){ return false; } // disable keycode return on CTRL key
					if(keycode == 83 && (e.ctrlKey || e.metaKey)){ return save(); }
					if(keycode == 70 && (e.ctrlKey || e.metaKey)){ 
						if($.browser.name == 'safari'){
							e.preventDefault();
							return fullscreen();
						}
						if($.browser.name == 'opera'){
							e.preventDefault();
							return false;
						}
						return fullscreen(); 
					}
					if(keycode == 86 && (e.ctrlKey || e.metaKey)){ return preview(); }
					if(keycode == 73 && (e.ctrlKey || e.metaKey)){ return info(); }
					if(keycode == 69 && (e.ctrlKey || e.metaKey)){ return bugreport(); }
					if(keycode == 80 && (e.ctrlKey || e.metaKey)){ return prefs(); }
				}
				
				
			}		
		});

		/**
		/ Third Party Function
		* getPageSize() by quirksmode.com
		* @return Array Return an array with page width, height and window width, height
		*/
		function ___getPageSize() {
			var xScroll, yScroll;
			if (window.innerHeight && window.scrollMaxY) {	
				xScroll = window.innerWidth + window.scrollMaxX;
				yScroll = window.innerHeight + window.scrollMaxY;
			} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
				xScroll = document.body.scrollWidth;
				yScroll = document.body.scrollHeight;
			} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
				xScroll = document.body.offsetWidth;
				yScroll = document.body.offsetHeight;
			}
			var windowWidth, windowHeight;
			if (self.innerHeight) {	// all except Explorer
				if(document.documentElement.clientWidth){
					windowWidth = document.documentElement.clientWidth; 
				} else {
					windowWidth = self.innerWidth;
				}
				windowHeight = self.innerHeight;
			} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
				windowWidth = document.documentElement.clientWidth;
				windowHeight = document.documentElement.clientHeight;
			} else if (document.body) { // other Explorers
				windowWidth = document.body.clientWidth;
				windowHeight = document.body.clientHeight;
			}	
			// for small pages with total height less then height of the viewport
			if(yScroll < windowHeight){
				pageHeight = windowHeight;
			} else { 
				pageHeight = yScroll;
			}
			// for small pages with total width less then width of the viewport
			if(xScroll < windowWidth){	
				pageWidth = xScroll;		
			} else {
				pageWidth = windowWidth;
			}
			arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight);
			return arrayPageSize;
		};
		
	});
})(jQuery);