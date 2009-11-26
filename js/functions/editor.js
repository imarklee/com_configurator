$('#file-editor a.view-file').click(function(){
	$this = $(this);
	$('#file-editor-window').remove();
	$('body').append('<div id="file-editor-window"><textarea></textarea></div>');
	//$('#file-editor-window').load(function(){
		$.ajax({
			url: '../administrator/index.php?option=com_configurator&format=raw&task=load_editor_file&file='+$this.attr('file')+'&type='+$this.attr('type')+'&parent='+$this.attr('parent'),
			success: function(data){
				$('#file-editor-window textarea').text(data);
			}
		});
	//});
	$('#file-editor-window').dialog({
		autoOpen: true,
		modal: true,
		bgiframe: true,
		width: 800,
		height: 600,
		open: function(){
			hideScroll();
		},
		close: function(){
			showScroll();
			$(this).dialog('destroy');
		}
	});
	return false;
});