<?php

class Application_Model_Resources_Accomodation extends Zend_Db_Table_Abstract {

    protected $_name = 'accomodation';
    protected $_primary = 'id';

    public function getAccomodationByProfile($lessor) {
        $query = $this->select()
                      ->where("lessor = '$lessor'");

        return $this->fetchAll($query);
    }


    public function updateAccomodation($id , $datiaggiornati ) {
        $this->update($datiaggiornati, "id = '$id''");
    }

    public function getAccomodation($id) {
        return $this->find($id);
    }

    public function addAccomodation($data) {
        $this->insert($data);
    }

    public function deleteAccomodation($id) {
        $this->delete("id = '$id''");
    }

    public function getAccomodationByFee($fee){
        $dato = $this->select()
                      ->where("fee = '$fee'");
    }
}