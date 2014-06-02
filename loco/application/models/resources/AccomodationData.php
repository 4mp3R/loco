<?php

class Application_Model_Resources_Accomodationdata  extends Zend_Db_Table_Abstract {

    protected $_name = 'accomodation_data';
    protected $_primary = 'id';

    public function init() {

    }


    public function getAccomodationdata($id) {
        return $this->find($id);
    }

    public function addAccomodationdata($dati) {
        $this->insert($dati);
    }

    public function updateAccomodationdata($id , $datiaggiornati ) {
        $this->update($datiaggiornati, "id = '$id'");
    }

    public function deleteAccomodationdata($id) {
        $this->delete("id = '$id");
    }


}