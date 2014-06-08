<?php

class Application_Form_Faq extends Zend_Form {

    public function init() {
        $this->setMethod("post");
        $this->setName("faq_form");
        $this->setAction("");
        $this->setAttrib('class', 'form');

        $this->addElement("text", "question", array(
            'filter' => array('StringTrim'),
            'required' => true,
            'label' => 'Domanda'
        ));

        $this->addElement("textarea", "answer", array(
            'filter' => array('StringTrim'),
            'required' => true,
            'label' => 'RIsposta'
        ));

        $this->addElement("hidden", "id", array(
            'filter' => array('StringTrim'),
            'validators' => array('Digits'),
            'required' => false
        ));

        $this->addElement("submit", "Vai!", array(
            'label' =>  'Salva',
            'class'    => 'button button-primary'
        ));

        $this->addElement("reset", "reset", array(
            'label' =>  'Reimposta',
            'class'    => 'button button-danger'
        ));
    }

}