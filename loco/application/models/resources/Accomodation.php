<?php

class Application_Model_Resources_Accomodation extends Zend_Db_Table_Abstract {

    protected $_name = 'accomodation';
    protected $_primary = 'id';

    public function getAllAccomodations($page = null) {
        $query = $this->select();

        if(null != $page) {
            $adapter = new Zend_Paginator_Adapter_DbTableSelect($query);
            $paginator = new Zend_Paginator($adapter);
            $paginator->setItemCountPerPage(2);
            $paginator->setCurrentPageNumber($page);

            return $paginator;
        } else return $this->fetchAll($query);
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
        $stmt = $this->getDefaultAdapter()->query("select * from accomodation a join accomodation_type t on a.type=t.id join accomodation_feature f on t.id=f.type join accomodation_data d on (f.id=d.feature_id and a.id=d.accomodation) where a.id='$id'");
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

        if(null != $type_id)
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

    public function searchGenericAccomodation($data) {
        $q = $this->select();

        if($data['keywords'] != null) {
            $words = explode(' ', $data['keywords']);

            foreach($words as $w)
                $q->where("title like '%$w%'");
        }

        if($data['lesser'] != null) {
            $lesser = $data['lesser'];
            $q->where("lesser = '$lesser'");
        }

        if($data['available_from'] != null) {
            $from = $data['available_from'];
            $q->where("available_from >= '$from'");
        }

        if($data['available_untill'] != null) {
            $untill = $data['available_untill'];
            $q->where("available_untill <= '$untill'");
        }

        if($data['zone'] != null) {
            $zone = $data['zone'];
            $q->where("zone like '%$zone%'");
        }

        if($data['address'] != null) {
            $address = $data['address'];
            $q->where("address like '%$address%'");
        }

        if($data['fee_from'] != null) {
            $from = $data['fee_from'];
            $q->where("fee > '$from'");
        }

        if($data['fee_to'] != null) {
            $to = $data['fee_to'];
            $q->where("fee < '$to'");
        }

        if($data['type'] != null && $data['type'] != 'None') {
            $type = $data['type'];
            $q->where("type = '$type'");
        }

        $q->order('created');

        return $this->fetchAll($q);
    }
}