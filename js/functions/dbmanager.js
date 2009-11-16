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

$('#database-manager ul li.action a').click(function(){
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
	ptOverlay('Processing...');

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
					close_ptOverlay();
					hideScroll();
					$('.dialog-msg').html(data);
					$('.dialog-msg').dialog('option', 'buttons', {
						'OK': function(){
							close_ptOverlay();
							$(this).dialog('destroy');
							ptOverlay('Refreshing...');
							var maintabs = $("#tabs").tabs();
							var subtabs = $("#tools-tabs").tabs();
							maintabs.tabs("select",4);
							subtabs.tabs("select",1);
							close_ptOverlay();
							window.location.reload();
						}
					});
					$('.dialog-msg').dialog('open');
				}
			);
		}else{
			close_ptOverlay();
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
		var file = $('#import_file');
		if(file.val() != ''){

			$('.dialog-msg').html('<p><strong>You are about to restore a database backup!</strong></p>Would you like to download a temporary database backup before restoring?');
			$('.dialog-msg').dialog('option', 'title', 'Restore Warning');
			$('.dialog-msg').dialog('option', 'buttons', {
				'Yes': function(){
					window.location.href = '../administrator/index.php?option=com_configurator&task=create_db_backup&format=raw&type=full-database&download=true&url';
					$(this).dialog('close');
					ptOverlay('Processing...');
					$.ajaxFileUpload({
						url: '../administrator/index.php?option=com_configurator&format=raw&task=import_db',
						dataType: 'json',
						fileElementId:'import_file',
						success: function (data, status){
							close_ptOverlay();
							$('.dialog-msg').html(data.success);
							$('.dialog-msg').dialog('option', 'title', 'Error');
							$('.dialog-msg').dialog('option', 'buttons', {
								'OK': function(){
									$(this).dialog('destroy');
									ptOverlay('Reloading...');
									window.location.reload(true);
								}
							});
							$('.dialog-msg').dialog('open');

						}
					});
				},
				'No':function(){
					$(this).dialog('close');
					ptOverlay('Processing...');
					$.ajaxFileUpload({
						url: '../administrator/index.php?option=com_configurator&format=raw&task=import_db',
						dataType: 'json',
						fileElementId:'import_file',
						success: function (data, status){
							close_ptOverlay();
							$('.dialog-msg').html(data.success);
							$('.dialog-msg').dialog('option', 'title', 'Error');
							$('.dialog-msg').dialog('option', 'buttons', {
								'OK': function(){
									$(this).dialog('destroy');

									ptOverlay('Reloading...');
									window.location.reload(true);
								}
							});
							$('.dialog-msg').dialog('open');

						}
					});
				}
			});
			close_ptOverlay();
			$('.dialog-msg').dialog('open');

		}else{
			close_ptOverlay();
			hideScroll();
			$('.dialog-msg').html('Please select a file to import.');
			$('.dialog-msg').dialog('option', 'title', 'Error');
			$('.dialog-msg').dialog('option', 'buttons', {
				'OK': function(){
					$(this).dialog('destroy');
					showScroll();
				}
			});
			$('.dialog-msg').dialog('open');
		}

	}

	return false;
});