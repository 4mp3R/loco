<?php

class Zend_View_Helper_ActiveLink extends Zend_View_Helper_Abstract {

    public function activeLink($ctrl='', $action='') {
        $r = Zend_Controller_Front::getInstance()->getRequest();
        if($ctrl == $r->getControllerName() && $action == $r->getActionName()) echo 'active';
    }

}