$('#database-manager ul.actions li ul').css('display', 'none');
$('#database-manager ul.actions li input[type="radio"]').click(function(){
	$(this).parent().parent().children('ul').css('display', 'block');
});

$('#backup-list a').click(function(){
	var $this = $(this);
	var act;
	var action = $(this).attr('action');
	var filename = $(this).attr('name');
	var url = '../administrator/index.php?option=com_configurator&format=raw&task=handle_db_backup&action='+action+'&filename='+filename;
	
	$('<div class="dialog-msg"></div>').dialog({
		bgiframe: true,
		autoOpen: false,
		minHeight: 20,
		stack: false,
		modal: true, 
		title: 'Activate',
		overlay: {
			'background-color': '#000', 
			opacity: 0.8 
		},
		buttons: { 
			'OK': function(){
				$(this).dialog('close');
				showScroll();
   			}
   		}
   	});
	
	if(action != 'download'){
		overlay('Processing...');
		if(action == 'restore'){
			$('.dialog-msg').html('<p><strong>You are about to restore a database backup!</strong></p>Would you like to download a temporary database backup before restoring?');
			$('.dialog-msg').dialog('option', 'buttons', {
				'Yes': function(){
					window.location.href = '../administrator/index.php?option=com_configurator&task=create_db_backup&format=raw&type=full-database&download=true&url';
					$(this).dialog('close');
					overlay('Processing...')
					$.ajax({
						type: 'POST',
						url: '../administrator/index.php?option=com_configurator&task=restore_db_backup&format=raw&url&filename='+filename,
						success: function(data){
							closeOverlay();
							hideScroll();
							$('.dialog-msg').html('restored with backup');
							$('.dialog-msg').dialog('option', 'buttons', {
								'OK': function(){
									$(this).dialog('destroy');
									showScroll();
								}
							});
							$('.dialog-msg').dialog('open');
						}
					});
				},
				'No':function(){
					$(this).dialog('close');
					overlay('Processing...')
					$.ajax({
						type: 'POST',
						url: '../administrator/index.php?option=com_configurator&task=restore_db_backup&format=raw&url&filename='+filename,
						success: function(data){
							closeOverlay();
							hideScroll();
							$('.dialog-msg').html(data);
							$('.dialog-msg').dialog('option', 'buttons', {
								'OK': function(){
									$(this).dialog('destroy');
									showScroll();
								}
							});
							$('.dialog-msg').dialog('open');
						}
					});
				}
			});
			closeOverlay();
			$('.dialog-msg').dialog('open');
		}else{
			$.ajax({
				type: 'POST',
				url: url,
				success: function(data, status){
					closeOverlay();
					hideScroll();
					$('.dialog-msg').html(data);
					$('.dialog-msg').dialog('open');
					if(action == 'delete'){
						$this.parent().parent().fadeTo('slow', 0).remove();
					}
				}
			});
		}
	}else{
		window.location.href = url;
	}
	return false;
});