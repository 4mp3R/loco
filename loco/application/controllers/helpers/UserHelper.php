<?php

class My_LayoutHelper extends Zend_Controller_Action_Helper_Abstract {
    /**
     * Predispatch hook.
     */
    public function preDispatch()
    {
        $view = $this->getActionController()->view;

        // Get the user data from wherever you have them
        $userInfo = getUserInfo();

        // Inject it into the view
        $view->username = $userInfo->name;
    }
}