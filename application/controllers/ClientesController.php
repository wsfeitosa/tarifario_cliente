<?php
class ClientesController extends Zend_Controller_Action {
	
	public function init()
	{
		
	}
	
	public function indexAction()
	{
		echo die("A��o inv�lida do controlador!");
	}
	
	public function pesquisarAction()
	{
		
		$razao_informada = $this->_getParam("razao");
		
		$cliente_model = new Application_Model_Cliente_Clientes();
		
		$rowSet = $cliente_model->fetchAll(
										$cliente_model->select("*")->
														where("razao LIKE ?","%".$razao_informada."%")->
														where("ativo = ?","S")
		);
		
		$this->view->clientes_encontrados = $rowSet;
		
		$this->render();
		
	}
	
}

