<?php
/**
 * Created by PhpStorm.
 * User: utente
 * Date: 19/05/14
 * Time: 22.36
 */

class Application_Model_Statics {

    protected $_faqModel;

    public function getFaq() {
        $this->_faqModel = new Application_Model_Resources_Faq();

        return $this->_faqModel->getFaq();
    }

    public function getSlogan() {

    }

    public function getTutorial() {

    }

} 