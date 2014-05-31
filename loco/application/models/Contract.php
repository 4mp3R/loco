<?php

class Application_Model_Contract {

    protected $_contractModel;

    public function __construct(){

        $this->_contractModel = new Application_Model_Resources_Contract();

    }

    public function getContract(){
        return $this->_contractModel->getContract($id);
    }

    public function updateContract(){
        return $this->_contractModel->updateContract($id ,$datiaggiornati);
    }

    public function addContract(){
        return $this->_contractModel->addContract($data);
    }

    public function deleteContract(){
        return $this->_contractModel->deleteContract($id);
    }

}