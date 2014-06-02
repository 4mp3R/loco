<?php

class LocoController extends Zend_Controller_Action
{

    protected $_staticsModel;

    public function init()
    {
        $this->_helper->layout->setLayout("public");
    }

    public function indexAction()
    {
        // action body
    }

    public function faqViewAction() {
        $this->_staticsModel = new Application_Model_Statics();
        $this->view->faq = $this->_staticsModel->getFaq();
    }

    public function supportViewAction() {
    }

    public function settingsAction() {
        $this->_helper->layout->setLayout('private');
    }

    public function statisticsAction() {
        $this->_helper->layout->setLayout('private');
    }

}