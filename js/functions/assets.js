$('#assets-tabs').bind('tabsload', function(event, ui) {

	var options = { path: '/', expires: 30 }
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
			
	   		check_admin_session(ptOverlay('Processing...'));
		   	
	   		$('#generalthemelet option[value="'+setThemelet+'"]').attr('selected', true);
	   		$('#templateform input[name="task"]').remove();
	   		$('#templateform').submit(function(){
	   			$(this).ajaxSubmit({
	   				type: 'POST',
	   				url: '../administrator/index.php?format=raw',
	   				data: {
	   					option: 'com_configurator',
	   					task: 'applytemplate',
	   					isajax: 'true'
	   				},
		   			success: function(data, textStatus){
		   		
		   				$('#element-box').before('<dl id="system-message"><dt class="message">Message</dt><dd class="message message fade"><ul><li>Successfully saved your settings</li></ul></dd></dl>');	
						$('#system-message').delay(3000, function(){ $('#system-message').fadeOut().remove(); });
						
						$('.tl-active ul.buttons li.btn-activate a, .tl-active ul.buttons li.btn-delete a').fadeTo('fast', 1).attr('href', '#active').css('cursor', 'pointer').click(function(){ return false; });
						$('li.tl-inactive ul li.btn-activate a[name="'+setThemelet+'"], li.tl-inactive ul li.btn-delete a[name="'+setThemelet+'"]').fadeTo('fast', 0.5).attr('href', '#inactive').css('cursor', 'default').click(function(){ return false; });
						
						$('#current-themelet li.ct-name').html('<span>Name: </span>'+$('li.tl-inactive ul li.btn-activate a[name="'+setThemelet+'"]').attr('title').replace('Activate ', ''));
						$('#current-themelet li.ct-version').html('<span>Version: </span>'+$('ul.'+setThemelet+' li.tl-installed').text().replace('Installed version: ',''));
						$('#current-themelet li.ct-thumb').html('<span>&nbsp;</span><img src="../morph_assets/themelets/'+setThemelet+'/themelet_thumb.png" width="108" height="72" align="middle" alt="'+$('#current-themelet li.ct-name').text()+'" />');
						
						$('#customize-list ul li.tl-active ul li.btn-activate a, #customize-list ul li.tl-active ul li.btn-delete a,').fadeTo('slow', 1);
		   				$('#customize-list ul li.tl-active').switchClass('tl-inactive', 'tl-active', 'slow');
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
									close_ptOverlay();
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
											// change to assets tab
											check_admin_session(ptOverlay('Reloading Management Interface...'));
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
													url: '../administrator/index.php?option=com_configurator&task=themelet_activate_existing&themelet_name='+setThemelet+'&format=raw',
													method: 'post',
													success: function(data){
														$this.dialog('close');
														return true;
													}
												});
								   			}
								   		}
								   	});
								}else{
									// change to assets tab
									check_admin_session(ptOverlay('Processing...'));
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
					var subTabs = $('#customize-tabs').tabs();
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
	   					isajax: 'true'
	   				},
	   				success: function(data, textStatus){
		   			
		   				$('#element-box').before('<dl id="system-message"><dt class="message">Message</dt><dd class="message message fade"><ul><li>Successfully saved your settings</li></ul></dd></dl>');
	
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
					var subTabs = $('#customize-tabs').tabs();
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
	   					isajax: 'true'
	   				},
		   			success: function(data, textStatus){
		   				$('#element-box').before('<dl id="system-message"><dt class="message">Message</dt><dd class="message message fade"><ul><li>Successfully saved your settings</li></ul></dd></dl>');	
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
   		$.ajax({
			type: 'GET',
			url: '../administrator/index.php?option=com_configurator&format=raw&task=deleteAsset&deltype=themelet&asset='+setThemelet,
			success: function(data, textStatus){
				if(textStatus == 'success'){
					$('a[name="'+setThemelet+'"]').parent().parent().parent().parent().fadeOut('slow', function(){
						$(this).remove();
						if($("#themelets-list ul.assets-list li.themelet-item").length > 0){
							$("ul.assets-list").each(function(){
								$(this).children().removeClass('alt');
								$(this).children(':odd').addClass('alt');
							});
						}else{
							$('#themelets-list').empty().append('<div class="no-assets">There are currently no themelets in your assets folder. <a href="#" class="upload-themelet">Upload a themelet?</a></div>');
							$(".upload-themelet").click(function(){
								var maintabs = $("#tabs").tabs();
								var subtabs = $("#tools-tabs").tabs();
								maintabs.tabs("select",4);
								subtabs.tabs("select",0);
								$('#install-type label.label-selected').removeClass('label-selected');
								$("#upload_themelet").attr("checked",true).parent().addClass('label-selected');
								return false;
							});
						}
					});
				}
			}
		});
	return false;
   	});

   	// backgrounds
   	$('li.background-item ul li.btn-delete a').click(function(){
   		var setBackground = $(this).attr('name');
		$.ajax({
			type: 'GET',
			url: '../administrator/index.php?option=com_configurator&format=raw&task=deleteAsset&deltype=background&asset='+setBackground,
			success: function(data, textStatus){
				if(textStatus == 'success'){
					$('a[name="'+setBackground+'"]').parent().parent().parent().parent().fadeOut('slow', function(){
						$(this).remove();
						if($("#backgrounds-list ul.assets-list li.background-item").length > 0){
							$("ul.assets-list").each(function(){
								$(this).children().removeClass('alt');
								$(this).children(':odd').addClass('alt');
							});
						}else{
							$('#backgrounds-list').empty().append('<div class="no-assets">There are currently no backgrounds in your assets folder. <a href="#" class="upload-bg">Upload a background?</a></div>');
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
					});	   						
				}
			}
		});	
   		return false;
   	});

   	// logos
   	$('li.logo-item ul li.btn-delete a').click(function(){
   		var setLogo = $(this).attr('name');
		$.ajax({
			type: 'GET',
			url: '../administrator/index.php?option=com_configurator&format=raw&task=deleteAsset&deltype=logo&asset='+setLogo,
			success: function(data, textStatus){
				if(textStatus == 'success'){			   						
					$('a[name="'+setLogo+'"]').parent().parent().parent().parent().fadeOut('slow', function(){
						$(this).remove();
						if($("#logos-list ul.assets-list li.logo-item").length > 0){
							$("ul.assets-list").each(function(){
								$(this).children().removeClass('alt');
								$(this).children(':odd').addClass('alt');
							});
						}else{
							$('#logos-list').empty().append('<div class="no-assets">There are currently no logos in your assets folder. <a href="#" class="upload-logo">Upload a logo?</a></div>');
							$(".upload-logo").click(function(){
								var maintabs = $("#tabs").tabs();
								var subtabs = $("#tools-tabs").tabs();
								maintabs.tabs("select",4);
								subtabs.tabs("select",0);
								$('#install-type label.label-selected').removeClass('label-selected');
								$("#upload_logo").attr("checked",true).parent().addClass('label-selected');
								return false;
							});
						}
					});
				}
			}
		});
   		return false;
   	});

	// iphones
	$('li.iphone-item ul li.btn-delete a').click(function(){
		var setiphone = $(this).attr('name');
		$.ajax({
			type: 'GET',
			url: '../administrator/index.php?option=com_configurator&format=raw&task=deleteAsset&deltype=iphone&asset='+setiphone,
			success: function(data, textStatus){
				if(textStatus == 'success'){			   						
					$('a[name="'+setiphone+'"]').parent().parent().parent().parent().fadeOut('slow', function(){
						$(this).remove();
						if($("#iphone-list ul.assets-list li.iphone-item").length > 0){
							$("ul.assets-list").each(function(){
								$(this).children().removeClass('alt');
								$(this).children(':odd').addClass('alt');
							});
						}else{
							$('#iphone-list').empty().append('<div class="no-assets">There is currently no iPhone media in your assets folder. <a href="#" class="upload-iphone">Upload iPhone media?</a></div>');
							$(".upload-iphone").click(function(){
							var maintabs = $("#tabs").tabs();
							var subtabs = $("#tools-tabs").tabs();
							maintabs.tabs("select",4);
							subtabs.tabs("select",0);
							$('#install-type label.label-selected').removeClass('label-selected');
							$("#upload_iphone").attr("checked",true).parent().addClass('label-selected');
							return false;
							});
						}
					});
				}
			}
		});
		return false;
	});
	
	$("ul.assets-list, #backup-list tbody, #recycle-list tbody").each(function(){
		$(this).children(':odd').addClass('alt');
	});
	
	$(".upload-themelet").click(function(){
	var maintabs = $("#tabs").tabs();
	var subtabs = $("#tools-tabs").tabs();
	maintabs.tabs("select",4);
	subtabs.tabs("select",0);
	$('#install-type label.label-selected').removeClass('label-selected');
	$("#upload_themelet").attr("checked",true).parent().addClass('label-selected');
	return false;
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

	$(".upload-bg").click(function(){
	var maintabs = $("#tabs").tabs();
	var subtabs = $("#tools-tabs").tabs();
	maintabs.tabs("select",4);
	subtabs.tabs("select",0);
	$('#install-type label.label-selected').removeClass('label-selected');
	$("#upload_background").attr("checked",true).parent().addClass('label-selected');
	return false;
	});
	
	$(".upload-iphone").click(function(){
	var maintabs = $("#tabs").tabs();
	var subtabs = $("#tools-tabs").tabs();
	maintabs.tabs("select",4);
	subtabs.tabs("select",0);
	$('#install-type label.label-selected').removeClass('label-selected');
	$("#upload_iphone").attr("checked",true).parent().addClass('label-selected');
	return false;
	});
	
	// backup manager
	$('#backup-list a').click(function(){
		var $this = $(this);
		var act;
		var action = $(this).attr('action');
		var filename = $(this).attr('name');
		var btype = $(this).attr('bu_type');
		var burl = '../administrator/index.php?option=com_configurator&format=raw&task=handle_backup&action='+action+'&filename='+filename+'&type='+btype;

		$('<div class="dialog-msg"></div>').dialog({
			bgiframe: true,
			autoOpen: false,
			minHeight: 20,
			stack: false,
			modal: true, 
			overlay: {
				'background-color': '#000', 
				opacity: 0.8 
			},
			buttons: { 
				'OK': function(){
					close_ptOverlay();
					$('.dialog-msg').dialog('destroy').remove();
	   			}
	   		}
	   	});

		if(action != 'download'){
			if(action == 'restore'){
				check_admin_session(ptOverlay('Processing...'));
				$('.dialog-msg').html('<p><strong>You are about to restore a database backup!</strong></p>Would you like to download a temporary database backup before restoring?');
				$('.dialog-msg').dialog('option', 'title', 'Restore Warning');
				$('.dialog-msg').dialog('option', 'buttons', {
					'Yes': function(){
						window.location.href = '../administrator/index.php?option=com_configurator&task=create_db_backup&format=raw&type=full-database&download=true&url';
						$(this).dialog('close');
						check_admin_session(ptOverlay('Processing...'));
						$.ajax({
							type: 'POST',
							url: burl,
							success: function(data){
								close_ptOverlay();
								hideScroll();
								$('.dialog-msg').html(data);
								$('.dialog-msg').dialog('option', 'buttons', {
									'OK': function(){
										close_ptOverlay();
										$('.dialog-msg').dialog('destroy').remove();
										ptOverlay('Reloading');
										window.location.reload(true);
									}
								});
								$('.dialog-msg').dialog('option', 'title', 'Restore');
								$('.dialog-msg').dialog('open');
							}
						});
					},
					'No':function(){
						$(this).dialog('close');
						ptOverlay('Processing...')
						$.ajax({
							type: 'POST',
							url: burl,
							success: function(data){
								close_ptOverlay();
								hideScroll();
								$('.dialog-msg').html(data);
								$('.dialog-msg').dialog('option', 'buttons', {
									'OK': function(){
										close_ptOverlay();
										$('.dialog-msg').dialog('destroy').remove();
										ptOverlay('Reloading');
										window.location.reload(true);
									}
								});
								$('.dialog-msg').dialog('option', 'title', 'Restore');
								$('.dialog-msg').dialog('open');
							}
						});
					}
				});
				close_ptOverlay();
				$('.dialog-msg').dialog('open');
			}else{
				$.ajax({
					type: 'POST',
					url: burl,
					success: function(data, status){
						$('.dialog-msg').html(data);
						if(action == 'delete'){
							$this.parent().parent().fadeOut('slow', function(){
								$(this).remove();
								if($("#backup-list tbody tr").length > 1){
									$("#backup-list tbody tr").each(function(){
										$(this).removeClass('alt');
									});
								}else{
									$('#backup-list').empty().remove();
									$('#backup-manager').append('<div class="no-assets">There are currently no database backups.</div>');
									return false;
								}
							});
						}
					}
				});
			}
		}else{
			window.location.href = burl;
		}
		return false;
	});
	
});