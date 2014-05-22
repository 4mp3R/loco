<?php

class Application_Model_Resources_Profile  extends Zend_Db_Table_Abstract {

    protected $_name = 'profile';
    protected $_primary = 'email';

    public function init() {

    }

    public function getAllProfiles() {
        $query = $this->select('*');
        return $this->fetchAll($query);
    }

    public function getProfile($email) {
        return $this->find($email);
    }

    public function addProfile($dati) {
        $this->insert($dati);
    }

    public function updateProfile($email , $datiaggiornati ) {
        //$this->update("email = $email");
        $this->update($datiaggiornati, "email = $email");
    }

    public function deleteProfile($email) {
        $this->delete("email = $email");
    }
}
