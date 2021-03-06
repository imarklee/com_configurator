updEl = new Array('dt#us-configurator', 'dt#us-morph', 'dt#us-themelet', 'ul.themelet-summary');
function getUpdates(checknow){
	if(!$.cookie('noupdates') || checknow){
		
		if(window.localStorage) {
			window.localStorage['updates'] = null;
		} else {
			if($.cookie('updates')) $.cookie('updates', null, { expires: 730 } );
		}
		
		updateURL = 'https://www.joomlajunkie.com/versions/versions.php?return=json&callback=?';
		$.ajax({
			method: 'get',
			url: updateURL,
			cache: false,
			dataType: 'json',
			timeout: (2*1000),
			success: function(obj, status){
				var updates = $.toJSON(obj);
				if(window.localStorage) {
					window.localStorage['updates'] = updates;
				} else {
					$.cookie('updates', updates, { expires: 730 } );
				}
				showUpdates(updEl, function(){
					$('#updates-summary dl').fadeTo('fast', 1);
					$('#updates-summary #updates-msg').empty();
				});
			}
		});
	}
	return false;
};

function showUpdates(e, callback){	
	if(window.localStorage) {
		if(!window.localStorage['updates']) return false;
		var json = $.secureEvalJSON(window.localStorage['updates']);
	} else {
		if(!$.cookie('updates')) return false;
		var json = $.secureEvalJSON($.cookie('updates'));
	}

	var x = $(e).length;
	var online = json.updates;
	for(i=0;i<x;i++){
		type = $(e[i]).attr('type');
   		if(type == 'shelf'){
   			name = $(e[i]).attr('name');
   			if(typeof online[name] != 'undefined'){
	   			name_html = $(e[i]).html();
		   		current_version = $(e[i]).next().children().html();
		   		online_version = online[name].version;
		   		online_placeholder = $(e[i]).next().next();
		   		online_titletext = 'The latest available version is '+online_version+'. Click on the help link above for more information.';
		   		online_placeholder.html('<span title="'+online_titletext+'">'+online_version+'</span>');
		   		icon_placeholder = $(e[i]).next().next().next();
		   		if(parseFloat(current_version) < parseFloat(online_version)){
			
		   			icon_placeholder.html('<span class="update-no" title="There is an update available">Update Available</span>');
		   			$(e[i]).html('<a title="Click here to download the latest version of '+online[name].long_name+' now" target="_blank" href="'+online[name].download+'">'+name_html+'</a>');
		   		}else{
		   			icon_placeholder.html('<span class="update-yes" title="You are up to date">Up to date</span>');
		   		}
		   	}
	   	}
	   	if(type == 'assets'){
	   		$(e[i]).each(function(){
	   			name = $(this).attr('name');
	   			if(typeof online[name] != 'undefined'){
			   		name_html = $(this).prev().prev().html();
			   		current_version = $($(this).children().children()[0]).next().html();
			   		online_version = online[name].version;
			   		online_placeholder = $($(this).children().children()[2]).next();
			   		online_placeholder.html(online[name].version);
			   		online_date_placeholder = $($(this).children().children()[4]).next();
			   		online_date_placeholder.html(online[name].updated);
	
			   		if(current_version < online_version){
			   			$(this).prev().prev().children().children().attr('href', online[name].download);
			   			$(this).parent().parent().addClass('update');
			   			$(this).next().next().children('li.btn-update').children().attr('href', online[name].download);
			   		}
			   	}
		   	});
	   	}
	}
	if(typeof callback == 'function') return callback();
	return;		
}
//@TODO commented out for debugging
//if(window.localStorage ? window.localStorage['updates'] : $.cookie('updates')) { showUpdates(updEl); }else{ getUpdates(true); }

// refresh versions on click
$('.updates-refresh-link').click(function(){
	$('#updates-summary dl').fadeTo('fast', 0.1, function(){
		$('#updates-summary').append('<div id="updates-msg">Checking...</div>');
	});
	getUpdates(true);
	return false;
});

