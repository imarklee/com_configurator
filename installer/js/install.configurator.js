		var thisPage = location.href.substring((location.href.lastIndexOf("/"))+1);
		var base;
		if(thisPage != 'install.configurator.php'){ base = './components/com_configurator'; }else{ base = '.'; }
		
		var arrPageSizes = ___getPageSize();
		
		$('.install-template').click(function(){
			templateInstall();
			return false;
		});
		
		upgrade();
		
		var assetsCreate = function(callback,step){
			
			ptOverlay('Processing...')
			
			$.get(
				'?option=com_configurator&view=configuration&task=assets_create&format=raw', '',
				function(data, status){
					if(typeof data.error != 'undefined'){
						if(data.error != ''){
							close_ptOverlay();
							hideScroll();
							$('#dialog').dialog({
					   			bgiframe: true, 
					   			resizable: false,
					   			draggable: false,
					   			minHeight: 20,
					   			width: 500,
					   			modal: true,
					   			title: 'Error',
			   					overlay: {
			   						backgroundColor: '#000000', 
			   						opacity: 0.9 
			   					},
								close: function(){
			   						$(this).dialog('destroy');
			   						$.cookie('assets_check_again', 'true');
			   						callback(step);
			   						showScroll();
			   					},
								buttons: {
									'OK': function(){
										$(this).dialog('close');
									}
								}
							});
							$('#dialog').html('<div class="dialog-msg">'+data.error+'</div>');
							$('#dialog').dialog('open');
						}else{
							close_ptOverlay();
							hideScroll();
							$('#dialog').dialog({
					   			bgiframe: true, 
					   			resizable: false,
					   			draggable: false,
					   			minHeight: 20,
					   			modal: true,
					   			width: 500,
					   			title: 'Success',
			   					overlay: {
			   						backgroundColor: '#000000', 
			   						opacity: 0.9 
			   					},
			   					close: function(){
			   						$(this).dialog('destroy');
			   						$('#error-assets').remove();
			   						$.cookie('assets_check_again', null);
			   						$.cookie('asset_exists', 'true')
			   						callback(step);
			   						showScroll();
			   					},
								buttons: {
									'OK': function(){
										$(this).dialog('close');
									}
								}
							});
							$('#dialog').html('<div class="dialog-msg">'+data.success+'</div>');
							$('#dialog').dialog('open');
						}
					}
				}, 'json');
		}

		function templateInstall(){
			
			if($('#publish_template').attr('checked')){
					var publish = 'true';
				}else{
					var publish = 'false';
				}
			
			
			if($('#template-file').val() != ''){
				ptOverlay('Processing...');				
				$.ajaxFileUpload({
					url: '?option=com_configurator&view=configuration&format=raw&backup=true&publish='+publish,
					fileElementId:'template-file',
					dataType: 'json',
					success: function (data, status)
	                {
	                    if(typeof(data.error) != 'undefined')
	                    {
	                        if(data.error != '')
	                        {
	                            close_ptOverlay();
	                            hideScroll();
								$('#dialog').dialog({
						   			bgiframe: true, 
						   			resizable: false,
						   			draggable: false,
						   			minHeight: 20,
						   			modal: true,
						   			title: 'Error',
				   					overlay: {
				   						backgroundColor: '#000000', 
				   						opacity: 0.9 
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
								$('#dialog').html('<div class="dialog-msg">'+data.error+'</div>');
								$('#dialog').dialog('open');
	                        }else{
	                        	if(typeof(data.backuploc) != 'undefined'){ backupmsg = '<p><strong>Your morph template files were backed up to: </strong><small>'+data.backuploc+'</small></p>'; } else { backupmsg = ''; }
	                            close_ptOverlay();
	                            hideScroll();
								$('#dialog').dialog({
						   			bgiframe: true, 
						   			resizable: false,
						   			draggable: false,
						   			minHeight: 20,
						   			modal: true,
						   			title: 'Success',
				   					overlay: {
				   						backgroundColor: '#000000', 
				   						opacity: 0.9 
				   					},
				   					close: function(){
				   						$(this).dialog('destroy');
				   						loadstep2(themelet);
				   						helpstep2();
				   						showScroll();
				   					},
									buttons: {
										'OK': function(){
											$(this).dialog('close');
										}
									}
								});
								$('#dialog').html('<div class="dialog-msg">'+data.msg+backupmsg+'</div>');
								$('#dialog').dialog('open');
	                        }
	                    }
	                //Callback that adds the token and action
	                }, function(form){
	                	form.append($('<input />', {name: 'action', value: 'install_template'}))
	                		.append($('<input />', {name: '_token', value: $('input[name=_token]').val()}));
	                }
				});
			}else{
				hideScroll();
				$('<div class="dialog-msg">All fields are required.</div>').dialog({
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
						opacity: 0.9
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
				ptOverlay('Processing...');
				
				$.ajaxFileUpload({
					url: '?option=com_configurator&view=configuration&format=raw&act_themelet='+actval,
					fileElementId:'insfile',
					dataType: 'json',
					success: function (data, status)
	                {
	                    if(typeof(data.error) != 'undefined')
	                    {
	                        if(data.error != '')
	                        {
	                            close_ptOverlay();
	                            hideScroll();
								$('#dialog').dialog({
						   			bgiframe: true, 
						   			resizable: false,
						   			draggable: false,
						   			minHeight: 20,
						   			modal: true,
						   			title: 'Error',
				   					overlay: {
				   						backgroundColor: '#000000', 
				   						opacity: 0.9 
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
								$('#dialog').html('<div class="dialog-msg">'+data.error+'</div>');
								$('#dialog').dialog('open');
	                        }else{
	                            close_ptOverlay();
	                            hideScroll();
								$('#dialog').dialog({
						   			bgiframe: true, 
						   			resizable: false,
						   			draggable: false,
						   			minHeight: 20,
						   			modal: true,
						   			title: 'Success',
				   					overlay: {
				   						backgroundColor: '#000000', 
				   						opacity: 0.9 
				   					},
				   					close: function(){
				   						$(this).dialog('destroy');
										showScroll();
				   						loadcompleted(completed);
				   					},
									buttons: {
										'OK': function(){
											$(this).dialog('close');
										}
									}
								});
								
								if(data.backuploc !== ''){ 
									var backupmsg = '<p><strong>Your themelet files were backed up to: </strong><small>'+data.backuploc+'.gz</small></p>';
									//@TODO figure out what this is doing
									//$.cookie('upgrade_themelet', true);
								} else { 
									var backupmsg = ''; 
								}
								$('#dialog').html('<div class="dialog-msg">'+data.msg+backupmsg+'</div>');
								$('#dialog').dialog('open');
	                        }
	                    }
	                //Callback that adds the token and action
	                }, function(form){
	                	form.append($('<input />', {name: 'action', value: 'install_template'}))
	                		.append($('<input />', {name: '_token', value: $('input[name=_token]').val()}));
	                }
				});
			}else{
				hideScroll();
				$('<div class="dialog-msg">All fields are required.</div>').dialog({
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
						opacity: 0.9
					}
				});
			}
		}

		function loadstep1(callback){ 
			$('#installer').load('?option=com_configurator&view=install&format=raw&layout=step1', callback);
		}
		function loadstep2(callback){
			$('#installer').load('?option=com_configurator&view=install&format=raw&layout=step2', callback);
		}
		function loadcompleted(callback){
			$('#installer').load('?option=com_configurator&view=install&format=raw&layout=complete', callback);
		}
		function gotomanage() { window.location = '?option=com_configurator&view=configuration'; }
		
		function helpstep1(){
			$('#help-dialog').load('?option=com_configurator&view=help&format=raw&layout=step1');
			$('.help-step1').click(function(){	
				$('#help-dialog').dialog({
					autoOpen: true,
					bgiframe: true, 
		   			resizable: false,
		   			draggable: false,
		   			minHeight: 20,
		   			modal: true,
		   			width: 500,
		   			title: 'Step 1 Help',
   					overlay: {
   						backgroundColor: '#000000', 
   						opacity: 0.9 
   					},
					buttons: {
						'Ok': function(){
							$(this).dialog('close');
						}
					},
   					close: function(){
   						$(this).dialog('destroy');
   					}
				});
				return false;
			});
		}
		helpstep1();
		
		function helpstep2(){ 
			$('#help-dialog').load('?option=com_configurator&view=help&format=raw&layout=step2');
			$('.help-step2').click(function(){
				$('#help-dialog').dialog({
					autoOpen: true,
					bgiframe: true, 
		   			resizable: false,
		   			draggable: false,
		   			minHeight: 20,
		   			modal: true,
		   			width: 500,
		   			title: 'Step 2 Help',
   					overlay: {
   						backgroundColor: '#000000', 
   						opacity: 0.9 
   					},
					buttons: {
						'Ok': function(){
							$(this).dialog('close');
						}
					},
   					close: function(){
   						$(this).dialog('destroy');
   					}
				});
				return false;
			});
		}

		function upgrade(){
			if($('#install-body').hasClass('upgrade')){

				$('li.next a').fadeTo('fast', 0.3).removeClass('launch-cfg').click(function(){ return false; }).css('cursor', 'default');
				
				
				$('input[name="upgrade"]').change(function(){			
					if($(this).val() == 'opt2'){
						$('div.upgrade-sub-options ul').show();
						$('li.next a').addClass('continue-install').removeClass('finish-install').fadeTo('fast', 1).css('cursor', 'pointer');
					}
					
					if($(this).val() == 'opt1'){
						$('div.upgrade-sub-options ul').hide();
						$('li.next a').addClass('finish-install').removeClass('continue-install').fadeTo('fast', 1).css('cursor', 'pointer');
						$('div.upgrade-sub-options input').attr('checked', false);
					}
				});
				
				$('input[name="upgrade_type"]').change(function(){
					if($(this).val() == 'fresh'){
						$.cookie('upgrade-type', 'fresh-install');
					}
					if($(this).val() == 'existing'){
						$.cookie('upgrade-type', 'upgrade');
					}
				});
					
				$('li.next a').click(function(){
					if($(this).hasClass('continue-install')){
						if($('input[name="upgrade_type"]').is(':checked')){
							loadstep1(template);
							return false;					
						}else{
							hideScroll();
							$('<div class="dialog-msg"><p>Please select an upgrade option.</p></div>').dialog({
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
									opacity: 0.9
								}
							});
						}
					}
					if($(this).hasClass('finish-install')){
						loadcompleted(completed);
						return false;
					}
				return false;
				});
				
			}else{
				return false;
			}
		}
		
		function template(){
			$('.skip-step1').click(function(){ loadstep2(themelet); return false; });
			$('.refresh-step1').click(function(){ loadstep1(template); return false; });
			$('.install-template').click(function(){
				templateInstall();
				return false;
			});
			helpstep1();
			upgrade();
			
			if($('#assets_folder_exists').length > 0){
				$.cookie('assets_check_again', null);
				$.cookie('asset_exists', 'true');
			}
			if($.cookie('assets_check_again')){
				hideScroll();
				$('#error-assets').dialog('open');
			}
		}
		
		function themelet(){
			$('.skip-step2').click(function(){ loadcompleted(completed); return false; });
			$('.back-step1').click(function(){ loadstep1(template); return false; });
			$('.refresh-step2').click(function(){ loadstep2(themelet); return false; });
			$('.install-themelet').click(function(){
				themeletInstall();
				return false;
			});
			helpstep2();
		}
		
		function completed(){
			$('.back-step2').click(function(){ loadstep2(themelet); return false; });
			$('.skip-completed').click(function(){ gotomanage(); return false; });
		}
		
		$('.skip-step1').click(function(){ loadstep2(themelet); return false; });
		$('.skip-step2').click(function(){ loadcompleted(completed); return false; });
		$('.skip-completed').click(function(){ gotomanage(); return false; });
		
		$('.back-step1').click(function(){ loadstep1(template); return false; });
		$('.back-step2').click(function(){ loadstep2(themelet); return false; });
		
		$('#error-assets').dialog({
			bgiframe: true,
			autoOpen: false,
			resizable: false,
			draggable: false,
			minHeight: 20,
			modal: true,
			width: 500,
			title: 'Alert!',
			open: function(){
				hideScroll();
			},
			overlay: {
				backgroundColor: '#000000', 
				opacity: 0.9 
			},
			closeOnEscape: false,
			buttons: {
				'Create Assets Folders': function(){
					$('#error-assets').dialog('close');
					showScroll();
					assetsCreate(loadstep1, template);
				},
				'Refresh': function(){
					if(!$.cookie('assets_check')) { $.cookie('assets_check_again', 'true'); }
					$('#error-assets').dialog('close');
					showScroll();
					loadstep1(template);
				}
			}
		});
		if(!$.cookie('assets_check_again') && !$.cookie('asset_exists')){
			$('#error-assets').dialog('open');
		}