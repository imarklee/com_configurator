var arrPageSizes = ___getPageSize();

function hideScroll(){
	$('html').addClass('hide-scroll');
	$('#processing, #alf-image').css({ width: arrPageSizes[0]+15 });
	return true;
}

function showScroll(){
	$('html').removeClass('hide-scroll');
	return true;
}

var thisWidth = function(){
	this.win = window.innerWidth || document.body.clientWidth;
	this.body = arrPageSizes[0]+15;
	if($('#processing').children().is('div')) this.inner = $('#processing div').css('width').replace('px', '');
}

var thisHeight = function(){
	this.win = window.innerHeight || document.body.clientHeight;
	this.body = arrPageSizes[1];
	if($('#processing').children().is('div')) this.inner = $('#processing div').css('height').replace('px', '');
}

function check_admin_session(action){
	$.ajax({
		type: 'post',
		url: '?option=com_configurator&task=check_admin_session&format=raw',
		success: function(data){
			if(data != 'active'){
				$('body').append('<div id="session-error" class="dialog-msg"><strong>Your administration session has expired.</strong><br />You will need to login again to perform this action. Press OK to be redirected to the login page.</div>')
				close_ptOverlay();
				$('#session-error').dialog({
					bgiframe: true,
		   			autoOpen: true,
		   			width: 300,
		   			stack: false,
		   			modal: true, 
		   			title: 'Session Expired',
		   			overlay: {
		   				'background-color': '#000', 
		   				opacity: 0.8 
		   			},
		   			close: function(){
						$(this).dialog('destroy');
						window.location.reload(true);
		   			},
					buttons: { 
						'OK': function(){
							var $this = $(this);
							$this.dialog('close');
			   			}
			   		}
				});
				
			}else{
				return action;
			}
		}
	});
}

/**
* getPageSize() by quirksmode.com
* @return Array Return an array with page width, height and window width, height
*/

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

function ptOverlay(msg, type){
	
	if(type != 'growl' || typeof type != 'undefined'){
				
		$('#processing').remove();
		if(typeof msg !== 'undefined'){
			$('<div id="processing"><div><img src="../administrator/components/com_configurator/images/loader3.gif" height="16" width="16" border="0" align="center" alt="Loading" /><span>'+msg+'</span></div></div>')
			.appendTo('body');
		}else{
			$('<div id="processing"></div>')
			.appendTo('body');
		}
	
		var getHeight = new thisHeight;
		var getWidth = new thisWidth;
		var oscrollTop = window.pageYOffset || document.body.scrollTop
		var oscrollLeft = window.pageXOffset || document.body.scrollLeft
		var winHeightHalf = getHeight.win/2;
		var winWidthHalf = getWidth.win/2;
		var innerHeightHalf = getHeight.inner/2;
		var innerWidthHalf = getWidth.inner/2;
	
		$('#processing').css({
			display: 'block',
			zIndex: '9998',
			position: 'absolute',
			top: 0,
			left: 0,
			width: getWidth.body,
			height: 3000
		});

		$('#processing div').css({
			position: 'absolute',
			top: winHeightHalf - innerHeightHalf + oscrollTop,
			left: winWidthHalf - innerWidthHalf + oscrollLeft + 15
		});
	
		$(window).resize(function() {
			var arrPageSizes = ___getPageSize();
			var getHeight = new thisHeight;
			var getWidth = new thisWidth;
			var oscrollTop = window.pageYOffset || document.body.scrollTop
			var oscrollLeft = window.pageXOffset || document.body.scrollLeft
			var winHeightHalf = getHeight.win/2;
			var winWidthHalf = getWidth.win/2;
			var innerHeightHalf = getHeight.inner/2;
			var innerWidthHalf = getWidth.inner/2;
		
			$('#processing').css({
				width: arrPageSizes[0],
				height: arrPageSizes[1]
			});
			$('#processing div').css({
				position: 'absolute',
				top: winHeightHalf - innerHeightHalf + oscrollTop,
				left: winWidthHalf - innerWidthHalf + oscrollLeft + 15
			});
		});
	
		hideScroll();
	}
	return false;
}

function close_ptOverlay(){
	$('#processing').css('display', 'none');
	showScroll();
}

jQuery.fn.delay = function(time,func){
	return this.each(function(){
	    setTimeout(func,time);
	});
};
