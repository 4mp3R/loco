<?php

class Application_Form_Contract extends Zend_Form
{
    public function init()
    {
        $this->setMethod("post");
        $this->setName("contract_form");
        $this->setAction("");
        $this->setAttrib('class', 'form');

        $this->addElement('text', 'lessee', array(
            'validators' => array(
                array('StringLength', true, array(4, 256))
            ),
            'required'   => true,
            'label'      => 'Locatario',
        ));

        $this->addElement('text', 'lessor', array(
            'validators' => array(
                array('StringLength', true, array(4, 256))
            ),
            'required'   => true,
            'label'      => 'Locatare',
        ));

        $this->addElement('text', 'iban', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(34, 128))
            ),
            'required'   => true,
            'label'      => 'IBAN',
        ));

        $this->addElement('text', 'fee', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(4, 128))
            ),
            'required'   => true,
            'label'      => 'Affitto',
        ));

        $this->addElement('text', 'beginning' ,array(
            'filters'    => array('StringTrim'),
            'label' => 'Data di inizio contratto',
            'required' => true,
            'validators' => array(array('Date', 'format'=> 'yyyy-mm-dd'))

        ));

        $this->addElement('text', 'ending' ,array(
            'filters'    => array('StringTrim'),
            'label' => 'Data di fine contratto',
            'required' => true,
            'validators' => array(array('Date', 'format'=> 'yyyy-mm-dd'))

        ));

        $this->addElement('text', 'address', array(
            'validators' => array(
                array('StringLength', true, array(4, 256))
            ),
            'required'   => true,
            'label'      => 'Indirizzo',
        ));


        $this->addElement('submit', 'registration', array(
            'label'    => 'Inserisci',
        ));



    }
}
