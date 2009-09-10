function showSave(){
	var scrollTop = window.pageYOffset || document.body.scrollTop;
	if($.cookie('formChanges') == 'true'){
		if(scrollTop > 180){
			$('#bottom-save').fadeIn('slow');
		}else{
			$('#bottom-save').fadeOut('slow');
		}
	}
}
$('#bottom-save').hide();
$(window).scroll(function(){	
	showSave();
})