<?php

class Application_Model_Resources_AccomodationFeature  extends Zend_Db_Table_Abstract {

    protected $_name = 'Accomodationfeature';
    protected $_primary = 'id';

    public function init() {

    }

    public function getAllAccomodationfeature() {
        $query = $this->select('*');
        return $this->fetchAll($query);
    }

    public function getAccomodationfeature($id) {
        return $this->find($id);
    }

    public function addAccomodationfeature($dati) {
        $this->insert($dati);
    }

    public function updateAccomodationfeature($id , $datiaggiornati ) {
        $this->update($datiaggiornati, "id = '$id'");
    }

    public function deleteAccomodationfeature($id) {
        $this->delete("id = '$id");
    }


}