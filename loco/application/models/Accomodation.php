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

    public function getAllAccomodations($page = null) {
        return $this->_accomodationModel->getAllAccomodations($page);
    }

    public function getLatestAccomodations($n) {
        return  $this->_accomodationModel->getLatestAccomodations($n);
    }

    public function getPhotosForAccomodation($id) {
        return $this->_photoModel->getPhotosForAccomodation($id);
    }

    public function getPhoto($id) {
        return $this->_photoModel->getPhoto($id);
    }

    public function addPhotoForAccomodation($accomodation, $photo) {

        $data = array('accomodation' => $accomodation, 'photo' => $photo);
        return $this->_photoModel->addPhoto($data);
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

    public function getCount() {
        return $this->_accomodationModel->getCount();
    }

    public function getOptionsByAccomodation($accomodation) {
        return $this->_optionModel->getOptionsByAccomodation($accomodation);
    }

    public function getOptionsByUsername($username) {
        return $this->_optionModel->getOptionsByUsername($username);
    }

    public function setOption($username, $accomodation) {
        $this->_optionModel->setOption($username, $accomodation);
    }

    public function unsetOption($username, $accomodation) {
        $this->_optionModel->unsetOption($username, $accomodation);
    }

    public function addAccomodation($data) {
        return $this->_accomodationModel->addAccomodation($data);
    }

    public function getAccomodationType($type_id) {
        return $this->_accomodationTypeModel->getAccomodationType($type_id);
    }

    public function addAccomodationdata($data) {
        return $this->_accomodationDataModel->addAccomodationdata($data);
    }

    public function accomodationLastInsertId() {
        return $this->_accomodationModel->lastInserId();
    }

    public function getAccomodationByProfile($lesser){
        return $this->_accomodationModel->getAccomodationByProfile($lesser);
    }

    public function getAccomodationfeature($id) {
        return $this->_accomodationFeatureModel->getAccomodationfeature($id);
    }

    public function updateAccomodationdata($accomodation, $feature_id, $data) {
        return $this->_accomodationDataModel->updateAccomodationdata($accomodation, $feature_id ,$data);
    }

    public function deleteAccomodationPhoto($photo_id) {
        return $this->_photoModel->deletePhoto($photo_id);
    }

    public function deleteAccomodationdata($id) {
        return $this->_accomodationDataModel->deleteAccomodationdata($id);
    }

    public function deleteAccomodationPhotos($accomodaion_id) {
        return $this->_photoModel->deletePhotos($accomodaion_id);
    }

    public function accomodationTypeLastInsertedId() {
        return $this->_accomodationTypeModel->lastInsertedId();
    }

    public function searchGenericAccomodation($data, $page = null) {
        return $this->_accomodationModel->searchGenericAccomodation($data, $page);
    }

    public function getDataByAccomodationAndFeature($accomodation_id, $accomodation_feature) {
        return $this->_accomodationDataModel->getDataByAccomodationAndFeature($accomodation_id, $accomodation_feature);
    }

    public function getLocatedAccomodations() {
        return $this->_accomodationModel->getLocatedAccomodations();
    }

    public function getLocatedByIntervalAndType($from, $to, $type_id) {
        return $this->_accomodationModel->getLocatedByIntervalAndType($from, $to, $type_id);
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

    public function addAccomodationType($data) {
        return $this->_accomodationTypeModel->addAccomodationType($data);
    }

    public function updateAccomodation($id ,$datiaggiornati) {
        return $this->_accomodationModel->updateAccomodation($id ,$datiaggiornati);
    }

    public function deleteAccomodation($id) {
        return $this->_accomodationModel->deleteAccomodation($id);
    }

    public function getFeaturesByType($type_id) {
        return $this->_accomodationFeatureModel->getAccomodationeatures($type_id);
    }

    public function addFeature($data) {
        return $this->_accomodationFeatureModel->addAccomodationfeature($data);
    }

    public function updateFeature($data) {
        return $this->_accomodationFeatureModel->updateAccomodationfeature($data);
    }

    public function getAccomodationdata($accomodation_id) {
        return $this->_accomodationDataModel->getAccomodationdata($accomodation_id);
    }

    public function deleteAccomodationtype($id) {
        $features = $this->_accomodationFeatureModel->getAccomodationeatures($id);
        $accomodations = $this->_accomodationModel->getAccomodationByType($id);

        $data = array();
        foreach($features as $f){
            $data[] = $this->_accomodationDataModel->getDataByFeature($f->id);
        }


        $photos = array();
        foreach($accomodations as $a)
            $photos[] = $this->_photoModel->getPhotosForAccomodation($a->id);

        //delete data
        foreach($data as $d) {}
            foreach($d as $data)
                $this->_accomodationDataModel->deleteData($data->id);

        //delate features
        foreach($features as $f)
            $this->_accomodationFeatureModel->deleteAccomodationfeature($f->id);

        //delete photos
        foreach($photos as $p)
            foreach($p as $photo)
                $this->_photoModel->deletePhoto($photo->id);

        //delete type
        $this->_accomodationTypeModel->deleteAccomodationtype($id);

        //delete accomodations
        foreach($accomodations as $a)
            $this->_accomodationModel->deleteAccomodation($a->id);

        return;
    }

}