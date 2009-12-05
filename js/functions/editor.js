$('#editor-list').change(function(ev){
	if(xhr) { xhr.abort(); }
	editor = undefined;
	
	$this = $(this);
	if($this.val() == '' || $this.val() == 'undefined'){ return false; }
	
	var file_info = $this.val().split('/');
	var file_type = file_info[0];
	var parent_name = file_info[1];
	var filename = file_info[2];
	
	$.cookie('editor', filename);
	
	var xhr = $.ajax({
		url: '../administrator/index.php?option=com_configurator&format=raw&task=load_editor_file&file='+filename+'&type='+file_type+'&parent='+parent_name,
		success: function(data){
			$('#editor textarea').text(data);
			switch(filename){
				case 'custom.js.php':
					setTimeout(function(){
						$('#select-info').hide();
						$('#editor .CodeMirror-wrapping').remove();
						editor = CodeMirror.fromTextArea('custom-code', { 
							content: textarea.value,
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
							parserfile: ["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js", "tokenizephp.js", "parsephp.js", "parsephphtmlmixed.js"],
					        stylesheet: ["../administrator/components/com_configurator/css/codemirror/xmlcolors.css", "../administrator/components/com_configurator/css/codemirror/jscolors.css", "../administrator/components/com_configurator/css/codemirror/csscolors.css", "../administrator/components/com_configurator/css/codemirror/phpcolors.css"],
							path: "../administrator/components/com_configurator/js/codemirror/"
						});
					}, 1000);
				break;
			}
		}
	});
	
	$('.editor-controls a').click(function(){
		if(xhr) { xhr.abort(); }
		if(filename !== $.cookie('editor')) { return false; }

		$t = $(this);		
		switch($(this).attr('action')){
			case 'save':
			case 'apply':
			
			$('#editor-notification img').attr('src', '../administrator/components/com_configurator/images/ajax-loader.gif')
			$('#editor-notification span').removeClass('error').html('saving');
			$('#editor-notification').fadeIn('fast');

			var xhr = $.ajax({
				url: '../administrator/index.php?option=com_configurator&task=save_editor_file&format=raw&file='+filename+'&type='+file_type+'&parent='+parent_name,
				type: 'POST',
				data: {
					'contents': editor.getCode()
				},
				success: function(data){
					if(data == ''){
						$('#editor-notification img').attr('src', '../administrator/components/com_configurator/images/icon_success.gif')
						$('#editor-notification span').removeClass('error').html('saved successfully');
						setTimeout(function(){
							$('#editor-notification').fadeOut('fast');
							if($t.attr('action') == 'apply'){
								$('#editor-list option[value=""]').attr('selected', true);
								$('.CodeMirror-wrapping').remove();
								$('#select-info').show();
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
			$('.CodeMirror-wrapping').remove();
			$('#select-info').show(); 
			break;
		}
		return false;
	});
	ev.preventDefault();
	return false;
});