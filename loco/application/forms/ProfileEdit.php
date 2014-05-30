<?php

class Application_Form_ProfileEdit extends Zend_Form
{
    public function init()
    {
        $this->setMethod("post");
        $this->setName("profile_edit_form");
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAction("");

        $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(4, 64))
            ),
            'required'   => false,
            'label'      => 'Password',
        ));

        $this->addElement('text', 'email', array(
            'filters' => array('StringTrim'),
            'validators' => array('EmailAddress', array('StringLength', true, array(4, 256))),
            'required' => true,
            'label' => 'Email'
        ));

        $this->addElement('text', 'name', array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(2, 128)),
                'Alpha'
            ),
            'required'   => true,
            'label'      => 'Nome',
        ));

        $this->addElement('text', 'surname', array(
            'filter' => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(4, 128)),
                'Alpha'
            ),
            'required'   => false,
            'label'      => 'Cognome',
        ));

        $this->addElement('text', 'birth', array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('Date', 'format' => 'yyyy-mm-dd')
            ),
            'required' => true,
            'label' => 'Data di nascita (aaaa-mm-gg)'
        ));

        $this->addElement('select', 'sex', array(
                'multiOptions' => array(
                    'M' => 'M',
                    'F' => 'F'
                ),
                'filter' => array('StringTrim'),
                'validator' => array(
                    array('StringLength', true, array(1,1)),
                    'Alpha'
                ),
                'required' => true,
                'label' => 'Sesso'
            )
        );

        $this->addElement('text', 'cf', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                'Alnum',
                array('StringLength', true, array(16, 16))
            ),
            'required'   => true,
            'label'      => 'Codice Fiscale',
        ));

        $this->addElement('file', 'profile_image', array(
            'validators' => array(
                array('Count', false, 1),
                array('Size', false, 5335040),
                array('Extension', false, array('jpg'))
            ),
            'required'   => false,
            'label'      => 'Immagine profilo'
        ));

        $this->addElement('text', 'phone', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(8, 16))
            ),
            'required'   => true,
            'label'      => 'Telefono',
        ));

        $this->addElement('submit', 'edit', array(
            'label'    => 'Aggiorna profilo'
        ));

    }
}
