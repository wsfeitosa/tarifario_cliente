$(document).ready(function(){

	$("#carregando").hide();
	$("#opcoes-tarifario-padrao").hide();
	$("#selecao-paises").hide();
	
	$( "#pais" ).autocomplete({
		
		source: "/Libs/autocompletar/pais.php",
		minLength: 3,
		select: function( event, ui ){

			$("#pais").val("");	
			$("#pais").text("");
			$("#paises_selecionados").append(new Option(ui.item.label, ui.item.id));

		}
	});

	$("#remover_pais").click(function(){
		
		$("#paises_selecionados option:selected").remove();
		
	});

	$("[name='opcao']").change(function(){

		if( $(this).attr("id") == "sob-consulta" )
		{
			$("#selecao-paises").show('slow');
		}
		else
		{
			$("#selecao-paises").hide('slow');
		}	

	});

	$("#tarifario_padrao").change(function(){
		
		if( $(this).is(":checked") )
		{
			$(this).val("S");
			$("#razao_cliente").attr("disabled","disabled");
			$("#razao_cliente").hide('slow');
			$("#label_cliente").hide('slow');	
			$("#razao_cliente").val("");
			$("#id_cliente").val("");
			$("#opcoes-tarifario-padrao").show('slow');		
		}
		else
		{
			$(this).val("N");
			$("#razao_cliente").attr("disabled",false);
			$("#razao_cliente").show('slow');
			$("#label_cliente").show('slow');
			$("#opcoes-tarifario-padrao").hide('slow');
			$("[name='opcao']").attr("checked",false);	
			$("#selecao-paises").hide('slow');		
		}	
			
	});	
	
	$("#razao_cliente").blur(function(){
						
		if( $(this).val() != "" )
		{
			abrir("/Clientes/tarifario/Relatorios/tarifario_cliente/index.php/Clientes/pesquisar/razao/"+$(this).val(),800,600);
		}	
		
	});
	
	$("#gerar").click(function(){
		
		/** Validação **/
		if( $("#tarifario_padrao").is(":checked") )
		{			
			if( $("#sentido").val() == "0" )
			{				
				alert("Selecione o sentido (IMP ou EXP)");
				return;
			}
			else
			{	
				$("#form1").hide('slow');
				$("#carregando").show('slow');	
				$("#form1").submit();
				return;
			}	
		}	
		
		var error = false;
		var msg = "";
		
		if( $("#id_cliente").val() == "" )
		{
			error = true;
			msg += "Selecione um cliente para gerar o tarifário\n";
		}
		
		if( $("#sentido").val() == "0" )
		{
			error = true;
			msg += "Selecione o sentido (IMP ou EXP)\n";
		}	
		
		if( error == true )
		{
			alert(msg);
			return false;
		}
		else
		{
			$("#form1").hide('slow');
			$("#carregando").show('slow');	
			$("#form1").submit();
		}	
		
	});
	
	$("#sair").click(function(){
		window.close();
	});
	
	function abrir(pagina,largura,altura) {

		//pega a resolução do visitante
		w = screen.width;
		h = screen.height;

		//divide a resolução por 2, obtendo o centro do monitor
		meio_w = w/2;
		meio_h = h/2;

		//diminui o valor da metade da resolução pelo tamanho da janela, fazendo com q ela fique centralizada
		altura2 = altura/2;
		largura2 = largura/2;
		meio1 = meio_h-altura2;
		meio2 = meio_w-largura2;

		//abre a nova janela, já com a sua devida posição
		window.open(pagina,'','height=' + altura + ', width=' + largura + ', top='+meio1+', left='+meio2+' ,scrollbars=yes, resizable=yes');
	}
	
});