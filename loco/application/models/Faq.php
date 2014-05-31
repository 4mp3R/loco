<?php

class Application_Model_Test {

    protected $_faqModel;

    public function __construct() {
        $this->_faqModel = new Application_Model_Resources_Faq();
    }

    public function getFaq() {
        return $this->_faqModel->getFaq();
    }

    public function addFaq($item) {
        $this->_faqModel->addFaq($item);
    }

    public function updateFaq($id, $item) {
        $this->_faqModel->updateFaq($id, $item);
    }

    public function deleteFaq($id) {
        $this->_faqModel->deleteFaq($id);
    }

}