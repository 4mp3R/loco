<?php

class Application_Model_Accomodation {

    protected $_accomodationModel;

    public function __construct(){

       $this->_accomodationModel = new Application_Model_Resources_Accomodation();

    }

    public function getLatestAccomodation() {

    }

    public function searchAccomodation() {

    }

    public function getAccomodation() {
        return $this->_accomodationeModel->getAccomodation($id);
    }

    public function getTypes() {
        return $this->_accomodationTypeModel->getAllAccomodationType();
    }

    public function addAccomodation() {
        return $this->_accomodationModel->addAccomodation($data);
    }

    public function updateAccomodation() {
        return $this->_accomodationModel->updateAccomodation($id ,$datiaggiornati);
    }

    public function deleteAccomodation() {
        return $this->_accomodationModel->deleteAccomodation($id);
    }

    public function getInterestedLessees() {

    }

    public function assignLesseeForAccomodation() {

    }

    public function getAccomodationByFee(){
        return $this->_accomodationeModel->getAccomodationByFee($fee);
    }

    public function getAccomodationByProfile(){
        return $this->_accomodationeModel->getAccomodationByProfile($lessor);
    }

}