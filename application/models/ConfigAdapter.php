<?php

class Application_Model_ConfigAdapter {

	public function getAdapter()
	{
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini','production');

		$dbConfig = Array(
							"host" => 'localhost',
							"username" => $config->resources->db->params->username,
							"password" => $config->resources->db->params->password,
							"dbname" => $config->resources->db->params->dbname
					);
				
		return $db = Zend_Db::factory("Pdo_Mysql",$dbConfig);
	}

}