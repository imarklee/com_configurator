$('#assets-tabs').bind('tabsload', function(event, ui) { 
	$('#recycle-list tbody tr a, a.empty-recycle').click(function(){
		var r_action = $(this).attr('action');
		var r_type = $(this).attr('ftype');
		var r_file = $(this).attr('name');
		$this = $(this);
	
		$('body').append('<div id="recycle-message" class="dialog-msg" style="display:none;">');
		$('#recycle-message').dialog({
			autoOpen: false, 
			bgiframe: true, 
			resizable: false,
			draggable: false,
			minHeight: 20,
			width: 350,
			modal: true, 
			title: 'Warning',
			overlay: {
				backgroundColor: '#000', 
				opacity: 0.8 
			},
			close: function(){
				$(this).dialog('destroy');
				$('#recycle-message').remove();
				showScroll();
			}	
		});
	
		switch(r_action){
			case 'empty':
				$('#recycle-message').html('Are you sure you want to empty the Recycle Bin?<br /><strong>This is permanent and irreversible.</strong>');
				$('#recycle-message').dialog('option', 'buttons', {
					'Yes': function(){
						$.ajax({
							url: '?option=com_configurator&task=handle_recycle&format=raw&action=empty&type=null&file=null',
							success: function(d){
								$('#recycle-message').dialog('close');
								ptOverlay('Reloading Interface...');
								window.location.reload(true);
								return;
							}
						});
					},
					'No': function(){
						$(this).dialog('close');
					}
				});
				$('#recycle-message').dialog('open');
				hideScroll();
			break;
			case 'delete':
				$('#recycle-message').html('Are you sure you want to this file?<br /><strong>This is permanent and irreversible.</strong>');
				$('#recycle-message').dialog('option', 'buttons', {
					'Yes': function(){
						$.ajax({
							url: '?option=com_configurator&task=handle_recycle&format=raw&action=delete&type='+r_type+'&file='+r_file,
							success: function(d){
								$this.parent().parent().remove();
								if($("#recycle-list tbody tr").length > 0){
									$("#recycle-list tbody tr").each(function(){
										$(this).children().removeClass('alt');
										$(this).children(':odd').addClass('alt');
									});
								}else{
								    $('#recycle-list').empty().remove();
								    $('#assets-recycle').append('<div class="no-assets">The Recycle Bin is empty.</div>');
								}
								$('#recycle-message').dialog('close');
							}
						});
					},
					'No': function(){
						$(this).dialog('close');
					}
				});
				$('#recycle-message').dialog('open');
				hideScroll();
			break;
			case 'restore':
				$.ajax({
					url: '?option=com_configurator&task=handle_recycle&format=raw&action=restore&type='+r_type+'&file='+r_file,
					success: function(d){
						$this.parent().parent().fadeOut('slow', function(){
							$(this).remove();
							if($("#recycle-list tbody tr").length > 0){
								$("#recycle-list tbody tr").each(function(){
									$(this).children().removeClass('alt');
									$(this).children(':odd').addClass('alt');
								});
							}else{
								$('#recycle-list').empty().remove();
								$('#assets-recycle').append('<div class="no-assets">The Recycle Bin is empty.</div>');
							}
						});
						return;
					}
				});
			break;
		
		}
		return false;
	});
});