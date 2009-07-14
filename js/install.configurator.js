jQuery.noConflict();
(function($){
	$(document).ready(function(){
		var arrPageSizes = ___getPageSize();
		$('#sd-body').corners('10px');
		// template
		$('.install-template').click(function(){
			if($('#backup_template').attr('checked')){
				var backupval = 'true';
			}else{
				var backupval = 'false';
			}
			if($('#template-file').val() != ''){
				$('<div id="saving"><div><img src="../../../administrator/components/com_configurator/images/loader3.gif" height="16" width="16" border="0" align="center" alt="Loading" /><span>Installing template...</span></div></div>').appendTo('body');
				hideScroll();
				$('#saving').css({
					'display': 'block',
					'z-index': '9998',
					position: 'absolute',
			        top: 0,
			        left: 0,
			        width: arrPageSizes[0],
					height: arrPageSizes[1],
				});
				
				$.ajaxFileUpload({
					url: '../../../administrator/index.php?option=com_configurator&task=install_template&format=raw&backup='+backupval,
					fileElementId:'template-file',
					dataType: 'json',
					success: function (data, status)
	                {
	                    if(typeof(data.error) != 'undefined')
	                    {
	                        if(data.error != '')
	                        {
	                            hideScroll();
	                            $('#saving').css('display', 'none');
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
									close: function(){
				   						$(this).dialog('destroy');
				   						showScroll();
				   					},
									buttons: {
										'OK': function(){
											$(this).dialog('close');
										}
									}
								});
								$('#upload-message').html(data.error);
								$('#upload-message').dialog('show');
	                        }else{
	                            hideScroll();
	                            $('#saving').css('display', 'none');
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
				   					close: function(){
				   						$(this).dialog('destroy');
				   						$('#sample-data').load('../../../administrator/components/com_configurator/includes/installer/step3.php');
				   						$.cookie('install', 'step3');
				   						$('#sd-body').corners('10px');
				   						showScroll();
				   					},
									buttons: {
										'OK': function(){
											$(this).dialog('close');
										}
									}
								});
								$('#upload-message').html(data.msg);
								$('#upload-message').dialog('show');
	                        }
	                    }
	                }
				});
			}else{
				hideScroll();
				$('<div>All fields are required</div>').dialog({
	            	bgiframe: true,
					autoOpen: true,
					stack: true,
					title: 'Error',
					buttons: {
						'Ok': function(){
							$(this).dialog('close');
						}
					},
					close: function(){
						$(this).dialog('destroy');
						showScroll();
					},
					modal: true,
					overlay: {
						backgroundColor: 'black',
						opacity: 0.8
					}
				});
			}
			return false;
		});
		
		$('.install-themelet').click(function(){
			if($('#activate_themelet').attr('checked')){
				var actval = 'true';
			}else{
				var actval = 'false';
			}	
			if($('#insfile').val() != ''){
				$('<div id="saving"><div><img src="../../../administrator/components/com_configurator/images/loader3.gif" height="16" width="16" border="0" align="center" alt="Loading" /><span>Installing themelet...</span></div></div>').appendTo('body');
				hideScroll();
				$('#saving').css({
					'display': 'block',
					'z-index': '9998',
					position: 'absolute',
			        top: 0,
			        left: 0,
			        width: arrPageSizes[0],
					height: arrPageSizes[1],
				});
				
				$.ajaxFileUpload({
					url: '../../../administrator/index.php?option=com_configurator&task=install_themelet&format=raw&act_themelet='+actval,
					fileElementId:'insfile',
					dataType: 'json',
					success: function (data, status)
	                {
	                    if(typeof(data.error) != 'undefined')
	                    {
	                        if(data.error != '')
	                        {
	                            hideScroll();
	                            $('#saving').css('display', 'none');
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
									close: function(){
				   						$(this).dialog('destroy');
				   						showScroll();
				   					},
									buttons: {
										'OK': function(){
											$(this).dialog('close');
										}
									}
								});
								$('#upload-message').html(data.error);
								$('#upload-message').dialog('show');
	                        }else{
	                            hideScroll();
	                            $('#saving').css('display', 'none');
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
				   					close: function(){
				   						$(this).dialog('destroy');
				   						$('#sample-data').load('../../../administrator/components/com_configurator/includes/installer/step4.php');
				   						$.cookie('install', 'step4');
				   						$('#sd-body').corners('10px');
				   						showScroll();
				   					},
									buttons: {
										'OK': function(){
											$(this).dialog('close');
										}
									}
								});
								$('#upload-message').html(data.msg);
								$('#upload-message').dialog('show');
	                        }
	                    }
	                },
	                error: function(c,d,e){
	                	$('#saving').css('display', 'none');
	                	console.log(e);
	                }
				});
			}else{
				hideScroll();
				$('<div>All fields are required</div>').dialog({
	            	bgiframe: true,
					autoOpen: true,
					stack: true,
					title: 'Error',
					buttons: {
						'Ok': function(){
							$(this).dialog('close');
						}
					},
					close: function(){
						$(this).dialog('destroy');
						showScroll();
					},
					modal: true,
					overlay: {
						backgroundColor: 'black',
						opacity: 0.8
					}
				});
			}
			return false;
		});
		
		var skipper = $('.btn-skip').click(function(){
			if($(this).hasClass('skip-step2')){
				$('#sample-data').load('../../../administrator/components/com_configurator/includes/installer/step3.php', skipper);
				$.cookie('install', 'step3');
				skipper;
			}
			if($(this).hasClass('skip-step3')){
				$('#sample-data').load('../../../administrator/components/com_configurator/includes/installer/step4.php', skipper);
				$.cookie('install', 'step4');
				skipper;
			}
			if($(this).hasClass('skip-completed')){
				$('#sample-data').load('../../../administrator/components/com_configurator/includes/installer/completed.php', skipper);
				$.cookie('install', 'completed');
				skipper;
			}
			return false;
		});
		
		function hideScroll(){
			$(document).bind('scroll', function(){return false;});
			$('html').css({'overflow-y': 'hidden', paddingRight: '15px'});
			return true;
		}
		
		function showScroll(){
			$(document).bind('scroll', function(){return false;});
			$('html').css({'overflow-y': 'scroll', paddingRight: '0'});
			return true;
		}
		
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
	
	})
})(jQuery);