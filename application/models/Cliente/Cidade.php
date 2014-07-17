<?php
class Application_Model_Cliente_Cidade extends Zend_Db_Table_Abstract {
	
	protected $_name = 'CLIENTES.cidade';
	protected $_primary = 'id_cidade';
	protected $_referenceMap = array(
			'cidade' => array(
					'columns' => 'id_cidade',  // chave primaria da tabela
					'refTableClass' => 'Application_Model_Cliente_Clientes',  // model que ser� criada a rela��o
					'refColumns' => 'cidade' // chave estrangeira
			)
	);
	
	public function init()
	{
	
	}
	
}
