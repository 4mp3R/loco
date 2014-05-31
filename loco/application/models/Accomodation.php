<?php

class Application_Model_Accomodation {

    protected $_accomodationTypeModel;

    public function __construct(){

       $this->_accomodationTypeModel = new Application_Model_Resources_Accomodationtype();

    }



    public function getLatestAccomodations() {

    }

    public function searchAccomodations() {

    }

    public function getAccomodation() {

    }

    public function getTypes() {
        return $this->_accomodationTypeModel->getAllAccomodationType();
    }

    public function addAccomodation() {

    }

    public function updateAccomodation() {

    }

    public function deleteAccomodation() {

    }

    public function getInterestedLessees() {

    }

    public function assignLesseeForAccomodation() {

    }

}