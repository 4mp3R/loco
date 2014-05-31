<?php

class Application_Form_Search extends Zend_Form {

    public function init() {
        $this->setMethod("post");
        $this->setName("search_form");
        $this->setAction("");
        $this->setAttrib('class', 'form');

        
    }

}
