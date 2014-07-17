<?php
class Application_Model_Tarifario_TarifarioPadrao extends Zend_Db_Table_Abstract {
	
	protected $_name = 'FINANCEIRO.tarifarios_pricing';
	protected $_primary = 'id_tarifario_pricing';
	protected $_dependentTables = array('tarifarios_taxas_pricing');
					
	public function init()
	{
		
	}
		
}
