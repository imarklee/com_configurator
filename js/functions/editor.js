$('#file-editor a.view-file').click(function(){ return false; });
$('#file-editor a.view-file').click(function(){
	$this = $(this);
	$('#file-editor-window').remove();
	$('body').append('<div id="file-editor-window">'+
			'<div id="editor-toolbar">'+
				'<div id="editor-controls">'+
					'<a href="#" class="btn-link save">Save</a>'+
					'<a href="#" class="btn-link apply">Apply</a>'+
					'<a href="#" class="btn-link close">Close</a>'+
				'</div>'+
				'<div id="editor-notification"><span>saving</span><img src="../administrator/components/com_configurator/images/ajax-loader.gif" height="31" width="31" /></div>'+
			'</div>'+
			'<textarea id="custom-code"></textarea>'+
		'</div>');
	//$('#file-editor-window').load(function(){
		$.ajax({
			url: '../administrator/index.php?option=com_configurator&format=raw&task=load_editor_file&file='+$this.attr('file')+'&type='+$this.attr('type')+'&parent='+$this.attr('parent'),
			success: function(data){
				$('#file-editor-window #custom-code').text(data);
			}
		});
	//});
	
	$('#file-editor-window').dialog({
		autoOpen: true,
		modal: true,
		bgiframe: true,
		width: 800,
		height: 600,
		title: 'File Editor: Editing '+$this.attr('file'),
		open: function(){
			hideScroll();
			var editor_height = "500px";
			switch($this.attr('file')){
				case 'custom.js.php':
					setTimeout(function(){
						var editor = CodeMirror.fromTextArea('custom-code', { 
							height: editor_height,
							content: textarea.value,
							parserfile: ["tokenizejavascript.js", "parsejavascript.js"],
							stylesheet: "../administrator/components/com_configurator/css/codemirror/jscolors.css", 
							path: "../administrator/components/com_configurator/js/codemirror/" 
						});
					}, 1000);
				break;
				case 'custom.css.php':
					setTimeout(function(){
						var editor = CodeMirror.fromTextArea('custom-code', { 
							height: editor_height,
							content: textarea.value,
							parserfile: "parsecss.js", 
							stylesheet: "../administrator/components/com_configurator/css/codemirror/csscolors.css", 
							path: "../administrator/components/com_configurator/js/codemirror/" 
						});
					}, 1000);
				break;
				default:
					setTimeout(function(){
						var editor = CodeMirror.fromTextArea('custom-code', { 
							height: editor_height,
							content: textarea.value,
							parserfile: ["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js", "tokenizephp.js", "parsephp.js", "parsephphtmlmixed.js"],
					        stylesheet: ["../administrator/components/com_configurator/css/codemirror/xmlcolors.css", "../administrator/components/com_configurator/css/codemirror/jscolors.css", "../administrator/components/com_configurator/css/codemirror/csscolors.css", "../administrator/components/com_configurator/css/codemirror/phpcolors.css"],
							path: "../administrator/components/com_configurator/js/codemirror/"
						});
					}, 1000);
				break;
			} 
		},
		close: function(){
			showScroll();
			$(this).dialog('destroy');
		}
	});
	return false;
});