<?php

class Application_Form_Search extends Zend_Form {

    public function init() {
        $accomodationTypeModel = new Application_Model_Accomodation();
        $options = array();

        $this->setMethod("post");
        $this->setName("search_form");
        $this->setAction("");
        $this->setAttrib('class', 'form');

        foreach($accomodationTypeModel->getTypes() as $t)
            $options[$t->name] = $t->name;

        $this->addElement("select", "type", array(
            'multiOptions' => $options,
            'filters' => array('StringTrim'),
            'validators' => array('Alpha'),
            'required' => false,
            'label' => 'Tipologia'
        ));

        $this->addElement("text", "keywords", array(
            'filters' => array('StringTrim'),
            'required' => false,
            'label' => 'Parole chiavi'
        ));

        $this->addElement("text", "lesser", array(
            'filter' => array('StringTrim'),
            'validators' => array(array('Alnum', 'allowWhiteSpace' => true)),
            'required' => false,
            'label' => 'Locatore'
        ));

        $this->addElement("text", "available_from", array(
            'filters' => array('StringTrim'),
            'validators' => array(array('Date', 'format' => 'yyyy-mm-dd')),
            'required' => false,
            'label' => 'Disponibile da (aaaa-mm-gg)'
        ));

        $this->addElement("text", "available_untill", array(
            'filters' => array('StringTrim'),
            'validators' => array(array('Date', 'format' => 'yyyy-mm-dd')),
            'required' => false,
            'label' => 'Disponibile fino a (aaaa-mm-gg)'
        ));

        $this->addElement("text", "zone", array(
            'filters' => array('StringTrim'),
            'validators' => array('Alpha'),
            'required' => false,
            'label' => 'Zona'
        ));

        $this->addElement("text", "address", array(
            'filters' => array('StringTrim'),
            'required' => false,
            'label' => 'Indirizzo'
        ));

        $this->addElement("text", "fee_from", array(
            'filters' => array('StringTrim'),
            'validators' => array('Digits'),
            'required' => false,
            'label' => 'Canone da'
        ));

        $this->addElement("text", "fee_to", array(
            'filters' => array('StringTrim'),
            'validators' => array('Digits'),
            'required' => false,
            'label' => 'Canone fino a'
        ));

        $this->addElement("submit", "submit");
    }

}
