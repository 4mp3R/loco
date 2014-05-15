<?php

//All methods that begins with _ will be executed automatically at bootstrap time
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected $_view;

    //need to initialize FrontController here in order to be able to use baseUrl() at the bootstrap time
    //baseUrl() return the path to a /public folder accessible by browsers
    protected function _initRequest()
    {
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        $request = new Zend_Controller_Request_Http();
        $front->setRequest($request);
    }

    //initialize some placeholders that will be used in templates
    protected function _initViewSettings()
    {
        $this->bootstrap('view');
        $this->_view = $this->getResource('view');
        $this->_view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8');
        $this->_view->headMeta()->appendHttpEquiv('Content-Language', 'it-IT');
        $this->_view->headLink()->appendStylesheet($this->_view->baseUrl('css/style.css'));
        $this->_view->headTitle('Loco!');
    }
}

