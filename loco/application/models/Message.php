<?php

class Application_Model_Message  {

    protected $_messageModel;

    public function __construct() {
        $this->_messageModel = new Application_Model_Resources_Message();
    }

    public function getInterlocutors($user) {
        return $this->_messageModel->getInterlocutors($user);
    }

    public function getMessages($interlocutor1, $interlocutor2) {
        return $this->_messageModel->getMessagesFromInterlocutor($interlocutor1, $interlocutor2);
    }

    public function sendMessage($data) {
        $this->_messageModel->addMessage($data);
    }
}