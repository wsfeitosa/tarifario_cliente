<?php
class Application_Model_Cliente_Clientes extends Zend_Db_Table_Abstract {
	
	protected $_name = 'CLIENTES.clientes';
	protected $_primary = 'id_cliente';
	protected $_dependentTables = array('cidade');
	
	public function init()
	{
	
	}
	
}
