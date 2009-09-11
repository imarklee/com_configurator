$('#database-manager ul.actions li ul').css('display', 'none');
$('#database-manager ul.actions li input[type="radio"]').click(function(){
	$(this).parent().parent().children('ul').css('display', 'block');
});