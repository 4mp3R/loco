<?php
/**
 * Created by PhpStorm.
 * User: utente
 * Date: 19/05/14
 * Time: 22.36
 */

class Application_Model_Statics {

    protected $_faqModel;

    public function __construct() {
        $this->_faqModel = new Application_Model_Resources_Faq();
    }

    public function getFaq() {
        return $this->_faqModel->getFaq();
    }

    public function getFaqItem($id) {
        return $this->_faqModel->getFaqItem($id);
    }

    public function deleteFaq($id) {
        return $this->_faqModel->deleteFaq($id);
    }

    public function updateFaq($data) {
        $this->_faqModel->updateFaq($data['id'], $data);
    }

    public function addFaq($data) {
        $this->_faqModel->addFaq($data);
    }

} 