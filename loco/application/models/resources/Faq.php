<?php

/*
 * $item = array("question" => <question>, "answer" => <answer>
 */

class Application_Model_Resources_Faq extends Zend_Db_Table_Abstract {

    protected $_name = "faq";
    protected $_primary = "id";

    public function getFaq() {
        $query = $this->select(); //$query = "select * from faq";
        return $this->fetchAll($query); //q -->DB-->[tuple]
    }

    public function getFaqItem($id) {
       return $q = $this->find($id);
    }

    public function addFaq($item) {
        $this->insert($item);
    }

    public function updateFaq($id, $item) {
        $this->update($item, "id = $id");
    }

    public function deleteFaq($id) {
        $this->delete("id = '$id'");
    }

}