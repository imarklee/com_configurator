jQuery.noConflict();
(function($){
	$(function(){
		jQuery.event.add( window, "load", function(){
			var oldhref = $('#livedocs').contents().find('a').each(function(){
	 			var oldhref = $(this).attr('href');
	 			var newhref = $(this).attr('href', '../administrator/index.php?option=com_configurator&task=pt_proxy&format=raw&url=http://www.prothemer.com'+oldhref);
	 		});
		});
	});
})(jQuery);