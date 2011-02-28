/**
 * Keyboard Specific JS Functions
 * @author: Byron Rode
 */
$(window).keydown(function(e){
	if(!$.cookie('noshortkey')){
		var keycode = (e.keyCode || e.which);
		var os = $.os.name;
		
		function save(){
			ptOverlay('Saving Settings...');
			if($.cookie('change_themelet')){
				$.ajax({
					url: '?option=com_configurator&view=configuration&themelet='+$.cookie('ct_themelet_name')+'&format=raw',
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
					url: '?option=com_configurator&view=configuration&themelet='+$.cookie('ct_themelet_name')+'&format=raw',
					data: {
						themelet: $.cookie('ct_themelet_name'),
						action: 'themelet_check_existing',
						_token: $('input[name=_token]').val()
					},
					type: 'POST',
					dataType: 'json',
					success: function(data, ts){
						if(data.exists == 'true'){
							close_ptOverlay();
							$('<div class="dialog-msg">It seems that you have used this themelet before.<br />Would you like to restore your <strong>previous settings</strong>, or would you like to use the <strong>themelet defaults</strong></div>').dialog({
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
									$('#processing').css({
										'display': 'block',
										'z-index': '9998',
										position: 'absolute',
								        top: 0,
								        left: 0,
								        width: arrPageSizes[0],
										height: arrPageSizes[1]
									});
									setTimeout(function(){ submitbutton('apply'); }, 1000);
					   			},
								buttons: { 
									'Themelet Defaults': function(){
										$(this).dialog('close');
						   			},
						   			'Previous Settings': function(){
						   				$.ajax({
											url: '?option=com_configurator&themelet='+$.cookie('ct_themelet_name')+'&format=raw',
											data: {
												themelet: $.cookie('ct_themelet_name'),
												action: 'themelet_activate_existing',
												_token: $('input[name=_token]').val()
											},
											type: 'POST',
											success: function(data){
												return true;
											}
										});
						   				$(this).dialog('close');
						   			}
						   		}
						   	});
						}else{
							$('#processing').css({
								'display': 'block',
								'z-index': '9998',
								position: 'absolute',
						        top: 0,
						        left: 0,
						        width: arrPageSizes[0],
								height: arrPageSizes[1]
							});
							setTimeout(function(){ submitbutton('apply'); }, 1000);
						}
					}
				});
			}else{
				setTimeout(function(){ submitbutton('apply'); }, 1000);
			}
			e.preventDefault();
			return false;
		}

		function fullscreen(){
			$('#minwidth-body').toggleClass("fullscreen");
			$('#fullscreen').toggleClass("normal-mode");
			if($('#fullscreen a').text() == 'Fullscreen'){ 
				$('#fullscreen a').text('Normal'); 
				$.cookie('fullscreen', 'true', { path: '/', expires: 30 });
			}else{ 
				$('#fullscreen a').text('Fullscreen'); 
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

		function previewTpl(){
			var thisurl = $('.preview a').attr('href');
			window.open(thisurl+'?tp=1');
			e.preventDefault();
			return false;
		}

		function info(){
			if(!$.cookie('welcome_screen')){
				$('#getting-started').load('../administrator/components/com_configurator/tooltips/gettingstarted.php', function(){
			    	return welcomeScreen();
			    });
			    $.cookie('welcome_screen', 'hide');
			}else{
				$('#getting-started').dialog("destroy");
				//$.cookie('welcome_screen', null);
			}
			e.preventDefault();
			return false;
		}

		function bugreport(){
			if(!$.cookie('bug')){
				$('#report-bug').dialog('open');
				$.cookie('bug', 'open');
			}else{
				$('#report-bug').dialog("close");
				$.cookie('bug', null);
			}
			e.preventDefault();
			return false;
		}

		function prefs(){
			if(!$.cookie('prefs')){
			   	preferencesScreen();
			    $.cookie('prefs', 'open');
			}else{
				$('#preferences-screen').dialog("close");
				$.cookie('prefs', null);
			}
			e.preventDefault();
			return false;
		}

		function keyboard(){
			if(!$.cookie('keys')){
				$('#keyboard-screen').load('../administrator/components/com_configurator/includes/layout/keyboard.php', function(){
			    	keyboardScreen();
			    });
			    $.cookie('keys', 'open');
			}else{
				$.cookie('keys', null);
				$('#keyboard-screen').dialog("close");
			}
			e.preventDefault();
			return false;
		}

		function toggletop(){
			toggleShelf();
			e.preventDefault();
			return false;
		}

		function tooltip(tid){
			toolGuides(tid);
			e.preventDefault();
			return false;
		}
		if($.browser.name !== 'opera'){
			if(os == 'mac'){
				if(keycode == 224 || keycode == 91 || keycode == 17){ e.preventDefault(); return false; } // disable keycode return on CMD key
				if(keycode == 83 && e.metaKey && !e.ctrlKey){ return save(); }
				if(keycode == 70 && e.metaKey && !e.ctrlKey){ return fullscreen(); }
				if(keycode == 79 && e.metaKey && !e.ctrlKey){ return preview(); }
				if(keycode == 191 && e.metaKey && !e.ctrlKey){ return previewTpl(); }
				if(keycode == 69 && e.metaKey && !e.ctrlKey){ return bugreport(); }
				if(keycode == 80 && e.metaKey && !e.ctrlKey){ return prefs(); }
				if(keycode == 48 && e.metaKey && !e.ctrlKey){ return toggletop(); }
				if(keycode == 49 && e.metaKey && !e.ctrlKey){ return info(); }
				if(keycode == 50 && e.metaKey && !e.ctrlKey){ return tooltip(2); }
				if(keycode == 51 && e.metaKey && !e.ctrlKey){ return tooltip(3); }
				if(keycode == 52 && e.metaKey && !e.ctrlKey){ return tooltip(4); }
				if(keycode == 53 && e.metaKey && !e.ctrlKey){ return tooltip(5); }
				if(keycode == 54 && e.metaKey && !e.ctrlKey){ return tooltip(6); }
				if(keycode == 55 && e.metaKey && !e.ctrlKey){ return tooltip(7); }
				if(keycode == 56 && e.metaKey && !e.ctrlKey){ return tooltip(8); }
				if(keycode == 75 && e.metaKey && !e.ctrlKey){ return keyboard(); }
			
			}else{
				if(keycode == 17){ return false; } // disable keycode return on CTRL key
				if(keycode == 83 && (e.ctrlKey || e.metaKey)){ e.preventDefault(); return save(); }
				if(keycode == 70 && (e.ctrlKey || e.metaKey)){ 
					if($.browser.name == 'safari'){
						e.preventDefault();
						return fullscreen();
					}
					return fullscreen(); 
				}
				if(keycode == 79 && (e.ctrlKey || e.metaKey)){ return preview(); }
				if(keycode == 191 && (e.ctrlKey || e.metaKey)){ return previewTpl(); }
				if(keycode == 69 && (e.ctrlKey || e.metaKey)){ return bugreport(); }
				if(keycode == 80 && (e.ctrlKey || e.metaKey)){ return prefs(); }
				if(keycode == 48 && (e.ctrlKey || e.metaKey)){ return toggletop(); }
				if(keycode == 49 && (e.ctrlKey || e.metaKey)){ return info(); }
				if(keycode == 50 && (e.ctrlKey || e.metaKey)){ return tooltip(2); }
				if(keycode == 51 && (e.ctrlKey || e.metaKey)){ return tooltip(3); }
				if(keycode == 52 && (e.ctrlKey || e.metaKey)){ return tooltip(4); }
				if(keycode == 53 && (e.ctrlKey || e.metaKey)){ return tooltip(5); }
				if(keycode == 54 && (e.ctrlKey || e.metaKey)){ return tooltip(6); }
				if(keycode == 55 && (e.ctrlKey || e.metaKey)){ return tooltip(7); }
				if(keycode == 56 && (e.ctrlKey || e.metaKey)){ return tooltip(8); }
				if(keycode == 75 && (e.ctrlKey || e.metaKey)){ return keyboard(); }
			}
		}		
	}		
});