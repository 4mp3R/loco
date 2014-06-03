<?php

class Application_Form_Statistics extends Zend_Form {

    public function init() {
        $accomodationTypeModel = new Application_Model_Accomodation();
        $options = array();

        $this->setMethod("post");
        $this->setName("statistics_form");
        $this->setAction("");
        $this->setAttrib('class', 'form');

        $this->addElement("text", "from", array(
            'filter' => array('StringTrim'),
            'validators' => array(array('Date', 'format' => 'yyyy-mm-dd')),
            'required' => false,
            'label' => 'Dal'
        ));

        $this->addElement("text", "to", array(
            'filter' => array('StringTrim'),
            'validators' => array(array('Date', 'format' => 'yyyy-mm-dd')),
            'required' => false,
            'label' => 'al'
        ));

        $options['none'] = 'Nessuna tipologia';

        foreach($accomodationTypeModel->getTypes() as $t)
            $options[$t->id] = $t->name;

        $this->addElement("select", "type_id", array(
            'filter' => array('StringTrim'),
            'validators' => array('Alnum'),
            'multiOptions' => $options,
            'required' => false,
            'label' => 'Tipologia'
        ));

        $this->addElement("submit", "Visualizza");
    }


}