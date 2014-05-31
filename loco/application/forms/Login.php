<?php

class Application_Form_Login extends Zend_Form
{
    public function init()
    {
        $this->setMethod("post");
        $this->setName("login_form");
        $this->setAction("");

        $this->addElement('text', 'username', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(4, 128))
            ),
            'required'   => true,
            'label'      => 'Username',
        ));

        $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(4, 64))
            ),
            'required'   => true,
            'label'      => 'Password',
        ));

        $this->addElement('submit', 'login', array(
            'label'    => 'Login',
        ));


    }
}
