<?php

class Application_Form_AccomodationType extends Zend_Form {

    public function init() {
        $this->setMethod("post");
        $this->setName("accomodation_type_form");
        $this->setAction("");
        $this->setAttrib('class', 'form');


    }

}