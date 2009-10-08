jQuery.noConflict();
(function($){
	$(document).ready(function(){
		$(window).load(function(){
			//alert(document.getElementById('livedocs').contentWindow.document.body.height);
			var child = $('#livedocs').contents();
			alert(child[0].contentWindow.document.body.height)
			
			
		})		
	});
})(jQuery);