<?php

class Zend_View_Helper_WhoIs extends Zend_View_Helper_Abstract {

    protected $_auth;

    public function whoIs() {
        $this->_auth = Zend_Auth::getInstance();

        if($this->_auth->hasIdentity())
            return $this->_auth->getIdentity();
        else
            return false;
    }

}