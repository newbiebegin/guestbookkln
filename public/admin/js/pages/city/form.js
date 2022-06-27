var url = window.location.origin;

if (!url) {
	url = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');
}

jQuery(document).ready(function(){
	 
	function checkDuplicateInput(inType='name'){
		
		var inputName = '#'+inType;
		var formId = $(inputName).closest('form').attr('id');
		
		if(formId == 'formEdit' || formId == 'formCreate')
		{
			key = $('#formEdit').attr('data-key');
			
			var ajaxData = {
								key : key,
							};

			if (inType == 'name')
			{
				ajaxData.name = $(inputName).val();
			}				
			else if (inType == 'code')
			{
				ajaxData.code = $(inputName).val();
			}				

			$(inputName).removeClass('is-invalid');
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
				}
			});
			
			$.ajax({
				url: url+'/admin/cities/check_' + inType,
				method: 'post',
				dataType: 'json', 
				data: ajaxData,
				cache: false,
				async: false,
				// processData: false,
				// contentType: false,
				success:function(result)
				{
					console.log(result);
				},
				statusCode: {
					500: function() {
						// Server error
						console.log('Server error');
					},
				},
				error:function(errors){
					
					console.log(errors);
					
					var resErrors = $.parseJSON(errors.responseText);
					
					msgErrors = resErrors.message;
					
					$.each(msgErrors, function (key, val) {
					
						if(key=='name' || key=='code')
						{
							$(inputName).addClass('is-invalid');
						
							if ($(inputName +'-error').length == 0){
								if(key=='name'){
									$(inputName).after('<span id="name-error" class="error invalid-feedback"></span>');
								}
								else if(key=='code'){
									$('#code').after('<span id="code-error" class="error invalid-feedback"></span>');
								}
							}
							
							$(inputName+'-error').html(val);
						}
						
					});
				},
			
			});
		}
	}
	 
	$('#name').keyup(function(){
		
		checkDuplicateInput('name');
	});
	
	$('#code').keyup(function(){
		
		checkDuplicateInput('code');
	});
	
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
	
		$('#name').val("");
		$('#code').val("");
		$('#is_active').val("");
		$(this).closest('form').submit();
    });
	
	$("#btnImport").click(function(){
		 document.location.href = url + '/admin/cities/import';
    });
});