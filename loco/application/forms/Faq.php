<?php

class Application_Form_Faq extends Zend_Form {

    public function init() {
        $this->setMethod("post");
        $this->setName("statistics_form");
        $this->setAction("");
        $this->setAttrib('class', 'form');

        $this->addElement("text", "question", array(
            'filter' => array('StringTrim'),
            'required' => true,
            'label' => 'Domanda'
        ));

        $this->addElement("text", "answer", array(
            'filter' => array('StringTrim'),
            'required' => true,
            'label' => 'RIsposta'
        ));

        $this->addElement("hidden", "id", array(
            'filter' => array('StringTrim'),
            'validators' => array('Digits'),
            'required' => false
        ));

        $this->addElement("submit", "Vai!");
    }

}