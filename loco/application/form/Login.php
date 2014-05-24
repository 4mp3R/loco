<?php

class Application_Form_Login extends Zend_Form {

    public function init() {
        $this->setAction("")
             ->setMethod("post")
             ->setName("login_form");

        $this->addElement("text", "username", array(
            "filters" => array("StringTrim"),
            "validators" => array(array("StringLength", true, array(4,64))),
            "required" => true,
            "label" => "Username"
        ));

        $this->addElement("password", "password", array(
            "filter" => array("StringTrim"),
            "validators" => array(array("StringLength", true, array(4, 64))),
            "required" => true,
            "label" => "Password"
        ));

        $this->addElement("submit", "Log In Now!");
    }

}