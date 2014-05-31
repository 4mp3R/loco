<?php

class Application_Form_Accomodation extends Zend_Form
{
    public function init()
    {
        $this->setMethod("post");
        $this->setName("accomodation_form");
        $this->setAction("");
        $this->setAttrib('class', 'form');

        $this->addElement('text', 'title', array(
            'validators' => array(
                array('StringLength', true, array(5, 128))
            ),
            'required'   => true,
            'label'      => 'Titolo'
        ));

        $this->addElement('select', 'type', array(
            "multiOptions" => $this->getType(),
            'validators' => array(
                array('StringLength', true, array(3, 128))
            ),
            'required'   => true,
            'label'      => 'Tipo'
        ));


        $this->addElement('text', 'zone', array(
            'validators' => array(
                array('StringLength', true, array(2, 128))
            ),
            'required'   => true,
            'label'      => 'Zona'
        ));

        $this->addElement('text', 'address', array(
            'validators' => array(
                array('StringLength', true, array(4, 256))
            ),
            'required'   => true,
            'label'      => 'Indirizzo'
        ));


        $this->addElement('textarea', 'description', array(
            'label' => 'Descrizione',
            'cols' => '60', 'rows' => '20',
            'required' => true,
            'validators' => array(array('StringLength',true, array(0,2500))),
        ));


        $this->addElement('text', 'available_from' ,array(
            'filters'    => array('StringTrim'),
            'label' => 'Disponibile dal',
                'required' => true,
                'validators' => array(array('Date', 'format'=> 'yyyy-mm-dd'))

        ));

        $this->addElement('text', 'available_untill' ,array(
            'filters'    => array('StringTrim'),
            'label' => 'Disponibile fino al',
            'required' => true,
            'validators' => array(array('Date', 'format'=> 'yyyy-mm-dd'))

        ));



        $this->addElement('text', 'fee', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(4, 128)),
                array('Float'),
            ),
            'required'   => true,
            'label'      => 'Canone'
        ));






        $this->addElement('submit', 'registration', array(
            'label'    => 'Inserisci',
        ));


    }

    private function getType(){
        $model= new Application_Model_Accomodation();
        $types = $model->getTypes();

        $id=array();
        $name=array();
        $final=array();

        foreach ($types as $i){
            $id[] = $i['id'];
            $name[] = $i['name'];
        }


        for($i=0; $i<count($id); $i++){
            $final[$id[$i]] = $name[$i];
        }

        return $final;
    }
}
