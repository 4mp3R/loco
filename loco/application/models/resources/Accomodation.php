<?php

class Application_Model_Resources_Accomodation extends Zend_Db_Table_Abstract {

    protected $_name = 'accomodation';
    protected $_primary = 'id';

    public function getAllAccomodations() {
        $query = $this->select();

        return $this->fetchAll($query);
    }

    public function getAccomodationByProfile($lesser) {
        $query = $this->select()
                      ->where("lesser = '$lesser'");

        return $this->fetchAll($query);
    }

    public function getLatestAccomodations($n) {
        $query = $this->select()->order('id DESC')->limit($n);

        return $this->fetchAll($query);
    }

    public function getAccomodationFullInfo($id) {
        $stmt = $this->getDefaultAdapter()->query("select * from accomodation a join accomodation_type t on a.type=t.id join accomodation_feature f on t.id=f.type join accomodation_data d on f.id=feature_id where a.id='$id'");
        return $stmt->fetchAll();
    }

    public function getAccomodationsByIntervalAndType($from, $to, $type_id) {
        $query = $this->select();

        if(null != $from && null != $to)
            $query->where("created >= '$from' and created <= '$to'");

        if(null != $type_id)
            $query->where("type = '$type_id'");

        return $this->fetchAll($query);
    }

    public function getAccomodationByType($type_id) {
        $q = $this->select();

        if(null != type)
            $q->where("type = '$type_id'");

        return $this->fetchAll($q);
    }

    public function updateAccomodation($id , $datiaggiornati ) {
        $this->update($datiaggiornati, "id = '$id'");
    }

    public function getAccomodation($id) {
        return $this->find($id);
    }

    public function addAccomodation($data) {
        $this->insert($data);
    }

    public function lastInserId() {
        return $this->getAdapter()->lastInsertId('accomodation');
    }

    public function deleteAccomodation($id) {
        $this->delete("id = '$id'");
    }

    public function getAccomodationByFee($fee){
        $dato=$this->select()
                      ->where("fee = '$fee'");
    }
}