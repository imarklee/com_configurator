/* Colour Picker ----------------------
------------------------------------ */
function loadColourPicker(elid, cpid) {
	// keep applied colour
	if($(elid).prev().val() != 'default'){
		$(elid).css({
			'background-color': '#'+$(elid).prev().val()
		});
	}
		if(cpid == undefined){ // first load
			$(elid).ColorPicker({
				flat: true,
				livePreview: true,
				onShow: function(){
					alert('showing');
				},
				onSubmit: function(hsb, hex, rgb){
					cp = $(elid).children().attr('id');
					$(elid).prev().val('#'+hex);
					$('#'+cp).fadeOut(500);
					$(elid).css('background-color', '#' + hex);
					$('#color-options').removeAttr('colorpicker_loaded');
				},
				onHide: function(){
					cp = $(elid).children().attr('id');
					$('#'+cp).fadeOut(500);
					$('#color-options').removeAttr('colorpicker_loaded');
				}
			})
			.bind('keydown', function(){
				$(this).ColorPickerSetColor(this.value);
			});
			cp = $(elid).children().attr('id');
		}else{
			cp = cpid;
			$('#'+cp).fadeIn(500);
		}
	
	// fake attribute to allow one picker at a time.
	$('#color-options').attr('colorpicker_loaded', cp);
	
	$(document).bind("keydown.colorpicker", function(e){
		keycode = (e.which || e.keyCode);
		if(keycode == 27){
			$(elid).children().fadeOut(500);
			$('#color-options').removeAttr('colorpicker_loaded');
			return false;
		}
	});
	$('.colorpicker_close').click(function(){
		var cp = $(elid).children().attr('id');
		$('#'+cp).fadeOut(500);
		$('#color-options').removeAttr('colorpicker_loaded');
	});
	
	return false;
}

$('a.picker').click(function(){
	var cp = $(this).prev().children().attr('id');
	if($('#color-options').attr('colorpicker_loaded') == undefined){
		loadColourPicker($(this).prev(), cp);
	}else{
		$('#'+$('#color-options').attr('colorpicker_loaded')).hide();
		loadColourPicker($(this).prev(), cp);
	}
	return false;
});

$('.color-preview').each(function(){
	var colval = $(this).prev().val();
	if(colval != 'default'){
		$(this).css('background-color', colval);
	}
});