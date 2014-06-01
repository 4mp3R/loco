<?php

class Application_Model_Resources_Message  extends Zend_Db_Table_Abstract {

    protected $_name = 'message';
    protected $_primary = 'id';

    public function init() {

    }

    public function getInterlocutors($user) {
        $interlocutors = array();

        $q1 = $this->select("recipient")->where("sender = '$user'")->distinct();
        $q2 = $this->select("sender")->where("recipient = '$user'")->distinct();

        $r1 = $this->fetchAll($q1);
        $r2 = $this->fetchAll($q2);

        $interlocutors = array();

        foreach($r1 as $r) $interlocutors[] = $r->recipient;
        foreach($r2 as $r) $interlocutors[] = $r->sender;

        return array_unique($interlocutors);
    }

    public function getMessagesFromInterlocutor($interlocutor1, $interlocutor2) {
        $query = $this->select()->where("(sender = '$interlocutor1' and recipient = '$interlocutor2') or (sender = '$interlocutor2' and recipient = '$interlocutor1')");
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