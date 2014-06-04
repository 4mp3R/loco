<?php

class Application_Model_Resources_Profile  extends Zend_Db_Table_Abstract {

    protected $_name = 'profile';
    protected $_primary = 'username';

    public function init() {

    }

    public function getAllProfiles() {
        $query = $this->select('*');
        return $this->fetchAll($query);
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
