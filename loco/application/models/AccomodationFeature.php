<?php

class Application_Model_Accomodationfeature {

    protected $_accomodationfeatureModel;

    public function __construct(){

        $this->_accomodationfeatureModel = new Application_Model_Resources_Accomodationfeature();

    }

    public function getAccomodationfeature() {
        return $this->_accomodationfeatureModel->getAccomodationfeature($id);
    }


    public function addAccomodationfeature() {
        return $this->_accomodationfeatureModel->addAccomodationfeature($dati);
    }

    public function updateAccomodationfeature() {
        return $this->_accomodationfeatureModel->updateAccomodationfeature($id ,$datiaggiornati);
    }

    public function deleteAccomodationdata() {
        return $this->_accomodationfeatureModel->deleteAccomodationfeature($id);
    }



}