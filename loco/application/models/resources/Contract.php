<?php

class Application_Model_Resources_Contract  extends Zend_Db_Table_Abstract {

    protected $_name = 'contract';
    protected $_primary = 'id';

    public function init() {

    }

    public function updateContract($id , $datiaggiornati ) {
        $this->update($datiaggiornati, "id = $id");
    }

    public function getContract($id) {
        return $this->find($id);
    }

    public function addContract($data) {
        $this->insert($data);
    }

    public function deleteContract($id) {
        $this->delete("id = $id");
    }
}