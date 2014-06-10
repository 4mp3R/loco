<?php

class Application_Form_Search extends Zend_Form {

    protected $_accomodationModel;

    public function init() {
        $accomodationTypeModel = new Application_Model_Accomodation();
        $options = array(
            'None' => 'Nessuna preferenza'
        );

        $this->setMethod("get");
        $this->setName("search_form");
        $this->setAction("");
        $this->setAttrib('class', 'form');

        foreach($accomodationTypeModel->getTypes() as $t)
            $options[$t->id] = $t->name;

        $this->addElement('hidden', 'complete', array(
            'required' => false,
            'value' => 'yes'
        ));

        $this->addElement("select", "type", array(
            'multiOptions' => $options,
            'filters' => array('StringTrim'),
            'validators' => array('Alnum'),
            'required' => false,
            'label' => 'Tipologia'
        ));

        $this->_accomodationModel = new Application_Model_Accomodation();

        $types = $this->_accomodationModel->getTypes();
        foreach($types as $t) {
            $features = $this->_accomodationModel->getFeaturesByType($t->id);

            $displayGroupElems = array();

            foreach($features as $f) {
                $formElem = null;
                if($f->data_type == 'bool') $formElem = "checkbox";
                else if($f->data_type == 'int' || $f->data_type = 'string') $formElem = "text";
                else $formElem = "text";

                $this->addElement($formElem, str_replace(' ', '_', $t->name.'_'.$f->name), array(
                    'required' => false,
                    'label' => $f->name
                ));

                $displayGroupElems[] = str_replace(' ', '_', $t->name.'_'.$f->name);
                $this->addDisplayGroup($displayGroupElems, $t->name, array('class' => 'search-display-group'));
                $this->getDisplayGroup($t->name)->removeDecorator('DtDdWrapper');
            }
        }

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
            'required' => false,
            'label' => 'Canone da'
        ));

        $this->addElement("text", "fee_to", array(
            'filters' => array('StringTrim'),
            'required' => false,
            'label' => 'Canone fino a'
        ));

        $this->getElement('fee_from')->removeDecorator('label');
        $this->getElement('fee_to')->removeDecorator('label');

        $this->addElement("submit", "submit", array(
            'label' => 'Vai!',
            'class'    => 'button button-primary'
        ));

        $this->addElement("reset", "reset", array(
            'label' => 'Annulla',
            'class'    => 'button button-danger'
        ));
    }

}
