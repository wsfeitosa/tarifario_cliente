<?php
class Application_Model_Tarifario_TaxasTarifario extends Zend_Db_Table_Abstract {
	
	protected $_name = 'FINANCEIRO.tarifarios_taxas_pricing';
	protected $_primary = 'id_tarifario_taxa_pricing';
	protected $_referenceMap = array(
			'tarifarios_pricing' => array(
					'columns' => 'id_tarifario_pricing',  // the column in the 'videos' table which is used for the join
					'refTableClass' => 'Application_Model_Tarifario_TarifarioPadrao',  // the users table name
					'refColumns' => 'id_tarifario_pricing' // the primary key of the users table
			)
	);	
			
	public function init()
	{
		
	}
	
}

