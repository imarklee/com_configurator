/* Colour Picker ----------------------
------------------------------------ */
function loadColourPicker(elid) {
	
	// keep applied colour
	if($(elid).prev().val() != 'default'){
		$(elid).css({
			'background-color': '#'+$(elid).prev().val()
		});
	}
	// load the colour picker
	var cp = $(elid).children().attr('id');
	$(elid).ColorPicker({
		flat: true,
		livePreview: true,
		onSubmit: function(hsb, hex, rgb){
			var cp = $(elid).children().attr('id');
			$(elid).prev().val('#'+hex);
			$('#'+cp).fadeOut(500);
			$(elid).css('background-color', '#' + hex);
		},
		onHide: function(){
			var cp = $(elid).children().attr('id');
			$('#'+cp).fadeOut(500);
		}
	})
	.bind('keydown', function(){
		$(this).ColorPickerSetColor(this.value);
	});

	$(document).bind("keydown.colorpicker", function(e){
		keycode = (e.which || e.keyCode);
		if(keycode == 27){
			$(elid).children().fadeOut(500);
			return false;
		}
	}); 
	return false;
}

$('a.picker').click(function(){
	cp = $(this).prev().children().attr('id');
	loadColourPicker($(this).prev());
	$('#'+cp).fadeIn(500).css({
		'z-index': '9999',
		'position': 'relative',
		'bottom': '33px',
		'right': '-23px'
	});		
	return false;
});

$('.color-preview').each(function(){
	var colval = $(this).prev().val();
	if(colval != 'default'){
		$(this).css('background-color', colval);
	}
});