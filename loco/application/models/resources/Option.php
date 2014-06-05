<?php

class Application_Model_Resources_Option extends Zend_Db_Table_Abstract {

    protected $_name = "option";
    protected $_primary = array('lessee', 'accomodation');

    public function getOptionsByInterval($from, $to) {
        $q = $this->select();

        if(null != $from && null != $to)
            $q->where("date >= '$from' and date <= '$to'");

        return $this->fetchAll($q);
    }

    public function getOption($username, $accomodation) {
        $q = $this->select()->where("lessee = '$username' and accomodation='$accomodation'");

        return $this->fetchAll($q);
    }

    public function setOption($username, $accomodation) {
        $this->insert(array(
            'lessee' => $username,
            'accomodation' => $accomodation,
            'state' => 'optioned'
        ));
    }

    public function setLocated($username, $accomodation) {

    }

}