<?php

class Application_Model_Resources_Accomodationfeature  extends Zend_Db_Table_Abstract {

    protected $_name = 'accomodation_feature';
    protected $_primary = 'id';

    public function init() {

    }

    public function getAccomodationfeatures($type) {
        return $this->select()->where("type = '$type'");
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