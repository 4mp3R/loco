<?php

class Application_Model_Resources_Accomodationtype  extends Zend_Db_Table_Abstract {

    protected $_name = 'accomodationtype';
    protected $_primary = 'id';

    public function init() {

    }

    public function getAllAccomodationType() {
        $query = $this->select('*');
        return $this->fetchAll($query);
    }

    public function getAccomodationType($id) {
        return $this->find($id);
    }

    public function addAccomodationType($dati) {
        $this->insert($dati);
    }

    public function updateAccomodationType($id , $datiaggiornati ) {
        $this->update($datiaggiornati, "id = '$id'");
    }

    public function deleteAccomodationType($id) {
        $this->delete("id = '$id");
    }


}