<?php

class MessageController extends Zend_Controller_Action
{
    protected $_messageForm;

    public function init()
    {
        $this->_helper->layout->setLayout('private');

        $this->_messageForm = new Application_Form_Message();
    }

    public function indexAction()
    {
        // action body
    }

    public function listAction() {

    }

    public function viewAction() {

    }

    public function deleteAction() {

    }
}