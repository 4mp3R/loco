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
        $this->_messageForm->setAction($this->_helper->getHelper("url")->url(array(
                'controller' => 'message',
                'action' => 'add'),
            'default'
        ));


        $this->_messageModel = new Application_Model_Message();
        $this->_profileModel = new Application_Model_Profile();
    }

    public function indexAction()
    {
        // action body
    }

    public function listAction() {
        $data = array();
        $messages = array();
        $interlocutor = null;

        $interlocutors = $this->_messageModel->getInterlocutors(
            Zend_Auth::getInstance()->getIdentity()->username
        );

        foreach($interlocutors as $i)
            $data[] = array("username" => $i);

        for($i=0; $i<count($data); $i++) {
            $profile = $this->_profileModel->getProfile($data[$i]['username']);
            $data[$i]['profile_image'] = $profile[0]->profile_image;
        }

        $interlocutor = $this->_request->getParam('interlocutor');

        if(null != $interlocutor) {
            if(1 === count($this->_profileModel->getProfile($interlocutor))) {

                $this->view->selectedInterlocutor = $interlocutor;

                $msg = $this->_messageModel->getMessages(Zend_Auth::getInstance()->getIdentity()->username, $interlocutor);

                foreach($msg as $m) {
                    $sender = $this->_profileModel->getProfile($m->sender);

                    $messages[] = array(
                      'author' => $m->sender,
                      'author_profile_image' => $sender[0]->profile_image,
                      'timestamp' => $m->send_date,
                      'content' => $m->content
                    );
                }

                $this->_messageForm->getElement('sender')->setValue(Zend_Auth::getInstance()->getIdentity()->username);
                $this->_messageForm->getElement('recipient')->setValue($interlocutor);
            } else $this->_helper->redirector("list", "message");
        }

        $this->view->data = $data;
        $this->view->messages = $messages;

        if(null != $this->_request->getParam('interlocutor')) {
            $this->view->form = $this->_messageForm;
        }
    }

    public function addAction() {
        $request = $this->_request;

        $keys = array('sender', 'recipient', 'content');

        if($request->isPost()) {
            if($this->_messageForm->isValid($request->getParams())) {
                $this->_messageModel->sendMessage(
                    array_intersect_key(
                        $request->getParams(), array_flip($keys)
                    )
                );
            }
        }

        $this->_helper->redirector("list", "message", 'default', array('interlocutor' => $request->getParam('recipient')));
    }

    public function viewAction() {

    }

    public function deleteAction() {

    }
}