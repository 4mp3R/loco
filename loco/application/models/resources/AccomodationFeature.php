<?php

class Application_Model_Resources_Accomodationfeature  extends Zend_Db_Table_Abstract {

    protected $_name = 'accomodation_feature';
    protected $_primary = 'id';

    public function init() {

    }

    public function getAccomodationeatures($type) {
        $q = $this->select()->where("type = '$type'");

        return $this->fetchAll($q);
    }

    public function getAccomodationfeature($id) {
        return $this->find($id);
    }

    public function addAccomodationfeature($data) {
        return $this->insert($data);
    }

    public function updateAccomodationfeature($data) {
        $id = $data['id'];

        return $this->update($data, "id = '$id'");
    }

    public function deleteAccomodationfeature($id) {
        $this->delete("id = '$id");
    }


}