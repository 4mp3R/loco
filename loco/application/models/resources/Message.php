<?php

class Application_Model_Resources_Message  extends Zend_Db_Table_Abstract {

    protected $_name = 'message';
    protected $_primary = 'id';

    public function init() {

    }

    public function getInterlocutors($user) {
        $q1 = $this->select("recipient")->where("sender = '$user'")->distinct();
        $q2 = $this->select("sender")->where("recipient = '$user'")->distinct();

        $query = $this->select()->union(array($q1, $q2));
    print_r($this->fetchAll($query));
        return $this->fetchAll($query);
    }

    public function getMessagesFromInterlocutor($interlocutor1, $interlocutor2) {
        $query = $this->select()->where("(sender = $interlocutor1 and recipient = $interlocutor2) or (sender = $interlocutor2 and sender = $interlocutor1)");
        return $this->fetchAll($query);
    }

    public function getAllMessage() {
        $query = $this->select();
        return $this->fetchAll($query);
    }

    public function getMessage($id) {
        return $this->find($id);
    }

    public function addMessage($messaggio) {
        $this->insert($messaggio);
    }

    public function deleteMessage($id) {
        $this->delete("id = $id");
    }
}