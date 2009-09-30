// save bar function
switch($('#bottom-save').attr('class')){
	default: // do nothing if empty;
	case '':
	break;
	
	case 'always':
	$('#bottom-save').css('display', 'block');
	break;
	case 'unsaved':
	$('#templateform').change(function(event, data){
		var uploaderid = (event.target.id);
		if(uploaderid == 'insfile') { return false; event.preventDefault(); }
		$('#bottom-save').css('display', 'block');
	});
	break;
	case 'topsave':
	$(window).scroll(function(){	
		var bs_scrollTop = window.pageYOffset || document.body.scrollTop;
		if(bs_scrollTop > 180){
			$('#bottom-save').fadeIn('slow');
		}else{
			$('#bottom-save').fadeOut('slow');
		}
	});
	break;
	case 'unsaved_topsave':
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
	break;
}