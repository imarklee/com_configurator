$('#custom-code').change(function(){
	if(!$.cookie('editor_changes')){
		$.cookie('editor_changes', 'true');
	}
});
$('#editor-list').change(function(ev){
	
	$this = $(this);
	if($this.val() == '' || $this.val() == 'undefined'){ return false; }
	
	// check for changes before switching
	if($.cookie('editor_changes') != 'true'){
		
		$('.CodeMirror-wrapping').fadeOut('500', function(){
			$(this).remove();
		});
		$('#custom-code').fadeOut();

		// kill duplication of the editor when switching files
		editor = undefined;
	
		var file_info = $this.val().split('/');
		var file_type = file_info[0];
		var parent_name = file_info[1];
		var filename = file_info[2];
	
		var xhr = $.ajax({
			url: '../administrator/index.php?option=com_configurator&format=raw&task=load_editor_file&file='+filename+'&type='+file_type+'&parent='+parent_name,
			success: function(data){
				$('#editor textarea').text(data);
				if(editor_highlighting == 0){
					$('#custom-code').fadeIn();
				}
				if(editor_highlighting == 1){
					switch(filename){
						case 'custom.js.php':
							setTimeout(function(){
								$('#select-info').hide();
								$('#editor .CodeMirror-wrapping').remove();
								editor = CodeMirror.fromTextArea('custom-code', { 
									content: textarea.value,
									onChange: function(){
										if(!$.cookie('editor_changes')){
											$.cookie('editor_changes', 'true');
										}
									},
									parserfile: ["tokenizejavascript.js", "parsejavascript.js"],
									stylesheet: "../administrator/components/com_configurator/css/codemirror/jscolors.css", 
									path: "../administrator/components/com_configurator/js/codemirror/" 
								});
							}, 1000);
						break;
						case 'custom.css.php':
							setTimeout(function(){
								$('#select-info').hide();
								$('#editor .CodeMirror-wrapping').remove();
								editor = CodeMirror.fromTextArea('custom-code', { 
									content: textarea.value,
									onChange: function(){
										if(!$.cookie('editor_changes')){
											$.cookie('editor_changes', 'true');
										}
									},
									parserfile: "parsecss.js", 
									stylesheet: "../administrator/components/com_configurator/css/codemirror/csscolors.css", 
									path: "../administrator/components/com_configurator/js/codemirror/" 
								});
							}, 1000);
						break;
						default:
							setTimeout(function(){
								$('#select-info').hide();
								$('#editor .CodeMirror-wrapping').remove();
								editor = CodeMirror.fromTextArea('custom-code', { 
									content: textarea.value,
									onChange: function(){
										if(!$.cookie('editor_changes')){
											$.cookie('editor_changes', 'true');
										}
									},
									parserfile: ["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js", "tokenizephp.js", "parsephp.js", "parsephphtmlmixed.js"],
							        stylesheet: ["../administrator/components/com_configurator/css/codemirror/xmlcolors.css", "../administrator/components/com_configurator/css/codemirror/jscolors.css", "../administrator/components/com_configurator/css/codemirror/csscolors.css", "../administrator/components/com_configurator/css/codemirror/phpcolors.css"],
									path: "../administrator/components/com_configurator/js/codemirror/"
								});
							}, 1000);
						break;
					}
				}
			}
		});
		// unbind click event to prevent onchange event duplicating the click when choosing the same file.
		$('.editor-controls a').unbind("click");
		$('.editor-controls a').bind("click", function(){
		
			$t = $(this);
			$.cookie('editor_changes', null);
			switch($(this).attr('action')){
				case 'save':
				case 'apply':
			
				$('#editor-notification img').attr('src', '../administrator/components/com_configurator/images/ajax-loader.gif')
				$('#editor-notification span').removeClass('error').html('saving');
				$('#editor-notification').fadeIn('fast');

				if(editor_highlighting == 1){
					var editor_contents = editor.getCode();
				}else{
					var editor_contents = $('#custom-code').val();
				}

				var xhr = $.ajax({
					url: '../administrator/index.php?option=com_configurator&task=save_editor_file&format=raw&file='+filename+'&type='+file_type+'&parent='+parent_name,
					type: 'POST',
					data: {
						'contents': editor_contents
					},
					success: function(data){					
						if(data == ''){
							$('#editor-notification img').attr('src', '../administrator/components/com_configurator/images/icon_success.gif')
							$('#editor-notification span').removeClass('error').html('saved successfully');
							setTimeout(function(){
								$('#editor-notification').fadeOut('fast');
								if($t.attr('action') == 'save'){
									$('#editor-list option[value=""]').attr('selected', true);
									if(editor_highlighting == 1){
										$('.CodeMirror-wrapping').fadeOut('500', function(){
											$(this).remove();
											$('#select-info').show(); 
										});
									}
									if(editor_highlighting == 0){
										$('#custom-code').fadeOut('500', function(){
											$('#select-info').show();
										});
									}
								}
							}, 1000);
						}else{
							$('#editor-notification img').attr('src', '../administrator/components/com_configurator/images/icon_error.gif')
							$('#editor-notification span').addClass('error').html('<strong>error</strong>: '+data);
						}
					}
				});
			
				break;
				case 'cancel':
				$('#editor-list option[value=""]').attr('selected', true);
				if(editor_highlighting == 1){
					$('.CodeMirror-wrapping').fadeOut('500', function(){
						$(this).remove();
						$('#select-info').show(); 
					});
				}
				if(editor_highlighting == 0){
					$('#custom-code').fadeOut('500', function(){
						$('#select-info').show();
					});
				}
				break;
			}
			return false;
		});
		return false;
	}else{
		
		$('body').append('<div id="editor-msg" class="dialog-msg">There are unsaved changes in current file. Are you sure you want to open a new file for editing?<br /><br />Press Cancel to review and save the changes, or press OK to discard the changes and change files.');
		$('#editor-msg').dialog({
			autoOpen: true,
			width: 300,
			modal: true,
			bgIframe: true,
			title: 'Warning',
			open: function(){
				hideScroll();
			},
			close: function(){
				$(this).dialog('destroy');
				showScroll();
			},
			buttons: {
				'OK': function(){
					$.cookie('editor_changes', null);
					$(this).dialog('close');
					$('#editor-list').trigger('change');
				},
				'Cancel': function(){
					$.cookie('editor_changes', null);
					$(this).dialog('close');
					$('#editor-list option[value=""]').attr('selected', 'selected');
				}
			}
		})
		return false;
		
	}
});