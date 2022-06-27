var url = window.location.origin;

if (!url) {
	url = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');
}

jQuery(document).ready(function(){
	 
	
	$("#btnReset").click(function(){
	
		$('#name').val("");
		$('#email').val("");
		$(this).closest('form').submit();
    });
	
});