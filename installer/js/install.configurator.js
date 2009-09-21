		var thisPage = location.href.substring((location.href.lastIndexOf("/"))+1);
		var base;
		if(thisPage != 'install.configurator.php'){ base = './components/com_configurator'; }else{ base = '.'; }
		
		var arrPageSizes = ___getPageSize();
		
		$('.install-template').click(function(){
			templateInstall();
			return false;
		});
		
		upgrade();
		
		function assetsCreate(callback,step){
			
			ptOverlay('Processing...')
			
			$.get(
				'../administrator/index.php?option=com_configurator&task=assets_create&format=raw', '',
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
			if(typeof $('#backup_template').val() != 'undefined'){
				if($('#backup_template').attr('checked')){
					var backupval = 'true';
				}else{
					var backupval = 'false';
				}
			}else{
				backupval = 'nomorph';
			}
			
			if($('#publish_template').attr('checked')){
					var publish = 'true';
				}else{
					var publish = 'false';
				}
			
			
			if($('#template-file').val() != ''){
				ptOverlay('Processing...');				
				$.ajaxFileUpload({
					url: '../administrator/index.php?option=com_configurator&task=install_template&format=raw&backup='+backupval+'&publish='+publish,
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
	                        	if(typeof(data.backuploc) != 'undefined'){ backupmsg = '<p><strong>Your morph files were backed up to: </strong><small>'+data.backuploc+'</small></p>'; } else { backupmsg = ''; }
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
					url: '../administrator/index.php?option=com_configurator&task=install_themelet&format=raw&act_themelet='+actval,
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
				   						loadstep3(sample);
				   						checkAll();
				   						showScroll();
				   						helpstep3();
				   					},
									buttons: {
										'OK': function(){
											$(this).dialog('close');
										}
									}
								});
								
								if(data.backuploc !== ''){ var backupmsg = '<p><strong>Your themelet files were backed up to: </strong><small>'+data.backuploc+'.gz</small></p>'; } else { var backupmsg = ''; }
								$('#dialog').html('<div class="dialog-msg">'+data.msg+backupmsg+'</div>');
								$('#dialog').dialog('open');
	                        }
	                    }
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
		
		function sampleInstall(){
			var checkVal = [];
			var dbVal = '';
			var gzipVal = '';
			
			$('#install-sample ul li ul li input').each(function(){
				if($(this).is(':checked')){
					checkVal.push($(this).val());
				}
			});
			if($('#install-sample #database-options').is(':checked')){ dbVal = 'backup'; }else{ dbVal = 'destroy'; }
			if($('#install-sample #gzip-options').is(':checked')){ gzipVal = 'gzip'; }else{ gzipVal = 'nogzip'; }
			
			if(checkVal.length == 0 && dbVal == 'destroy' && gzipVal == 'nogzip'){
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
   						showScroll();
   					},
					buttons: {
						'OK': function(){
							$(this).dialog('close');
						}
					}
				});
				$('#dialog').html('<div class="dialog-msg">No options selected: Please select an option or skip this step.</div>');
				$('#dialog').dialog('open');
				return false;
			}
			
			ptOverlay('Processing...');
			
			$.post(
				'../administrator/index.php?option=com_configurator&task=install_sample&format=raw',
				{
					'sample_data[]': checkVal,
					db: dbVal,
					gzip: gzipVal
				},
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
							if(data.db == 'backedup'){ var dbstore = '<p><strong>Your database was backed up to: </strong></p><p><small>'+data.dbstore+'</small></p>'; }else{ var dbstore = '' }
						
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
			   						loadcompleted(completed);
			   						
			   						showScroll();
			   					},
								buttons: {
									'OK': function(){
										$(this).dialog('close');
									}
								}
							});
							$('#dialog').html('<div class="dialog-msg">'+data.success+dbstore+'</div>');
							$('#dialog').dialog('open');
						}
					}
				}, 'json');
		} 

		function loadstep1(callback){ $('#installer').load(base+'/installer/step1.php', callback); }
		function loadstep2(callback){ $('#installer').load(base+'/installer/step2.php', callback); }
		function loadstep3(callback){ $('#installer').load(''+base+'/installer/step3.php', callback); }
		function loadcompleted(callback){ $('#installer').load(''+base+'/installer/complete.php', callback); }
		function gotomanage() { window.location = '../administration/index.php?option=com_configurator&task=manage'; }
		
		function helpstep1(){
			$('#help-dialog').load(base+'/installer/help/step1.php');
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
			$('#help-dialog').load(base+'/installer/help/step2.php');
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
		function helpstep3(){
			$('#help-dialog').load(base+'/installer/help/step3.php');
			$('.help-step3').click(function(){
				$('#help-dialog').dialog({
					autoOpen: true,
					bgiframe: true, 
		   			resizable: false,
		   			draggable: false,
		   			minHeight: 20,
		   			modal: true,
		   			width: 500,
		   			title: 'Step 3 Help',
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
			$('.skip-step2').click(function(){ loadstep3(sample); return false; });
			$('.back-step1').click(function(){ loadstep1(template); return false; });
			$('.refresh-step2').click(function(){ loadstep2(themelet); return false; });
			$('.install-themelet').click(function(){
				themeletInstall();
				return false;
			});
			helpstep2();
		}
		
		function sample(){
			$('.skip-step3').click(function(){ loadcompleted(completed); return false; });
			$('.back-step2').click(function(){ loadstep2(themelet); return false; });
			$('.install-sample').click(function(){
				sampleInstall();
				return false;
			});
			checkAll();
			helpstep3();
		}
		
		function completed(){
			$('.back-step3').click(function(){ loadstep3(sample); return false; });
			$('.skip-completed').click(function(){ gotomanage(); return false; });
		}
		
		$('.skip-step1').click(function(){ loadstep2(themelet); return false; });
		$('.skip-step2').click(function(){ loadstep3(sample); return false; });
		$('.skip-step3').click(function(){ loadcompleted(completed); return false; });
		$('.skip-completed').click(function(){ gotomanage(); return false; });
		
		$('.back-step1').click(function(){ loadstep1(template); return false; });
		$('.back-step2').click(function(){ loadstep2(themelet); return false; });
		$('.back-step3').click(function(){ loadstep3(sample); return false; });
		
		function checkAll(){
		
			var DBoption = '<label><input type="checkbox" name="database-options" id="database-options" checked="checked" value="db" />'+
					'&nbsp;Backup your entire database (recommended)</label>';
			
			$('.db').empty();
			
			function selected() {
				$('#database-options').each(function(){
					if($(this).attr('checked')){
						$(this).parent().parent().addClass('selected');
					}
					$(this).click(function(){
						if($(this).attr('checked')){
							$(this).parent().parent().addClass('selected');
						}else{
							$(this).parent().parent().removeClass('selected');
						}
					});
				});
			}
			
			$('#install-sample ul li ul li input').click(function(){
				
				if($(this).attr('checked')){
					$(this).parent().parent().addClass('selected');
				}else{
					$(this).parent().parent().removeClass('selected');
					$('#all-options').parent().parent().removeClass('selected');
					$('#all-options').attr('checked', false);
					if($('#install-sample ul li ul input:checked').size() < 1){
						$('.db').empty();
					}
				}
				if($('#install-sample ul li ul input:checked').size() == '3'){
					$('#all-options').parent().parent().addClass('selected');
					$('#all-options').attr('checked', true);
				}
				if($('#install-sample ul li ul input:checked').size() >= '1'){
					if($('#install-sample ul li ul input:checked').size() < 2 && $('#database-options').length == 0 ){
						$('.db').html(DBoption);
					}
					selected();
				}
			});
					
			$('#all-options').click(function(){
				if($(this).attr('checked')){
					$(this).parent().parent().addClass('selected');
					$('#install-sample ul li ul li input').each(function(){
						$(this).attr('checked', true);
						$(this).parent().parent().addClass('selected');
					});
					$('.db').html(DBoption);
					selected();
				}else{
					$(this).parent().parent().removeClass('selected');
					$('#install-sample ul li ul li input').each(function(){
						$(this).attr('checked', false);
						$(this).parent().parent().removeClass('selected');
					});
					$('.db').empty();
				}
			});
					
			$('#database-options, #gzip-options').each(function(){
				if($(this).attr('checked')){
					$(this).parent().parent().addClass('selected');
				}
				$(this).click(function(){
					if($(this).attr('checked')){
						$(this).parent().parent().addClass('selected');
					}else{
						$(this).parent().parent().removeClass('selected');
					}
				});
			});
		}
		checkAll();
		
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