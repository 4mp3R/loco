<?php

class Application_Form_Registration extends Zend_Form
{
    public function init()
    {
        $this->setMethod("post");
        $this->setName("registration_form");
        $this->setAction("");

        $this->addElement('text', 'username', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(4, 128))
            ),
            'required'   => true,
            'label'      => 'Username',
        ));

        $this->addElement('password', 'passwd', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(4, 64))
            ),
            'required'   => true,
            'label'      => 'Password',
        ));

        $this->addElement(array(
            'type' => 'Zend\Form\Element\Email',
            'name' => 'email',
            'options' => array(
                'label' => 'Email'
            ),
            'attributes' => array(
                'placeholder' => 'you@domain.com'
            )
        ));

        $this->addElement('text', 'name', array(
            'validators' => array(
                array('StringLength', true, array(2, 128))
            ),
            'required'   => true,
            'label'      => 'Nome',
        ));

        $this->addElement('text', 'surname', array(
            'validators' => array(
                array('StringLength', true, array(4, 128))
            ),
            'required'   => true,
            'label'      => 'Cognome',
        ));

        $this->addElement(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'birth',
            'options' => array(
                'label' => 'Data di Nascita'
            )
        ));

        $this->addElement(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'sex',
            'options' => array(
                'label' => 'Sesso',
                'value_options' => array(
                    '1' => 'Seleziona il tuo sesso',
                    '2' => 'Uomo',
                    '3' => 'Donna'
                ),
            ),
            'attributes' => array(
                'value' => '1'
            )
        ));

        $this->addElement('text', 'cf', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(16, 16))
            ),
            'required'   => true,
            'label'      => 'Codice Fiscale',
        ));

        $this->addElement('file', 'profile_image', array(
            'validators' => array(
                array(
                    array('Count', false, 1),
                    array('Size', false, 102400),
                    array('Extension', false, array('jpg', 'gif'))),
            'required'   => true,
            'label'      => 'Immagine profilo',
        ));

        $this->addElement(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'role',
            'options' => array(
        'label' => 'Ruolo',
        'value_options' => array(
            '1' => 'Seleziona il tuo ruolo',
            '2' => 'Locatore',
            '3' => 'Locatario'
        ),
    ),
            'attributes' => array(
        'value' => '1'
    )
        ));

        $this->addElement('text', 'phone', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(10, 16))
            ),
            'required'   => true,
            'label'      => 'Telefono',
        ));

        $this->addElement('submit', 'registration', array(
            'label'    => 'Regista',
        ));


    }
}
