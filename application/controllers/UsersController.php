<?php

class UsersController extends Zend_Controller_Action{

	protected $db = NULL;

	public function init()
    {
        $adapter = new Application_Model_ConfigAdapter();
        $this->db = $adapter->getAdapter();
    }

    public function indexAction()
    {   	

    		
    }

    public function fetchAction()
    {
    	
    	try{

    		$sql = $this->db->select("*")->from("USUARIOS.usuarios")->where("id_user = ?", $this->_getParam('user_id'));

    		$rs = $this->db->fetchRow($sql);

    		//print"<pre>";var_dump($rs);print"</pre>";

    		$this->view->name = $rs['nome'];
    		$this->view->login = $rs['usuario'];
    		$this->view->pass = $rs['senha'];
    		$this->view->last_name = $rs['apelido'];
    		$this->view->position = $rs['cargo'];

    		$this->render();

    	} catch (Zend_Db_Adapter_Exception $e) {
			echo $e->getMessage();die();
		}
    }

}