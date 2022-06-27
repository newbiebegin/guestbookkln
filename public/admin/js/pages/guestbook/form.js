var url = window.location.origin;

if (!url) {
	url = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');
}

jQuery(document).ready(function(){
	 
	$('a[data-toggle=modal], button[data-toggle=modal]').click(function () {

		var dataId = '';
		var dataType = '';

		if (typeof $(this).data('id') !== 'undefined') {

			dataId = $(this).data('id');
		}
		if (typeof $(this).data('type') !== 'undefined') {
			dataType = $(this).data('type');
		}
		
		$('#formModalConfirm').attr('action', $(this).attr("href"));
	
		$('#formMethod').html('<input type="hidden" name="_method" value="'+dataType+'">');
		
	
		$('#txtKey').val(dataId);
	})
  
	$("#modalConfirmDeleteBtnYes").click(function (e) {
		
		var data_id = $('#txtKey').val();

		$('#formModalConfirm').submit();	
		$('#modal-confirm').modal('hide');
	});
	
	$("#btnReset").click(function(){
	
		$('#first_name').val("");
		$('#last_name').val("");
		$('#organization').val("");
		$('#address').val("");
		$('#province_id').val("");
		$('#city_id').val("");
		$('#phone').val("");
		$('#message').val("");
		$('#is_active').val("");
		$(this).closest('form').submit();
    });
	
});