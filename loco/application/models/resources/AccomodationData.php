<?php

class Application_Model_Resources_Accomodationdata  extends Zend_Db_Table_Abstract {

    protected $_name = 'accomodation_data';
    protected $_primary = 'id';

    public function init() {

    }


    public function getAccomodationdata($accomodation_id) {
        $q = $this->select()->where("accomodation = '$accomodation_id'");
        return $this->fetchAll($q);
    }

    public function addAccomodationdata($dati) {
        return $this->insert($dati);
    }

    public function updateAccomodationdata($accomodation, $feature_id, $data) {
        $this->update($data, "accomodation = '$accomodation' and feature_id = '$feature_id'");
    }

    public function deleteAccomodationdata($accomodation_id) {
        $this->delete("accomodation = '$accomodation_id'");
    }


}