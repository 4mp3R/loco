<?php

class Application_Model_Accomodation {

    protected $_accomodationModel;
    protected $_accomodationFeatureModel;
    protected $_accomodationDataModel;
    protected $_accomodationTypeModel;
    protected $_photoModel;
    protected $_optionModel;

    public function __construct(){
        $this->_accomodationModel = new Application_Model_Resources_Accomodation();
        $this->_accomodationFeatureModel = new Application_Model_Resources_Accomodationfeature();
        $this->_accomodationDataModel = new Application_Model_Resources_Accomodationdata();
        $this->_accomodationTypeModel = new Application_Model_Resources_Accomodationtype();
        $this->_photoModel = new Application_Model_Resources_Photo();
        $this->_optionModel = new Application_Model_Resources_Option();
    }

    public function getAllAccomodations() {
        return $this->_accomodationModel->getAllAccomodations();
    }

    public function getLatestAccomodations($n) {
        return  $this->_accomodationModel->getLatestAccomodations($n);
    }

    public function getPhotosForAccomodation($id) {
        return $this->_photoModel->getPhotosForAccomodation($id);
    }

    public function getAccomodationFullInfo($id) {
        return $this->_accomodationModel->getAccomodationFullInfo($id);
    }

    public function getAccomodationsByIntervalAndType($from, $to, $type_id) {
        return $this->_accomodationModel->getAccomodationsByIntervalAndType($from, $to, $type_id);
    }

    public function getOptionsByIntervalAndType($from, $to, $type_id = null) {
        $optionsByInterval = $this->_optionModel->getOptionsByInterval($from, $to);

        $options = array();

        foreach($optionsByInterval as $o) {
            $accomodation = $this->_accomodationModel->getAccomodation($o->accomodation);

            if((null == $type_id) || (null != $type_id && $type_id == $accomodation[0]->type))
                $options[] = array('option' => $o, 'accomodation' => $this->_accomodationModel->getAccomodation($o->accomodation));
        }

        return $options;
    }

    public function getOption($username, $accomodation) {
        return $this->_optionModel->getOption($username, $accomodation);
    }

    public function setOption($username, $accomodation) {
        $this->_optionModel->setOption($username, $accomodation);
    }

    public function unsetOption($username, $accomodation) {
        $this->_optionModel->unsetOption($username, $accomodation);
    }

    public function searchAccomodation() {

    }

    public function getAccomodation($id) {
        return $this->_accomodationModel->getAccomodation($id);
    }

    public function getAccType($id) {
        return $this->_accomodationTypeModel->getAccomodationType($id);
    }

    public function getTypes() {
        return $this->_accomodationTypeModel->getAllAccomodationType();
    }

    public function addAccomodation($data) {
        return $this->_accomodationModel->addAccomodation($data);
    }

    public function updateAccomodation($id ,$datiaggiornati) {
        return $this->_accomodationModel->updateAccomodation($id ,$datiaggiornati);
    }

    public function deleteAccomodation($id) {
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


    public function getAccomodationfeature() {
        return $this->_accomodationfeatureModel->getAccomodationfeature($id);
    }


    public function addAccomodationfeature() {
        return $this->_accomodationfeatureModel->addAccomodationfeature($dati);
    }

    public function updateAccomodationfeature() {
        return $this->_accomodationfeatureModel->updateAccomodationfeature($id ,$datiaggiornati);
    }

    public function deleteAccomodationfeature() {
        return $this->_accomodationfeatureModel->deleteAccomodationfeature($id);
    }

    public function getAccomodationtype() {
        return $this->_accomodationtypeModel->getAccomodationtype($id);
    }


    public function addAccomodationtype() {
        return $this->_accomodationtypeModel->addAccomodationtype($dati);
    }

    public function updateAccomodationtype() {
        return $this->_accomodationtypeModel->updateAccomodationtype($id ,$datiaggiornati);
    }

    public function deleteAccomodationtype() {
        return $this->_accomodationtypeModel->deleteAccomodationtype($id);
    }

}