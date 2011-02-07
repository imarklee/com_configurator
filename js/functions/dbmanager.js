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
			$.post('?option=com_configurator&view=configuration&format=raw', { action: 'export_db', 'export_data[]': checkVal },
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
					//@TODO needs larger refactor
					window.location.href = '../?option=com_configurator&task=create_db_backup&format=raw&type=full-database&download=true&url';
					$(this).dialog('close');
					ptOverlay('Processing...');
					$.ajaxFileUpload({
						url: '../?option=com_configurator&view=configuration&format=raw',
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
					//Callback that adds the token and action
					}, function(form){
						form.append($('<input />', {name: 'action', value: 'import_db'}))
							.append($('<input />', {name: '_token', value: $('input[name=_token]').val()}));
					});
				},
				'No':function(){
					$(this).dialog('close');
					ptOverlay('Processing...');
					$.ajaxFileUpload({
						url: '?option=com_configurator&view=configuration&format=raw',
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
					//Callback that adds the token and action
					}, function(form){
						form.append($('<input />', {name: 'action', value: 'import_db'}))
							.append($('<input />', {name: '_token', value: $('input[name=_token]').val()}));
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