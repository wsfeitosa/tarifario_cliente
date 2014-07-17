<?php
class Application_Model_ExportarTarifario {
	
	protected $id_cliente = NULL;
	protected $sentido = NULL;
	protected $padrao = NULL;
	
	public function __construct($id_cliente,$sentido,$padrao)
	{
		$this->id_cliente = $id_cliente;
		$this->sentido = $sentido;
		$this->padrao = $padrao;
	}
	
	public function exportarTarifario()
	{
		$excel = new Application_Model_Excel_GerarExcel();
		$tarifario = new Application_Model_Tarifario_TarifarioPadrao();

		$rowSet = $tarifario->fetchAll(
										$tarifario->select("*")->where("ativo = ?","S")->where("modulo = ?",$this->sentido)
		);
		
		//TODO aqui farei a regra para buscar e sobrescrever os valores do tarifário quando um cliente for informado
		if( $this->padrao == "S" )
		{
			$excel->GerarExcel($rowSet);
		}
		else 
		{
			//TODO Buscar o cliente
		}		
						
	}
	
}

