<?php

class MessageController extends Zend_Controller_Action
{
    protected $_messageModel;
    protected $_profileModel;
    protected $_messageForm;

    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout->setLayout('private');

        $this->_messageForm = new Application_Form_Message();
        $this->_messageModel = new Application_Model_Message();
        $this->_profileModel = new Application_Model_Profile();
    }

    public function indexAction()
    {
        // action body
    }

    public function listAction() {
        $data = array();

        $interlocutors = $this->_messageModel->getInterlocutors(
            Zend_Auth::getInstance()->getIdentity()->username
        );

        foreach($interlocutors as $i)
            $data[] = array("username" => $i);

        for($i=0; $i<count($data); $i++) {
            $profile = $this->_profileModel->getProfile($data[$i]['username']);
            $data[$i]['profile_image'] = $profile[0]->profile_image;
        }

        if(null != $this->_request->getParam('interlocutor'))
            $this->view->selectedInterlocutor = $this->_request->getParam('interlocutor');

        $this->view->data = $data;
    }

    public function viewAction() {

    }

    public function deleteAction() {

    }
}