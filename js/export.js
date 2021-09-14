$( document ).ready(function() {
	$(".dataExport").click(function() {
		var exportType = $(this).data('type');	
		var fileName = $(this).data('filename');	
		$('#dataTable').tableExport({
			type : exportType,	
			tableName : fileName,	
			escape : 'false',
			ignoreColumn: []
		});		
	});
});


