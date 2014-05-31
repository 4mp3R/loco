<?php

class Application_Form_Message extends Zend_Form {

    public function init() {
        $this->setMethod("post");
        $this->setName("message_form");
        $this->setAction("");
        $this->setAttrib('class', 'form');

        $this->addElement("text", "content", array(
            'filters' => array('StringTrim'),
            'required' => true,
            'value' => 'Testo del messaggio'
        ));

        $this->addElement("submit", "Manda");

        $this->removeDecorator('')
    }

}