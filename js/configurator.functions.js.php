<?php 
header('content-type: text/javascript; charset: UTF-8');
?>
$.noConflict();
(function($) {
	$(document).ready(function(){
	
		/* Generic ----------------------------
	    ------------------------------------ */
		$("#submenu li:last").addClass("last");
		$('#welcome-box').corners('10px top');
		$('#wb-header').corners('10px top');
		$('#wb-footer').corners('10px bottom');
		
	    /* Inputs and checkboxes --------------
	    ------------------------------------ */
	    $("input.input-installer").filestyle({ 
     		image: "components/com_configurator/images/select-btn.png",
     		imageheight : 27,
     		imagewidth : 81,
     		width : 217
 		});
 		
 		/* Welcome Box ------------------------
	    ------------------------------------ */
	   	$('.wbh-hide-show').click(function(){
	   		$('#wb-content').slideToggle(hideShowContent('#wb-content', $(this)));
	   		return false;
	   	});
	   	
	   	var cookie_name = 'welcome_hide';
	   	var options = { path: '/', expires: 10 };

	   	function hideShowContent(elm,link){
	   		if(!$.cookie(cookie_name)){
	   			$.cookie(cookie_name, 'true', options);
	   			link.text('show');
	   		}else{
	   			$.cookie(cookie_name, null, options);
	   			link.text('hide');
	   		}
	   	}
	   	
	   	if(!$.cookie(cookie_name)){			
			$('.wbh-hide-show').text('hide');			
			$('#wb-content').show();
		}else{
			$('.wbh-hide-show').text('show');			
			$('#wb-content').hide();
		}
	    
	    $('.wbh-close').click(function(){
	    	$('#welcome-box').hide('slow');
	    	$.cookie('configurator_welcome', 'true', '/');
	    	return false;
	    });

 		
 		/* Backup Message ---------------------
 		------------------------------------ */
 		$('input[name="themeletbackup"]').click(function(){
 			alert('This will be available in the second beta phase. Please backup your folder manually');
 			$(this).attr('checked', false);
 		})
	   
	   	/* Tabs -------------------------------
	    ------------------------------------ */
    	$("#tabs").tabs({cookie: {expires: 7, path: '/'}});
    	$("#tabs").corners("10px");
    	$(".to-heading").corners("5px");
    	$("#tabs .ui-tabs-nav-item").corners("5px top");
    	$("#tabs .ui-tabs-panel").corners("5px bottom");
    	
    	$("#installer-tabs").tabs({cookie: {expires: 7, path: '/'}});
    	$("#installer-tabs").corners("10px");
    	$("#installer-tabs .ui-ins-tabs-nav-item").corners("5px top-left");
    	$("#installer-tabs .ui-ins-tabs-panel").corners("5px right");

    	/* Accordion --------------------------
	    ------------------------------------ */
    	var menu = $("#accordion"); 
    	var index = $.cookie("accordion");
        var active;
        if (index !== undefined) {
                active = menu.find("h3:eq(" + index + ")");
        } 
    	menu.accordion({
			collapsible: true,
			autoHeight: false,
			active: active,
			change: function(event, ui) {
            	var index = $(this).find("h3").index ( ui.newHeader[0] );
                $.cookie("accordion", index);
            } 	
		});
		
		/* Colour Picker ----------------------
	    ------------------------------------ */
		function loadColourPicker(elid) {	
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
    			//$(this).ColorPickerSetColor(this.value);  	
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
	    .appendTo(document.body) // Append to the document body
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
	    
	    $('.tt-inline').each(function(){
	    	var thetitle = $(this).attr("title").split('::'); 
	   		var qtTitle = thetitle[1];
	   		
	   		$(this).qtip({
   				content: qtTitle ,
			   	show: 'mouseover',
			   	hide: 'mouseout',
			   	style: {
			   		name: 'cream',
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
						$("body").css('overflow', 'hidden');
						$('#qtip-blanket').fadeIn(this.options.show.effect.length);
					},
					beforeHide: function(){
						$("body").css('overflow', 'auto');
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
						$("body").css('overflow', 'hidden');
						$('#qtip-blanket').fadeIn(this.options.show.effect.length);
					},
					beforeHide: function(){
						$("body").css('overflow', 'auto');
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
			
			return false;
	   	});
	   	
	   	$('.ttim').each(function(){
	    	var thetitle = $(this).attr("title");
	   		
	   		$(this).qtip({
   				content: thetitle ,
			   	show: 'mouseover',
			   	hide: 'mouseout',
			   	style: {
			   		name: 'cream',
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
	   	
	   	$('.sd-label-themelet').each(function(){
	   		
	   		var title = $(this).attr('title');
	   		$(this).attr('title', ''); 
	   		
	   		var content = '<img src="';
     		content += title;
      		content += '" alt="Loading thumbnail..." height="144" width="176" />';
	   		
	   		$(this).qtip({
	   		     content: content,
			     position: {
			        corner: {
			           tooltip: 'leftMiddle',
			           target: 'rightMiddle'
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
         				max: '193'
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
			   		
			   		var installedVersion = $(elm).children('td.installed-version').text();
				   	var outputVersion = $(elm).children('td.current-version');
				   	var outputButton = $(elm).children('td.status');
			   			   		
			   		$.getJSON(updateURL, function(obj){
			   			
			   			
			   			
			   			if(!isOtherThemelet){ 
			   				if(obj.version > installedVersion){
			   					outputVersion.html('<a href="'+obj.download+'">'+obj.version+'</a>');
			   					outputButton.html('<span class="update-yes">Update Available</span>');
			   				} else {
			   					outputVersion.html(obj.version);
			   					outputButton.html('<span class="update-no">Up to date</span>');
			   				}
			   			}			
			   		});
		   		}
	   		}
	   		
	   	};
	   	
	   	getUpdateStatus('tr#us-configurator');
	   	getUpdateStatus('tr#us-morph');
		getUpdateStatus('tr#us-themelet');
	   	getUpdateStatus('tr.other-themelet','true');

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
	    
	});
})(jQuery);