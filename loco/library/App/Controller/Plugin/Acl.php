<?php

class App_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract {

    //Hook to the pre-dispatch loop
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $auth = null;
        $role = null;
        $acl = null;
        $resource = null;

        $auth = Zend_Auth::getInstance();

        if($auth->hasIdentity())
            $role = $auth->getIdentity()->role;
        else
            $role = "unregistered";

        $acl = new Application_Model_Acl();

        $resource = $request->getControllerName() . "_" . $request->getActionName();

        if(!$acl->has($resource) || !$acl->isAllowed($role, $resource)) {
            //$auth->clearIdentity();
            $this->_request->setControllerName("error")
                           ->setActionName("authorization-error");
        }
    }

}