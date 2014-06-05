<?php

class Application_Form_Statistics extends Zend_Form {

    public function init() {
        $accomodationTypeModel = new Application_Model_Accomodation();
        $options = array();

        $this->setMethod("post");
        $this->setName("statistics_form");
        $this->setAction("");
        $this->setAttrib('class', 'form grid text-center');

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

        $this->addElement('submit', 'submit', array(
            'label'    => 'Visualizza',
            'class'    => 'button button-primary button-margin'
        ))->removeDecorator('label');

//nuovo elemento gfrom nomi elementi nell'array
        $this->addDisplayGroup(array('from'), 'gfrom', array(
            'class'   => 'col-1-4'
        ));
        $this->addDisplayGroup(array('to'), 'gto', array(
            'class'   => 'col-1-4'
        ));
        $this->addDisplayGroup(array('type_id'), 'gtype_id', array(
            'class'   => 'col-1-4'
        ));
        $this->addDisplayGroup(array('submit'), 'gsubmit', array(
            'class'   => 'col-1-4'
        ));
        $g = $this->getDisplayGroup("gfrom");
        $g->removeDecorator('DtDdWrapper');
        $g = $this->getDisplayGroup("gto");
        $g->removeDecorator('DtDdWrapper');
        $g = $this->getDisplayGroup("gtype_id");
        $g->removeDecorator('DtDdWrapper');
        $g = $this->getDisplayGroup("gsubmit");
        $g->removeDecorator('DtDdWrapper');
    }


}