var listitems = $('.forms li', '#cfg.menuitem_active'),
	active_listitems = $('#cfg').attr('data-active-menuitems').split(','), 
	changeState = function(event){
		if($(this).is(':input')) {
			event.data.toggle.addClass('active');
			$('input', event.data.toggle).attr('checked', 'checked');
			event.data.row.removeClass('locked');
		} else {
			var toggle = $(':input', event.data.toggle);
			toggle.is('[checked]') ? toggle.removeAttr('checked') : toggle.attr('checked', 'checked');
			event.data.toggle.toggleClass('active');
			event.data.row.toggleClass('locked');
		}
	};

//listitems.css('-webkit-transform', 'rotate(1deg)');

listitems.each(function(i, item){
	var input = $('[name]:input', item), part = input[0].name.replace(/^.+?\[/i, '').replace(/\]/, ''), name = 'menuitem_active[' + part + ']', id = 'menuitem_active_' + part, checked = $.inArray(part, active_listitems), state = '';
	
	if(checked >= 0) {
		checked = 'checked="checked"';
		state   = ' active';
		item.removeClass('locked');
	} else {
		checked = '';
		item.addClass('locked');
	}
	var toggle = $('<div class="menuitem_active_toggle'+state+'"><input type="checkbox" name="'+name+'" id="'+id+'"'+checked+' value="1" /></div>').appendTo(item), data = {toggle: toggle, row: item};
	toggle.bind('click', data, changeState);
	input.bind('change', data, changeState);
});

// For the themelets assets tab
var themelet_active = $.inArray('themelet', active_listitems);

$('#cfg.menuitem_active #assets-tabs').bind('tabsload', function(event, ui){
	if(ui.index > 0) return this;
	var toggle = $('#menuitem_active_themelet'), state   = ' active';
	if(!toggle.is('[checked]')) state = '';
	console.log(toggle);
	$('<div class="menuitem_active_toggle'+state+'"></div>').prependTo($('#themelet-switch p')).click(function(){
		this.toggleClass('active');
		toggle.click();
	});
});