<?php

class Application_Model_Acl extends Zend_Acl {

    public function __construct() {
        $this->addRole(new Zend_Acl_Role("unregistered"))
             ->addResource(new Zend_Acl_Resource(""))

        $this->addRole(new Zend_Acl_Role("lessee"), "unregistered");

        $this->addRole(new Zend_Acl_Role("lesser"), "lessee");

        $this->addRole(new Zend_Acl_Role("admin"), "lesser");
    }

}