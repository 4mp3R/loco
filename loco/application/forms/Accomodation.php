<?php

class Application_Form_Accomodation extends Zend_Form
{
    protected $_accomodationModel;

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
            'validators' => array('Digits'),
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

        $this->addElement('file', 'photo', array(
            'validators' => array(
                array('Count', false, 3),
                array('Size', false, 5335040),
                array('Extension', false, array('jpg'))
            ),
            'required' => false,
            'label' => 'Foto',
            'multiFile' => 3
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
                array('Float', 'locale' => 'it'),
            ),
            'required'   => true,
            'label'      => 'Canone'
        ));



        //Aggiungere i campi in modo dinamico per tipologie

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
                $this->addDisplayGroup($displayGroupElems, $t->name, array('class' => 'col-1-4'));
                $this->getDisplayGroup($t->name)->removeDecorator('DtDdWrapper');
            }
        }



        $this->addElement('submit', 'submit', array(
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
