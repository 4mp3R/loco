<?php

class Application_Form_Message extends Zend_Form {

    public function init() {
        $this->setMethod("post");
        $this->setName("login_form");
        $this->setAction("");
        $this->setAttrib('class', 'form');

        $this->addElement("hidden", "sender", array(
            'required' => true
        ));

        $this->addElement("hidden", "recipient", array(
           'required' => true
        ));

        $this->addElement("text", "content", array(
            "required" => true,
            "filters" => array("StringTrim")
        ))->removeDecorator("Label");

        $this->addElement("submit", "Manda")->removeDecorator("Label");
    }

}
