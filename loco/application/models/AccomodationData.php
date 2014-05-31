<?php

class Application_Model_Accomodationdata {

    protected $_accomodationdataModel;

    public function __construct(){

        $this->_accomodationdataModel = new Application_Model_Resources_Accomodationdata();

    }

    public function getAccomodationdata() {
        return $this->_accomodationdataModel->getAccomodationdata($id);
    }


    public function addAccomodationdata() {
        return $this->_accomodationdataModel->addAccomodationdata($dati);
    }

    public function updateAccomodationdata() {
        return $this->_accomodationdataModel->updateAccomodationdata($id ,$datiaggiornati);
    }

    public function deleteAccomodationdata() {
        return $this->_accomodationdataModel->deleteAccomodationdata($id);
    }



}