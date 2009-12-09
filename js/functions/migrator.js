
function show_positions(selector, list, act){
	$('body').append('<div id="mod-dialog" class="dialog-msg"></div>');
	
	$(selector).change(function(){
		
		$('#mp-dest #new-positions').removeAttr('disabled');
	
		$this = $(this);
		if( $(this).val() == '' || typeof $(this).val() == undefined){ return false; }
		
		if(!$.cookie('ms-changes')){
			reset_boxes(list, selector);
		}else{
			$('#mod-dialog').dialog('destroy');
			$('#mod-dialog').html('You have selected to migrate modules to a new destination but have not yet saved. <br />Would you like to save or clear these changes?');
			$('#mod-dialog').dialog({
				title: 'Warning',
				autoOpen: true,
				modal: true,
				open: function(){
					hideScroll();
				},
				close: function(){
					showScroll();
					$(this).dialog('destroy');
				},
				buttons: {
					'Save': function(){
						// add save functionality
						$(this).dialog('close');
						$('#mp-source #old-positions').val($('#mp-source #old-positions').val());
						$('#mp-source #old-positions').trigger("change");
					},
					'Clear': function(){
						$(this).dialog('close');
						$('#mp-source #old-positions').val($('#mp-source #old-positions').val());
						$('#mp-source #old-positions').trigger("change");
						$('#mp-dest #new-positions').val($('#mp-dest #new-positions').val());
						$('#mp-dest #new-positions').trigger("change");
					}
				}
			});
			$.cookie('ms-changes', null);
			return false;
		}

		$.ajax({
			url: '../administrator/index.php?option=com_configurator&task=get_modules_by_position&format=raw&position='+$(this).val(),
			success: function(data){
				if(data == ''){
					return false;
				}
				
				res = data.split(',');
				
				$(list).fadeIn('normal')

				for(i=0;i<res.length;i++){
					newsplit = res[i].split(':');
					mod_db = newsplit[1].split('#');
				
					if(res[i] != ''){ 
						$(list).append('<option class="'+mod_db[1]+'" value="'+mod_db[0]+'">'+newsplit[0]+'</option>'); 
					}
				}
			
				add_remove(list, act);			
			}
		});
		
		function reset_boxes(list){
			$(list).empty();
			$(list).next().empty();
		}
		
		function add_remove(list, act){
			$(list).hide();
			var link = '';
			switch(act){
				case 'add':
				link = '<span><a class="ms-'+act+'" href="#">add</a></span>';
				break;
				case 'remove':
				link = '<span><a class="ms-'+act+'" href="#">remove</a></span>';
				break;
			}
			$(list).children().each(function(){
				val = $(this).text();
				$('#new-'+act+'-multiselect').append('<li modid="'+$(this).attr('class')+'" mod="'+$(this).val()+'">'+$(this).text()+link+'</li>');
			});
			
			$('#new-'+act+'-multiselect li a.ms-'+act).live('click', function(){
				
				if($('#mp-source #old-positions').val()=="" || $('#mp-dest #new-positions').val()==""){
					error_dialog(act);
					return false;
				};
				
				if(!$.cookie('ms-changes')){
					$.cookie('ms-changes', 'true');
				}
				
				switch(act){
					case 'add':
						var old_selectlist = $(this).parent().parent().parent().prev().attr('id');
						$('#'+old_selectlist+' option[value="'+$(this).parent().parent().attr('mod')+'"]').remove();
						$(this).parent().parent().remove();
						$('#new-remove-multiselect').append('<li modid="'+$(this).parent().parent().attr('modid')+'" mod="'+$(this).parent().parent().attr('mod')+'">'+$(this).parent().parent().text().replace(act, '')+'<span><a class="ms-remove" href="#">remove</a></span>'+'</li>');
						$('#mp-dest #new-modules').append('<option class="'+$(this).parent().parent().attr('modid')+'" value="'+$(this).parent().parent().attr('mod')+'">'+$(this).parent().parent().text().replace(act, '')+'</option>');
					break;
					case 'remove':
						var old_selectlist = $(this).parent().parent().parent().prev().attr('id');
						$('#'+old_selectlist+' option[value="'+$(this).parent().parent().attr('mod')+'"]').remove();
						$(this).parent().parent().remove();
						$('#new-add-multiselect').append('<li modid="'+$(this).parent().parent().attr('modid')+'" mod="'+$(this).parent().parent().attr('mod')+'">'+$(this).parent().parent().text().replace(act, '')+'<span><a class="ms-add" href="#">add</a></span>'+'</li>');
						$('#mp-source #old-modules').append('<option class="'+$(this).parent().parent().attr('modid')+'" value="'+$(this).parent().parent().attr('mod')+'">'+$(this).parent().parent().text().replace(act, '')+'</option>')
					break;
				}
				
				return false;
			});
			
			$('#new-'+act+'-all a.ms-'+act+'-all').live('click',function(){
				$('#new-'+act+'-multiselect li a.ms-'+act).each(function(){
					$(this).trigger('click');
				});
				return false;
			});
			
		}
		
		$('#migrate-submit a').live('click', function(){
			error_dialog(act)
			alert('modules migrated');
			
			return false;
		});
		
		return false;
	});
}

