// jQuery.noConflict();
// (function($){
// 	
// 	$.extend({URLEncode:function(c){var o='';var x=0;c=c.toString();var r=/(^[a-zA-Z0-9_.]*)/;while(x<c.length){var m=r.exec(c.substr(x));if(m!=null && m.length>1 && m[1]!=''){o+=m[1];x+=m[1].length;}else{if(c[x]==' ')o+='+';else{var d=c.charCodeAt(x);var h=d.toString(16);o+='%'+(h.length<2?'0':'')+h.toUpperCase();}x++;}}return o;},URLDecode:function(s){var o=s;var binVal,t;var r=/(%[^%]{2})/;while((m=r.exec(o))!=null && m.length>1 && m[1]!=''){b=parseInt(m[1].substr(1),16);t=String.fromCharCode(b);o=o.replace(m[1],t);}return o;}});
// 	
// 	function fixremote(){
// 		$('#livedocs').contents().find('a').each(function(){
// 			var oldhref = $.URLEncode($(this).attr('href'));
// 			$(this).attr('href', '../administrator/index.php?option=com_configurator&task=pt_proxy&format=raw&url='+oldhref);
// 			
// 			$(this).click(function(){
// 				window.frames.livedocs.location.href = $(this).attr('href');
// 				return false;
// 			});
// 		});
// 	}
// 	
// 	$.event.add( window, "load", function(){ return fixremote(); } );
// 	
// })(jQuery);