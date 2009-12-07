
function show_positions(selector, list, act){
	$('body').append('<div id="mod-dialog" class="dialog-msg"></div>');
	
	$(selector).change(function(){
	
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
				res = data.split(',');
				$(list).fadeIn('normal')

				for(i=0;i<res.length;i++){
					if(res[i] != ''){ 
						$(list).append('<option value="'+res[i]+'">'+res[i]+'</option>'); 
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
			//$(list).after('<ul id="new-'+act+'-multiselect"></ul><ul id="new-'+act+'-all"><li><a href="#" class="ms-'+act+'-all">'+act+" all</a></li></ul>");
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
				$('#new-'+act+'-multiselect').append('<li>'+$(this).text()+link+'</li>');
			});
			
			$('#new-'+act+'-all li a.ms-'+act+'-all').live("click", function(){
				$('#new-'+act+'-multiselect li a.ms-'+act).each(function(){
					$(this).trigger('click');
				});
				return false;
			});
			
			$('#new-'+act+'-multiselect li a.ms-'+act).live("click", function(){
				
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
						// remove
						$('#'+old_selectlist+' option[value="'+$(this).parent().parent().text().replace(act, '')+'"]').remove();
						$(this).parent().parent().remove();
						// add
						$('#new-remove-multiselect').append('<li>'+$(this).parent().parent().text().replace(act, '')+'<span><a class="ms-remove" href="#">remove</a></span>'+'</li>');
						$('#mp-dest #new-modules').append('<option value="'+$(this).parent().parent().text().replace(act, '')+'">'+$(this).parent().parent().text().replace(act, '')+'</option>');
					break;
					case 'remove':
						var old_selectlist = $(this).parent().parent().parent().prev().attr('id');
						// remove
						$('#'+old_selectlist+' option[value="'+$(this).parent().parent().text().replace(act, '')+'"]').remove();
						$(this).parent().parent().remove();
						// add
						$('#new-add-multiselect').append('<li>'+$(this).parent().parent().text().replace(act, '')+'<span><a class="ms-add" href="#">add</a></span>'+'</li>');
						$('#mp-source #old-modules').append('<option value="'+$(this).parent().parent().text().replace(act, '')+'">'+$(this).parent().parent().text().replace(act, '')+'</option>')
					break;
				}
				
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
	if($('#mp-dest #new-positions').val()=="" || $('#mp-source #old-positions').val()==""){
		if(typeof act == 'undefined'){
			act = 'remove';
		}
		var target = 'source';
		
		if(act == "add"){ target = 'destination'; }
		$('#mod-dialog').dialog('destroy');
		$('#mod-dialog').html('You have not selected a '+target+'. Please select a '+target+' before trying to migrate a module.');
		$('#mod-dialog').dialog({
			title: 'Warning',
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
	alert('modules migrated');
	return false;
});