function error_dialog(act){
	if($('#mp-dest #new-positions').val()==""){
		
		$('.contents .tooltip').fadeIn(500);
		setTimeout(function(){
			$('.contents .tooltip').fadeOut(500);
		}, 4000);
		return false;
	}
	return false;
}

show_positions('#mp-source #old-positions', '#mp-source #old-modules', 'add');
show_positions('#mp-dest #new-positions', '#mp-dest #new-modules', 'remove');

$('#migrate-submit a').live('click', function(){
	if($('#mp-source #old-positions').val()==""){
		error_dialog();
		return false;
	};
	if($('#mp-dest #new-positions').val()==""){
		error_dialog('add');
		return false;
	}
	
	var position = $('#mp-dest #new-positions').val();
	var old_position = $('#mp-source #old-positions').val();
	var modules = $('#mp-dest #new-modules option');
	
	var mods = '';
	var count = 0;
	var mod_id = '';
	
	modules.each(function(){
		count++;
		if(count < modules.length){
			split = ',';
		}else{
			split = '';
		}
		
		mods += $(this).val()+split;
		mod_id += $(this).attr('class')+split;
	});
	
	$.ajax({
		url: '../administrator/index.php?option=com_configurator&format=raw&task=migrate_modules',
		type: 'post',
		data: {
			position: position,
			old_pos: old_position,
			id: mod_id,
			modules: mods
		},
		success: function(data){
			
			$('#mod-dialog').dialog('destroy');
			$('#mod-dialog').html(data);
			$('#mod-dialog').dialog({
				title: 'Success',
				autoOpen: true,
				modal: true,
				open: function(){
					hideScroll();
				},
				close: function(){
					$.cookie('ms-changes', null);
					showScroll();
					$(this).dialog('destroy');
					return false;
				},
				buttons: {
					'OK': function(){
						$(this).dialog('close');
					}
				}
			});
		}
	});
	return false;
});
function migrate_reset(link_el){
	
	$(link_el).click(function(){
		ptOverlay('Resetting Modules...');
		switch($(this).attr('action')){
			case 'outer':
				$.ajax({
					url: '../administrator/index.php?option=com_configurator&format=raw&task=reset_modules&position=left',
					success: function(){
						close_ptOverlay();
						$('#element-box').before('<dl id="system-message"><dt class="message">Message</dt><dd class="message message fade"><ul><li>Successfully reset your modules.</li></ul></dd></dl>');	
						$('#system-message').delay(3000, function(){ $('#system-message').fadeOut().remove(); });
					}
				});
			break;
			case 'inner':
				$.ajax({
					url: '../administrator/index.php?option=com_configurator&format=raw&task=reset_modules&position=right',
					success: function(){
						close_ptOverlay();
						$('#element-box').before('<dl id="system-message"><dt class="message">Message</dt><dd class="message message fade"><ul><li>Successfully reset your modules.</li></ul></dd></dl>');	
						$('#system-message').delay(3000, function(){ $('#system-message').fadeOut().remove(); });
					}
				});
			break;
		}
		return false;
	});
}
migrate_reset('#migrate-reset .migrate-outer a');
migrate_reset('#migrate-reset .migrate-inner a');