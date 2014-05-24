<?php

class Application_Model_Profile {

    protected $_profileModel;

    public function __construct() {
        $this->_profileModel = new Application_Model_Resources_Profile();
    }

    public function getAllProfiles() {
        return $this->_profileModel->getAllProfiles();
    }

    public function getProfile($username) {
        return $this->_profileModel->getProfile($username);
    }

    public function addProfile($data) {
        return $this->_profileModel->addProfile($data);
    }

    public function updateProfile($username, $data) {
        return $this->_profileModel->updateProfile($username, $data);
    }

    public function deleteProfile($username) {
        return $this->_profileModel->deleteProfile($username);
    }

}