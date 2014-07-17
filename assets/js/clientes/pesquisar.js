$(document).ready(function(){
	
	$("input[type='checkbox']").click(function(){
		
		$("#id_cliente",window.opener.document).val($(this).val());
		$("#razao_cliente",window.opener.document).val($(this).attr("razao"));
		window.close();
		
	});
	
});