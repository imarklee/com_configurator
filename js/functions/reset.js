$('#reset-settings ul li.action a').click(function(){
	// create dialog
	$('<div class="dialog-msg"></div>').dialog({
		bgiframe: true,
		autoOpen: false,
		minHeight: 20,
		stack: false,
		modal: true, 
		overlay: {
			'background-color': '#000', 
			opacity: 0.8 
		}
   	});
	ptOverlay('Processing...');
	var error = false;
	var checkVal = [];	
	$('#reset-settings ul li input').each(function(){
		if($(this).is(':checked')){
			checkVal.push($(this).val());
		}
	});
	
	// no checkboxes selected
	if(checkVal.length == 0){
		close_ptOverlay();
		$('.dialog-msg').html("You haven't made a selection. Please choose a reset type.");
		$('.dialog-msg').dialog('option', 'title', 'Warning');
		$('.dialog-msg').dialog('option', 'buttons', {
			'OK': function(){
				$(this).dialog('destroy');
			}
		});
		$('.dialog-msg').dialog('open');
		error = true;
		return false;
	}
	
	// confirmation not selected
	if(!$('#reset-confirm').is(':checked') && checkVal.length >= 1){
		$('.dialog-msg').html('Your confirmation is required to reset Configurator. Please check the confirmation checkbox.');
		close_ptOverlay();
		$('.dialog-msg').dialog('option', 'title', 'Warning');
		$('.dialog-msg').dialog('option', 'buttons', {
			'OK': function(){
				$(this).dialog('destroy');
			}
		});
		$('.dialog-msg').dialog('open');
		error = true;
		return false;
	}
	
	if(!error){
		var i; 
		var successmsg = [];
		for(i=0;i<checkVal.length;i++){
			if(checkVal[i] != 'true'){
				$.ajax({
					type: 'GET',
					dataType: 'json',
					url: '../administrator/index.php?option=com_configurator&task=reset_database&format=raw&reset_type='+checkVal[i],
					success: function(data){
						if(data.error == ''){
							successmsg.push(data.success);
						}
						if(data.error != ''){
							errormsg.push(data.error);
						}
					}
				});
			}
		}
		
		setTimeout(function(){
			var msg;
			close_ptOverlay();
			if(successmsg.length == 1) msg = successmsg[0];
			if(successmsg.length == 2) msg = 'Your Configurator preferences and settings have been reset successfully.';
			
			$('.dialog-msg').html(msg);
			$('.dialog-msg').dialog('option', 'title', 'Success');
			$('.dialog-msg').dialog('option', 'buttons', {
				'OK': function(){
					$(this).dialog('destroy');
					ptOverlay('Reloading the management interface...');
					window.location.reload(true);
				}
			});
			$('.dialog-msg').dialog('open');
			return false;
		}, 3000);
		return false;
	}
	return false;
});