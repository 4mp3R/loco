<?php

class Application_Model_Resources_Accomodation extends Zend_Db_Table_Abstract {

    protected $_name = 'accomodation';
    protected $_primary = 'id';

    public function getAccomodationByProfile($lessor) {
        $query = $this->select()
                      ->where("lessor = '$lessor'");

        return $this->fetchAll($query);
    }

    public function getLatestAccomodations($n) {
        $query = $this->select()->order('id DESC')->limit($n);

        return $this->fetchAll($query);
    }

    public function getAccomodationFullInfo($id) {
        $query = "select * from accomodation a join accomodation_type t on a.type=t.id join accomodation_feature f on t.id=f.type join accomodation_data d on f.id=feature_id where a.id='$id'";

        $query = $this->select()->from(array('a' => 'accomodation'))
            ->join(array('t' => 'accomodation_type'), 'a.type=t.id', array())
            ->join(array('f' => 'accomodation_feature'), 't.id=f.type', array())
            ->join(array('d' => 'accomodation_data'), 'f.id=d.feature_id', array())
            ->where("a.id = 'id'");

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
        $dato=$this->select()
                      ->where("fee = '$fee'");
    }
}