$.fn.toggleSettings = function(){
	var $this = this;
	var cookiename, cookiesplit, e;
	
	$this.click(function(){
	
		cookiename = $this.parent().parent().attr('id')+'_'+$this.index(this);
		cookiesplit = cookiename.split('_');
		e = $('#'+cookiesplit[0]+' h3').get(cookiesplit[1]);
			
		if($(e).attr('open_settings') == 'false'){
			$(e).attr('open_settings', 'true');
			$(e).next('ol').slideDown('fast');
			$.cookie(cookiename, 'open');
		}else{
			$(e).attr('open_settings', 'false');
			$(e).next('ol').slideUp('fast');
			$.cookie(cookiename, 'close');
		}
		return false;
	});
	
	return this.each(function(){
			
		cookiename = $this.parent().attr('id')+'_'+$this.index(this);
		cookiesplit = cookiename.split('_');
		e = $('#'+cookiesplit[0]+' h3').get(cookiesplit[1]);
		if(!$.cookie(cookiename)){
			if(cookiesplit[1] == 0){
				$(e).attr('open_settings', 'true');
				$(e).next('ol').show();
			}else{
				$(e).attr('open_settings', 'false');
				$(e).next('ol').hide();
			}
		}
		
		if($.cookie(cookiename) == 'close'){
			$(e).attr('open_settings', 'false');
			$(e).next('ol').hide();
		}
		
		if($.cookie(cookiename) == 'open'){
			$(e).attr('open_settings', 'true');
			$(e).next('ol').show();
		}
	});
}

function showSettings(e, effect){
	if(effect){
		if(effect == 'toggle'){
			$(e+' h3').toggleSettings();
		}	
		if(effect == 'accordion'){
			cookie_name = e.replace('#', '');
			var index = $.cookie("accordion_"+$(e).attr('id'));
			var active;
			if (index !== null) {
				active = $(e).find("h3:eq(" + index + ")");
			}else{
				active = $(e).find("h3:eq(0)");
			}
			$(e).accordion({
			    header: "h3",
			    collapsible: true,
			    active: active,
				autoHeight: false,
			    change: function(event, ui) {
		            var index = $(this).find("h3").index ( ui.newHeader[0] );
		           	$.cookie("accordion_"+$(this).attr('id'), index);
			    }
			});
		}
	}else{
		return;
	}
}
showSettings('#general-options', $.cookie('settings_effect'));
showSettings('#progressive-options', $.cookie('settings_effect'));
showSettings('#performance-options', $.cookie('settings_effect'));
showSettings('#debugging-options', $.cookie('settings_effect'));
showSettings('#components-options', $.cookie('settings_effect'));
showSettings('#menuitems-options', $.cookie('settings_effect'));
showSettings('#mootools-options', $.cookie('settings_effect'));
showSettings('#jomsocial-options', $.cookie('settings_effect'));
showSettings('#enhancements-tab', $.cookie('settings_effect'));
showSettings('#captify-tab', $.cookie('settings_effect'));
showSettings('#lightbox-tab', $.cookie('settings_effect'));
showSettings('#preloader-tab', $.cookie('settings_effect'));
showSettings('#color-options', $.cookie('settings_effect'));
showSettings('#logo-options', $.cookie('settings_effect'));
showSettings('#background-options', $.cookie('settings_effect'));
showSettings('#menu-options', $.cookie('settings_effect'));
showSettings('#iphone-options', $.cookie('settings_effect'));
showSettings('#captify-options', $.cookie('settings_effect'));
showSettings('#toolbar-options', $.cookie('settings_effect'));
showSettings('#mainhead-options', $.cookie('settings_effect'));
showSettings('#subhead-options', $.cookie('settings_effect'));
showSettings('#topnav-options', $.cookie('settings_effect'));
showSettings('#shelf-options', $.cookie('settings_effect'));
showSettings('#user-options', $.cookie('settings_effect'));
showSettings('#main-options', $.cookie('settings_effect'));
showSettings('#inset-options', $.cookie('settings_effect'));
showSettings('#outer-sidebar-options', $.cookie('settings_effect'));
showSettings('#inner-sidebar-options', $.cookie('settings_effect'));
showSettings('#footer-options', $.cookie('settings_effect'));