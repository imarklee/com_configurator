$('#database-manager ul li ul').css('display', 'none');
$('#database-manager ul li input[type="radio"]').click(function(){
	$('#database-manager ul li ul').css('display', 'none');
	$(this).parent().next().css('display', 'block');
});

$('#database-manager ul li ul li input').click(function(){
	if($(this).is(':checked')){
		$(this).parent().css('font-weight', 'bold');
	}else{
		$(this).parent().css('font-weight', 'normal');
	}
});

$('#database-manager ul li.action input').click(function(){
	var action = $('#database-manager ul li input[type="radio"]:checked').val();
	
	$('<div class="dialog-msg"></div>').dialog({
		bgiframe: true,
		autoOpen: false,
		minHeight: 20,
		stack: false,
		modal: true, 
		title: 'Export Successful',
		overlay: {
			'background-color': '#000', 
			opacity: 0.8 
		}
   	});
	overlay('Processing...');
	
	if(action == 'export'){
		var checkVal = [];
			
		$('#database-manager ul li ul li input').each(function(){
			if($(this).is(':checked')){
				checkVal.push($(this).val());
			}
		});
		
		if(checkVal.length > 0){	
			$.post('../administrator/index.php?option=com_configurator&task=export_db&format=raw', { 'export_data[]': checkVal },
				function(data, status){
					closeOverlay();
					hideScroll();
					$('.dialog-msg').html(data);
					$('.dialog-msg').dialog('option', 'buttons', {
						'OK': function(){
							closeOverlay();
							$(this).dialog('destroy');
							overlay('Refreshing...');
							window.location.reload();
						}
					});
					$('.dialog-msg').dialog('open');
				}
			);
		}else{
			closeOverlay();
			hideScroll();
			$('.dialog-msg').html('No export options were selected. Please select an option');
			$('.dialog-msg').dialog('option', 'title', 'Error');
			$('.dialog-msg').dialog('option', 'buttons', {
				'OK': function(){
					$(this).dialog('destroy');
					showScroll();
				}
			});
			$('.dialog-msg').dialog('open');
		}
		
	}else{
	
	}
	
	return false;
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
		overlay: {
			'background-color': '#000', 
			opacity: 0.8 
		},
		buttons: { 
			'OK': function(){
				closeOverlay();
				$('.dialog-msg').dialog('destroy').remove();
   			}
   		}
   	});
	
	if(action != 'download'){
		overlay('Processing...');
		if(action == 'restore'){
			$('.dialog-msg').html('<p><strong>You are about to restore a database backup!</strong></p>Would you like to download a temporary database backup before restoring?');
			$('.dialog-msg').dialog('option', 'title', 'Restore Warning');
			$('.dialog-msg').dialog('option', 'buttons', {
				'Yes': function(){
					window.location.href = '../administrator/index.php?option=com_configurator&task=create_db_backup&format=raw&type=full-database&download=true&url';
					$(this).dialog('close');
					overlay('Processing...')
					$.ajax({
						type: 'POST',
						url: '../administrator/index.php?option=com_configurator&format=raw&url&task=handle_db_backup&action='+action+'&filename='+filename,
						success: function(data){
							closeOverlay();
							hideScroll();
							$('.dialog-msg').html(data);
							$('.dialog-msg').dialog('option', 'buttons', {
								'OK': function(){
									closeOverlay();
									$('.dialog-msg').dialog('destroy').remove();
								}
							});
							$('.dialog-msg').dialog('option', 'title', 'Restore');
							$('.dialog-msg').dialog('open');
						}
					});
				},
				'No':function(){
					$(this).dialog('close');
					overlay('Processing...')
					$.ajax({
						type: 'POST',
						url: '../administrator/index.php?option=com_configurator&format=raw&url&task=handle_db_backup&action='+action+'&filename='+filename,
						success: function(data){
							closeOverlay();
							hideScroll();
							$('.dialog-msg').html(data);
							$('.dialog-msg').dialog('option', 'buttons', {
								'OK': function(){
									closeOverlay();
									$('.dialog-msg').dialog('destroy').remove();
								}
							});
							$('.dialog-msg').dialog('option', 'title', 'Restore');
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