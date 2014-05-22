<?php

class LocoController extends Zend_Controller_Action
{

    protected $_staticsModel;

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function faqViewAction() {
        $this->_staticsModel = new Application_Model_Statics();

        $this->view->faq = $this->_staticsModel->getFaq();
    }

    public function faqEditAction() {

    }

    public function statisticsAction() {

    }

}