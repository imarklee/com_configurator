$(window).scroll(function(){	
	var bs_scrollTop = window.pageYOffset || document.body.scrollTop;
	if($.cookie('formChanges') == 'true'){
		if(bs_scrollTop > 180){
			$('#bottom-save').fadeIn('slow');
		}else{
			$('#bottom-save').fadeOut('slow');
		}
	}
});