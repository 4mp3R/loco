<?php

class Application_Model_Resources_Photo  extends Zend_Db_Table_Abstract {

    protected $_name = 'photo';
    protected $_primary = 'id';

    public function init() {

    }

    public function deletePhoto($id){
    $this->delete("id = $id");
    }

    public function addPhoto($dato) {
        $this->insert($dato);
    }

    public function getPhoto($id) {
        $this->find($id);
    }

    public function getPhotosForAccomodation($id) {
        $query = $this->select()->where("accomodation = '$id'");

        return $this->fetchAll($query);
    }

}
