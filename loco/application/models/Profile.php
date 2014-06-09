<?php

class Application_Model_Profile {

    protected $_profileModel;

    public function __construct() {
        $this->_profileModel = new Application_Model_Resources_Profile();
    }

    public function getAllProfiles($page = null) {
        return $this->_profileModel->getAllProfiles($page);
    }

    public function getProfile($username) {
        return $this->_profileModel->getProfile($username);
    }

    public function addProfile($data) {
        return $this->_profileModel->addProfile($data);
    }

    public function updateProfile($data, $username) {
        return $this->_profileModel->updateProfile($data, $username);
    }

    public function deleteProfile($username) {
        return $this->_profileModel->deleteProfile($username);
    }

}