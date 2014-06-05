<?php

class Application_Model_Resources_Accomodationdata  extends Zend_Db_Table_Abstract {

    protected $_name = 'accomodation_data';
    protected $_primary = 'id';

    public function init() {

    }


    public function getAccomodationdata($accomodation_id) {
        return $this->select()->where("accomodation = '$accomodation_id'");
    }



    public function addAccomodationdata($dati) {
        return $this->insert($dati);
    }

    public function updateAccomodationdata($id , $datiaggiornati ) {
        $this->update($datiaggiornati, "id = '$id'");
    }

    public function deleteAccomodationdata($id) {
        $this->delete("id = '$id");
    }


}