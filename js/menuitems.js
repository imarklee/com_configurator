var listitems = $('.forms li', '#cfg.menuitem_active'),
	active_listitems = $('#cfg').attr('data-active-menuitems').split(','), 
	changeState = function(event){
		if($(this).is(':input')) {
			event.data.toggle.addClass('active');
			$('input', event.data.toggle).attr('checked', 'checked');
			event.data.row.removeClass('unlocked');
		} else {
			var toggle = $(':input', event.data.toggle);
			toggle.is('[checked]') ? toggle.removeAttr('checked') : toggle.attr('checked', 'checked');
			event.data.toggle.toggleClass('active');
			event.data.row.toggleClass('unlocked');
		}
	};

//listitems.css('-webkit-transform', 'rotate(1deg)');

listitems.each(function(i, item){
	var input = $('[name]:input', item), part = input[0].name.replace(/^.+?\[/i, '').replace(/\]/, ''), name = 'menuitem_active[' + part + ']', id = 'menuitem_active_' + part, checked = $.inArray(part, active_listitems), state = '';
	
	if(checked > 0) {
		checked = 'checked="checked"';
		state   = ' active';
		item.removeClass('unlocked').fa;
	} else {
		checked = '';
		item.addClass('unlocked');
	}
	var toggle = $('<div class="menuitem_active_toggle'+state+'"><input type="checkbox" name="'+name+'" id="'+id+'"'+checked+' /></div>').appendTo(item), data = {toggle: toggle, row: item};
	toggle.bind('click', data, changeState);
	input.bind('change', data, changeState);
	console.warn($(input))

});