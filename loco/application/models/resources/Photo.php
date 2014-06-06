<?php

class Application_Model_Resources_Photo  extends Zend_Db_Table_Abstract {

    protected $_name = 'photo';
    protected $_primary = 'id';

    public function init() {

    }

    public function deletePhoto($id){
        return $this->delete("id = $id");
    }

    public function addPhoto($data) {
        return $this->insert($data);
    }

    public function getPhoto($id) {
        return $this->find($id);
    }

    public function getPhotosForAccomodation($id) {
        $query = $this->select()->where("accomodation = '$id'");

        return $this->fetchAll($query);
    }

}
