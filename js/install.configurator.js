jQuery.noConflict();
(function($){
	$(document).ready(function(){
		var arrPageSizes = ___getPageSize();
		$('#sd-body').corners('10px');
		
		$('.install-template').click(function(){
			templateInstall();
			return false;
		});
		
		$('.install-themelet').click(function(){
			themeletInstall();
			return false;
		});
		
		$('.install-sample').click(function(){
			sampleInstall();
			return false;
		});
		
		function templateInstall(){
			if($('#backup_template').attr('checked')){
				var backupval = 'true';
			}else{
				var backupval = 'false';
			}
			if($('#template-file').val() != ''){
				$('<div id="saving"><div><img src="../administrator/components/com_configurator/images/loader3.gif" height="16" width="16" border="0" align="center" alt="Loading" /><span>Installing template...</span></div></div>').appendTo('body');
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
					url: '../administrator/index.php?option=com_configurator&task=install_template&format=raw&backup='+backupval,
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
						   			title: 'Error',
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
						   			title: 'Success',
				   					overlay: {
				   						backgroundColor: '#000000', 
				   						opacity: 0.8 
				   					},
				   					close: function(){
				   						$(this).dialog('destroy');
				   						loadstep3(themelet);
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
		}
		
		function themeletInstall(){
			if($('#activate_themelet').attr('checked')){
				var actval = 'true';
			}else{
				var actval = 'false';
			}
			if($('#insfile').val() != ''){
				$('<div id="saving"><div><img src="../administrator/components/com_configurator/images/loader3.gif" height="16" width="16" border="0" align="center" alt="Loading" /><span>Installing themelet...</span></div></div>').appendTo('body');
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
					url: '../administrator/index.php?option=com_configurator&task=install_themelet&format=raw&act_themelet='+actval,
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
						   			title: 'Error',
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
						   			title: 'Success',
				   					overlay: {
				   						backgroundColor: '#000000', 
				   						opacity: 0.8 
				   					},
				   					close: function(){
				   						$(this).dialog('destroy');
				   						loadstep4(sample);
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
		}
		
		function sampleInstall(){
			var checkVal = [];
			var dbVal = '';
			$('#install-sample ul li ul li input').each(function(){
				if($(this).is(':checked')){
					checkVal.push($(this).val());
				}
			});
			if($('#install-sample #database-options').is(':checked')){ dbVal = 'backup'; }else{ dbVal = 'destroy'; }
			
			$('<div id="saving"><div><img src="../administrator/components/com_configurator/images/loader3.gif" height="16" width="16" border="0" align="center" alt="Loading" /><span>Installing sample data...</span></div></div>').appendTo('body');
			$('#saving').css({
				'display': 'block',
				'z-index': '9998',
				position: 'absolute',
		        top: 0,
		        left: 0,
		        width: arrPageSizes[0],
				height: arrPageSizes[1],
			});
			
			$.post(
				'../administrator/index.php?option=com_configurator&task=install_sample&format=raw',
				{
					'sample_data[]': checkVal,
					db: dbVal
				},
				function(data, status){
					if(typeof data.error != 'undefined'){
						if(data.error != ''){
							hideScroll();
							$('#saving').css('display', 'none');
							$('#upload-message').dialog({
					   			bgiframe: true, 
					   			resizable: false,
					   			draggable: false,
					   			minHeight: 20,
					   			width: 500,
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
							if(data.db == 'backedup'){ var dbstore = '<p><strong>Your database was backed up to: </strong><small>'+data.dbstore+'</small></p>'; }else{ var dbstore = '' }
						
							hideScroll();
                            $('#saving').css('display', 'none');
							$('#upload-message').dialog({
					   			bgiframe: true, 
					   			resizable: false,
					   			draggable: false,
					   			minHeight: 20,
					   			modal: true,
					   			width: 500,
					   			title: 'Success',
			   					overlay: {
			   						backgroundColor: '#000000', 
			   						opacity: 0.8 
			   					},
			   					close: function(){
			   						$(this).dialog('destroy');
			   						loadcompleted(completed);
			   						showScroll();
			   					},
								buttons: {
									'OK': function(){
										$(this).dialog('close');
									}
								}
							});
							$('#upload-message').html(data.success+dbstore);
							$('#upload-message').dialog('show');
						}
					}
				}, 'json');
		}
		
		function loadstep2(callback){ $('#sample-data').load('../administrator/components/com_configurator/includes/installer/step2.php', callback); }
		function loadstep3(callback){ $('#sample-data').load('../administrator/components/com_configurator/includes/installer/step3.php', callback); }
		function loadstep4(callback){ $('#sample-data').load('../administrator/components/com_configurator/includes/installer/step4.php', callback); }
		function loadcompleted(callback){ $('#sample-data').load('../administrator/components/com_configurator/includes/installer/complete.php', callback); }
		function gotomanage() { window.location = '../administration/index.php?option=com_configurator&task=manage'; }
		
		function template(){
			$('.skip-step2').click(function(){ loadstep3(themelet); return false; });
			$('.install-template').click(function(){
				templateInstall();
				return false;
			});
			$('#sd-body').corners('10px');
			$.cookie('install', null);
		}
		
		function themelet(){
			$('.skip-step3').click(function(){ loadstep4(sample); return false; });
			$('.back-step2').click(function(){ loadstep2(template); return false; });
			$('.install-themelet').click(function(){
				themeletInstall();
				return false;
			});
			$('#sd-body').corners('10px');
			$.cookie('install', 'step3');
		}
		
		function sample(){
			$('.skip-step4').click(function(){ loadcompleted(completed); return false; });
			$('.back-step3').click(function(){ loadstep3(themelet); return false; });
			$('.install-sample').click(function(){
				sampleInstall();
				return false;
			});
			$('#sd-body').corners('10px');
			$.cookie('install', 'step4');
			checkAll();
		}
		
		function completed(){
			$('.skip-completed').click(function(){ gotomanage(); return false; });
			$('#sd-body').corners('10px');
			$.cookie('install', 'completed');
		}
		
		$('.skip-step2').click(function(){ loadstep3(themelet); return false; });
		$('.skip-step3').click(function(){ loadstep4(sample); return false; });
		$('.skip-step4').click(function(){ loadcompleted(completed); return false; });
		$('.skip-completed').click(function(){ gotomanage(); return false; });
		
		$('.back-step2').click(function(){ loadstep2(template); return false; });
		$('.back-step3').click(function(){ loadstep3(themelet); return false; });
		
		function checkAll(){
			$('#all-options').click(function(){
				if($(this).attr('checked')){
					$('#install-sample ul li ul li input').each(function(){$(this).attr('checked', true);});
				}else{
					$('#install-sample ul li ul li input').each(function(){$(this).attr('checked', false);});
				}
			});
		}
		checkAll();
		
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