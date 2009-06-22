<?php 
header('content-type: text/javascript; charset: UTF-8');
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
	
		/* Generic ----------------------------
	    ------------------------------------ */
		$("#submenu li:last").addClass("last");
		$("#tabs .options-panel").wrapInner('<div class="options-inner"></div>');
		$("#tabs ol.forms li:first-child").addClass("first");		
		$("#tabs ol.forms li:last-child").addClass("last");		
		$("#tabs ol.forms li:odd").addClass("alt");		
		$('#conf-login').corners('5px');
		$('#cl-inner').corners('3px');
		$('#login-details').corners('5px');
		
		$("#assets .ui-tabs-nav li:first").addClass('subnav-first');
		$("#subtabs .ui-tabs-nav li:first").addClass('subnav-first');
		$("#browse-tools .ui-tabs-nav li:first").addClass('subnav-first');
		$("#block-settings .ui-tabs-nav li:first").addClass('subnav-first');
	
		$("#assets .ui-tabs-nav").corners("5px");
		$("#subtabs .ui-tabs-nav").corners("5px");
		$("#browse-tools .ui-tabs-nav").corners("5px");
		$("#block-settings .ui-tabs-nav").corners("5px");
		
		$(".buttons li a").corners("5px");
		
		$("#subtabs .ui-tabs-nav li.subnav-first").corners("3px left");
		$("#assets .ui-tabs-nav li.subnav-first").corners("3px left");
		$("#browse-tools .ui-tabs-nav li.subnav-first").corners("3px left");
		$("#block-settings .ui-tabs-nav").corners("5px");
	
		$("#tabs li a").corners("10px top");
		$("#shelf-contents").corners("10px bottom");
		$("#element-box .m").corners("7px");
		$("#shelf").corners("10px");
		$("#shelf.open #utilities").corners("10px top");
		$("#shelf.closed #utilities").corners("10px");
		$("ul.assets-headers").corners("5px top");
		
		$('.tl-active ul.buttons li.btn-activate, .tl-active ul.buttons li.btn-delete').each(function(){
			$(this).fadeTo('fast', 0.2);
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
		});
		$("input, textarea", $("form")).blur(function(){
		    $(this).removeClass("focus");
		    $(this).parents("ol.forms").removeClass("cur");
		});	
			
	    /* Inputs and checkboxes --------------
	    ------------------------------------ */
	    $("input.input-installer").filestyle({ 
     		image: "components/com_configurator/images/select-btn.png",
     		imageheight : 27,
     		imagewidth : 81,
     		width : 217
 		});
 		
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
    	$('#tabs').tabs({ 			cookie: {				name: 'maintabs',				expires: 30,				path: '/',		 	}
		});
		$('#subtabs').tabs({
			fx: { opacity: 'toggle' },
			cookie: {				name: 'subtabs',				expires: 30,				path: '/',		 	} 		});	
		$('#browse-assets').tabs({
			fx: { opacity: 'toggle' },			cookie: {				name: 'assetstabs',				expires: 30,				path: '/',		 	} 		});	
		$('#browse-tools').tabs({
			fx: { opacity: 'toggle' },			cookie: {				name: 'toolstabs',				expires: 30,				path: '/',		 	} 		});	
    	$('#block-settings').tabs({
			fx: { opacity: 'toggle' },			cookie: {				name: 'blockstabs',				expires: 30,				path: '/',		 	} 		});	
		
		/* Colour Picker ----------------------
	    ------------------------------------ */
		function loadColourPicker(elid) {
		
			if($(elid).val() != 'default'){
    			$(elid).css({
    				'background-color': $(elid).val()
    			});
    		}
		
    		$(elid).ColorPicker({
    			onSubmit: function(hsb, hex, rgb) {
    				$(elid).val('#'+hex);
    				$('.colorpicker').hide();
    			},
    			onBeforeShow: function () {
    				if($(this).val() == 'default'){
    					$(this).ColorPickerSetColor('#ffffff');
    				}else{
    					$(this).ColorPickerSetColor(this.value);
    				}
    			},
    			onChange: function(hsb, hex, rgb){
    				$(elid).val('#'+hex);
    			
    				if(hex == 'ffffff'){
    					color = '000000';
    				}else{
    					color = 'ffffff';
    				}
    			
    				$(elid).css({
    					'background-color': '#'+hex,
    					'color': '#'+color
    				});
    			}
    		})
    		.bind('keyup', function(){
    			$(this).ColorPickerSetColor(this.value);  	
    		});
    		    		
    	}
    	
		loadColourPicker('input[id="backgroundthemelet_bgcolor"]');
		loadColourPicker('input[id="colorcolor_h1"]');
     	loadColourPicker('input[id="colorcolor_h2"]');
     	loadColourPicker('input[id="colorcolor_h3"]');
      	loadColourPicker('input[id="colorcolor_h4"]');
     	loadColourPicker('input[id="colorcolor_h5"]');    		
      	loadColourPicker('input[id="colorcolor_links"]');
      	loadColourPicker('input[id="colorcolor_linkshover"]');
     	loadColourPicker('input[id="colorcolor_bodytext"]');
     	
     	
     	//all hover and click logic for buttons
		$(".fg-button:not(.ui-state-disabled)")
		.hover(
			function(){ 
				$(this).addClass("ui-state-hover"); 
			},
			function(){ 
				$(this).removeClass("ui-state-hover"); 
			}
		)
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
			}else{
				$('.closed').switchClass('closed', 'open', 300);
				$.cookie('shelf', null, { path: '/', expires: 30 });
			}
			return false;	
		});
	
		var options = { path: '/', expires: 30 };
	
		$("#themelet-switch a.switch_thumb").toggle(function(){
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
		
		
		$("#backgrounds-switch a.switch_thumb").toggle(function(){
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
		
		$("#logos-switch a.switch_thumb").toggle(function(){
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
			height: 450,
			width: 400,
			modal: true
		});				
		
		$('#report-bug-link').click(function() {
			$('#report-bug').dialog('open');
		})
     	     	
		
		/* Tooltips ----------------------
		------------------------------- */
		$('<div id="qtip-blanket">').css({
			position: 'absolute',
	        top: $(document).scrollTop(),
	        left: 0,
	        height: '100%',
	        width: '100%',
	  		opacity: 0.7,
	       	backgroundColor: 'black',
	        zIndex: 5000
		})
	    .appendTo($('html')) // Append to the document body
	    .hide();
	    
	    /* Live Content for Tooltips ----------
	    ------------------------------------ */
	    function liveContent(pagename){
	    	var docroot = 'http://www.joomlajunkie.com/livedocs_test/gridsplit.html';	    	
	    	liveContent = $.ajax({
				  url: docroot,
				  cache: false,
				  success: function(html){
				    alert(html);
				  }
				});

	    };
	    
	    var welcome = $('body').qtip({
	    	content: {
				title: {
					text: 'Welcome to Configurator',
					button: 'Close'
				},
				url: '../administrator/components/com_configurator/tooltips/gettingstarted.html'
			},
			position: {
				target: $(document.body), // Position it via the document body...
				corner: 'center' // ...at the center of the viewport
			},
			show: {
				when: false,
				solo: true // And hide all other tooltips
			},
			fixed: true,
			hide: {
				when: false
			},
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
					$('#qtip-blanket').fadeIn(this.options.show.effect.length);
				},
				beforeHide: function(){
					$('#qtip-blanket').fadeOut(this.options.hide.effect.length);
				}
			}
	    })
	    
	    if(!$.cookie('welcome_screen')){
	    	welcome.qtip('show');
	    	$.cookie('welcome_screen', 'hide', { path: '/', expires: 366 });
	    }
	    
	    $('.tt-inline').each(function(){
	    	var thetitle = $(this).attr("title").split('::'); 
	   		var qtTitle = thetitle[1];
	   		
	   		$(this).qtip({
   				content: qtTitle ,
			   	show: 'mouseover',
			   	hide: 'mouseout',
			   	style: {
			   		name: 'red',
			   		border: {
			   			width: 5,
			   			radius: 5
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
						$('#qtip-blanket').fadeIn(this.options.show.effect.length);
					},
					beforeHide: function(){
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
	   	
	   	$('li a.modal-link').each(function(){
	   	
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
						$('#qtip-blanket').fadeIn(this.options.show.effect.length);
					},
					beforeHide: function(){
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
	   		
	   		var title = $(this).attr('href');
	   		
	   		var content = '<img src="';
     		content += title;
      		content += '" alt="Loading thumbnail..." height="100" width="200" />';
	   		
	   		$(this).qtip({
	   		     content: content,
			     position: {
			        corner: {
			           tooltip: 'bottomMiddle',
			           target: 'topMiddle'
			        }
			     },
			     style: {
			        tip: true, // Give it a speech bubble tip with automatic corner detection
			        name: 'dark',
			        border: {
         				width: 3,
         				radius: 8
         			},
         			padding: '0 0 0 0',
         			width: {
         				max: '216'
         			}
				}

			});
			
	   	});
	   	
	   	$('.refimages').each(function(){
	   		var title = $(this).text();
	   		var content = '<img src="';
	   		content += $(this).attr('href');
	   		content += '" alt="'+title+'" height="608" width="600" />';
	   		
	   		$(this).qtip({
	   			content: {
	   				title: {
	   					text: title,
	   					button: 'Close'
	   				},
	   				text: content
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
						// Fade in the modal "blanket" using the defined show speed
						$('#qtip-blanket').fadeIn(this.options.show.effect.length);
					},
					beforeHide: function(){
						// Fade out the modal "blanket" using the defined hide speed
						$('#qtip-blanket').fadeOut(this.options.hide.effect.length);
					}
				}
	   		});
	   	});
	   	
	   	/* Activate themelet function ---------
	    ------------------------------------ */
	   	$('a.act-themelet').click(function(){
	   		var setThemelet = $(this).attr('name');
	   		var themeletOption = $('#generalthemelet > option[value='+setThemelet+']');
	   		
	   		themeletOption.attr('selected', true);
	   		submitbutton('applytemplate');
	   		return false;
	   	});
	   	
	   	/* Delete themelet function -----------
	    ------------------------------------ */
	   	$('a.del-themelet').click(function(){
	   		var setThemelet = $(this).attr('name');
	   		var setThemeletName = $(this).attr('title').replace('Delete ', '').replace(' Themelet', '');
	   		
	   		var alertMessage = 'Are you sure you want to delete the "'+setThemeletName+'" themelet?\nThis is irreversible!';
	   		if(confirm(alertMessage)){
	   			$.ajax({
	   				type: 'GET',
	   				url: '../administrator/index.php?option=com_configurator&task=manage&do=delete&themelet='+setThemelet,
	   				success: function(data, textStatus){
	   					if(textStatus == 'success'){
	   						$('tr.'+setThemelet).hide('slow', function(){ alert('Themelet deleted successfully'); });
	   					}
	   				}
	   			});
	   			
	   		}
	   	});
	   	
	   	/* Version checker --------------------
	    ------------------------------------ */
	   	function getUpdateStatus(elm,isOtherThemelet){
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
//			   					outputButton.html('<span class="update-no" title="There is an update available">Update Available</span>');
			   				} else {
			   					outputVersion.html('<strong>Current version: </strong>'+obj.version);
//			   					outputButton.html('<span class="update-yes" title="You are up to date">Up to date</span>');
			   				}
			   			}
			   		});
		   		}
	   		}
	   		
	   	};
	   	
	   	getUpdateStatus('dt#us-configurator');
	   	getUpdateStatus('dt#us-morph');
		getUpdateStatus('dt#us-themelet');
	   	getUpdateStatus('.themelet-summary','true');

	   	/* Save Form Data ---------------------
	    ------------------------------------ */
	    $('#accordion').change(function () {
		   	$.cookie('changes', 'true', '/');
	   	});
	   	
	   	function checkChanges(elid, func){
	   		$("#changes-dialog").dialog({
	   			autoOpen: false, 
	   			bgiframe: true, 
	   			resizable: false, 
	   			height: 140, 
	   			modal: true, 
	   			overlay: {
	   				backgroundColor: '#000', 
	   				opacity: 0.5 
	   			},
				buttons: {
					'Yes': function() {
						submitbutton('applytemplate');
						submitbutton(func);
					},
					'No': function() {
						submitbutton(func);
					}
				}
			});

	   		$(elid).click(function(){
		   		if($.cookie('changes')){
		   			$("#changes-dialog").dialog('open');
		   			$.cookie('changes', null, '/');
		   		}else{
		   			submitbutton(func);
		   		}
		   	});
		};
		
		checkChanges('.button-logo', 'logo_upload');
		checkChanges('.button-background', 'bg_upload');
		checkChanges('.button-favicon', 'upload_favicon');
		checkChanges('.button-themelet', 'upload_themelet');
		
		/* Logo Options -----------------------
	    ------------------------------------ */
	    function logoPreview(elid){
	    	var imageTitle  = $(elid).val(); 
	    	var updatedTitle = imageTitle;
	    	$(elid).after('<span class="logo-preview" title="'+imageTitle+'">&nbsp;</span>');
	    	$('.logo-preview').each(function(){
	    		$(this).attr('title', '');
	    		$(this).qtip({
	       		    content: '<img src="../templates/morph/assets/logos/'+updatedTitle+'" />',
				    position: { corner: { tooltip: 'bottomMiddle', target: 'topMiddle' } },
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
	   			autoOpen: true, 
	   			bgiframe: true, 
	   			resizable: false,
	   			draggable: false,
	   			minHeight: 20,
	   			modal: true, 
	   			title: '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span><span style="float:left;padding-top: 2px">Warning</span>',
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
				$('#cl-inner').fadeTo("fast", 0.1);
	    	
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
										
										if(setcookie == true){ days = 365; }else{ days = null; }
										
										$.cookie('am_logged_in', 'true', { path: '/', expires: days });
										$.cookie('am_logged_in_user', username, { path: '/', expires: days });
										$.cookie('member_id', member_id, { path: '/', expires: days });
										$.cookie('member_data', member_data, { path: '/', expires: days });
									
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
		
	});
})(jQuery);