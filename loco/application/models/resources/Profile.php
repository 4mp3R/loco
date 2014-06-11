<?php

class Application_Model_Resources_Profile  extends Zend_Db_Table_Abstract {

    protected $_name = 'profile';
    protected $_primary = 'username';

    public function init() {

    }

    public function getAllProfiles($page = null) {
        $query = $this->select('*');

        if(null != $page) {
            $adapter = new Zend_Paginator_Adapter_DbTableSelect($query);
            $paginator = new Zend_Paginator($adapter);
            $paginator->setItemCountPerPage(2);
            $paginator->setCurrentPageNumber($page);

            return $paginator;
        } else return $this->fetchAll($query);
    }

    public function getProfile($username) {
        return $this->find($username);
    }

    public function addProfile($data) {
        $this->insert($data);
    }

    public function updateProfile($data , $username) {
        $this->update($data, "username = '$username'");
    }

    public function deleteProfile($username) {
        $this->delete("username = '$username'");
    }
}
