function showSave(){
	var scrollTop = window.pageYOffset || document.body.scrollTop;
	if(scrollTop > 220){
		$('#bottom-save').fadeIn('slow');
	}else{
		$('#bottom-save').fadeOut('slow');
	}
}
$('#bottom-save').hide();
$(window).scroll(function(){
	showSave();	
})