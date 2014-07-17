<?php
set_time_limit(0);

include_once $_SERVER['DOCUMENT_ROOT'] . '/Gerais/autenticacao.php';

class TarifarioController extends Zend_Controller_Action {

	public function init()
	{

	}

	public function indexAction()
	{

	}

	public function redirecionarAction()
	{

		$id_cliente = $this->_getParam("id_cliente");
		$sentido = $this->_getParam("sentido");
		$tarifario_padrao = $this->_getParam("tarifario_padrao");
		$tipo_tarifario = $this->_getParam("tipo_tarifario");

		if( empty($id_cliente) )
		{
			$id_cliente = "0";
		}

		if( empty($tarifario_padrao) )
		{
			$tarifario_padrao = "N";
		}

		if( ! $tipo_tarifario || empty($tipo_tarifario) )
		{
			$tipo_tarifario = "0";
		}

		$this->view->id_cliente = $id_cliente;
		$this->view->sentido = $sentido;
		$this->view->tarifario_padrao = $tarifario_padrao;
		$this->view->tipo_tarifario = $tipo_tarifario;

		//$this->view->render();

	}

	public function gerarAction()
	{

		$id_cliente = $this->_getParam("id_cliente");
		$sentido = $this->_getParam("sentido");
		$tarifario_padrao = $this->_getParam("tarifario_padrao");
		$tipo_tarifario = $this->_getParam("tipo_tarifario");

		if( empty($id_cliente) )
		{
			$id_cliente = "0";
		}

		if( empty($tarifario_padrao) )
		{
			$tarifario_padrao = "N";
		}

		/**
		$facade = new Application_Model_ExportarTarifario($id_cliente,$sentido,$tarifario_padrao);

		$facade->exportarTarifario();
		**/
		if( $tipo_tarifario == "0" )
		{
			$file = system("python /var/www/html/python/scoa/Relatorios/tarifario_cliente/gerar_tarifario.py ".$id_cliente." ".$sentido." ".$tarifario_padrao." 0", $retval);
		}
		elseif( $tipo_tarifario == "2" )
		{
			$file = system("python /var/www/html/python/scoa/Relatorios/tarifario_cliente/gerar_tarifario_ods.pyc ".$id_cliente." ".$sentido." ".$tarifario_padrao." 0", $retval);
		}
		elseif($tipo_tarifario == "3")
		{
			$file = system("python /var/www/html/python/scoa/Relatorios/tarifario_cliente_wwa/gerar_tarifario_nao_principais.py ".$id_cliente." ".$sentido." ".$tarifario_padrao." 0", $retval);
		}
		elseif($tipo_tarifario == "4") 
		{
			$file = system("python /var/www/html/python/scoa/Relatorios/tarifario_cliente/gerar_tarifario.py ".$id_cliente." ".$sentido." ".$tarifario_padrao." 1", $retval);	
		}		
		else
		{
			$file = system("python /var/www/html/python/scoa/Relatorios/tarifario_cliente_wwa/gerar_tarifario.py ".$id_cliente." ".$sentido." ".$tarifario_padrao." 0", $retval);
		}

		echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
              <html>
                <head>
                    <title>Allink</title>
                </head>
                <body>
                    <script type='text/JavaScript'>
                    window.open('/relatorios_temp/".$file."','','height=300,width=200,left='+(screen.width-200)/2+',top='+(screen.height-300)/2+',scrollbars=yes,location=no,toolbar=no,menubar=no,resizeable=yes');
                    window.location = '/Clientes/tarifario/Relatorios/tarifario_cliente/index.php/Tarifario/';
                	</script>
                </body>
              </html>";
        exit(0);

	}

}
