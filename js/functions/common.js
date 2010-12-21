var arrPageSizes = ___getPageSize();

function hideScroll(){
	$('html').addClass('hide-scroll');
	$('#processing').css({ width: arrPageSizes[0]+15 });
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

//@TODO weird issue with hegith sometimes, resizing window solves it.
function ptOverlay(msg, type){
	
	if(type != 'growl' || typeof type != 'undefined'){
		
		hideScroll();
		
		$('#processing').remove();
		if(msg){
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
