function getUpdates(elm, time, checknow, callback){

	var cookiedate = new Date();
	var minutes = cookiedate.getMinutes();
	if(typeof time == 'undefined' || time == null){ minutes += 60; }else{ minutes += time; }
	cookiedate.setMinutes(minutes);	
	updateURL = 'https://www.joomlajunkie.com/versions/versions.php?return=json&callback=?';
	
	if(!$.cookie('noupdates') || checknow){
		
		if(!$.cookie('checkedforupdates') || checknow){
			$.ajax({
				method: 'get',
				url: updateURL,
				cache: false,
				dataType: 'json',
				timeout: (2*1000),
				success: function(obj, status){
					check(obj, status);
   				}
   			});
			function check(json){
   				for(i=0;i<4;i++){
			   		if($(elm[i]).attr('class') !== undefined){
				   		var classes = $(elm[i]).attr('class').split(' ');
				   		var type = classes[0];
				   		var name = classes[1];
				   		if(elm[i] == '.themelet-summary'){ isOtherThemelet = 'true'; }
				   		if(name !== 'no-themelets'){
				   			var cookiename = json.updates[name].short_name;
				   			var version = json.updates[name].version;
				   			var updated = json.updates[name].updated;
				   			$.cookie('us_'+cookiename, version+'##'+updated, { expires: cookiedate });
				   			var current = $('dt.'+cookiename).next().children();
				   			var latest = $('dt.'+cookiename).next().next();
				   			latest.html('<span title="The latest available version is '+version+'. Click on the help link above for more information."">'+version+'</span>');
				   			
				   			if(current.html() < version){
				   				$('dt.'+cookiename).next().next().next().html('<span class="update-no" title="There is an update available">Update Available</span>');
				   			}else{
				   				$('dt.'+cookiename).next().next().next().html('<span class="update-yes" title="You are up to date">Up to date</span>');
				   			}
				   			$.cookie('checkedforupdates', true, { expires: cookiedate });
				   			
				   			if(typeof callback == 'function'){
				   				return callback();
				   			}
				   		}
			   		}
		   		}
		   	}
	   	}else{
	   		return false;
	   	}
	}else{
		return false;
	}
	

/*** add update checker set to a future date ( system time + defined interval). on refresh reset 
the timer to countdown from the current difference from current time to the future date so that 
set interval is kept. ***/
};

var updEl = new Array('dt#us-configurator', 'dt#us-morph', 'dt#us-themelet', '.themelet-summary');
getUpdates(updEl);

$('.updates-refresh-link').click(function(){
	$('#updates-summary dl').fadeTo('fast', 0.1, function(){
		$('<div class="updates-msg">Checking...</div>').appendTo($('#updates-summary'));
	});
	getUpdates(updEl, null, true, function(){
		$('#updates-summary .updates-msg').remove();
		$('#updates-summary dl').fadeTo('fast', 1);
		
	});	
	return false;
});

if($.jqURL.get('task') == 'dashboard'){
	$("#submenu").append('<li class="full-mode" id="fullscreen"><a href="#" id="screenmode">Fullscreen Mode</a></li>');
}else if($.jqURL.get('task') == 'manage' || $.jqURL.get('task') == 'manage#'){
	if($.cookie('am_logged_in')){
		$("#toolbar .toolbar tr").append('<td id="fullscreen"><a href="#">Fullscreen</a></td>','<td id="preferences"><a href="#">Preferences</a></td>','<td id="report-bug-email-link"><a href="#">Feedback</a></td>	');
	}else{
		$("#submenu").append('<li class="feedback"><a href="#" id="report-bug-email-link">Problems Logging in?</a></li>','<li class="full-mode" id="fullscreen"><a href="#" id="screenmode">Fullscreen Mode</a></li>');
	}
}