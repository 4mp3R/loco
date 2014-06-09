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
        $this->_view->headMeta()->appendHttpEquiv('Viewport', 'width=device-width, initial-scale=1.0');
        $this->_view->headMeta()->appendHttpEquiv('Description', '');
        $this->_view->headLink()->headLink(array('rel' => 'icon shortcut favicon','href' => $this->_view->baseUrl('favicon.ico')));

        $this->_view->headLink()->appendStylesheet($this->_view->baseUrl('css/normalize.css'));
        $this->_view->headLink()->appendStylesheet($this->_view->baseUrl('css/base.css'));
        $this->_view->headLink()->appendStylesheet($this->_view->baseUrl('css/style.css'));

        $this->_view->headScript()->appendFile($this->_view->baseUrl('js/jquery.js'), 'text/javascript');
        $this->_view->headScript()->appendFile($this->_view->baseUrl('js/main.js'), 'text/javascript');

        $this->_view->headTitle('Loco!');
    }

    protected function _initCustomModuleAutoload() {
        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->registerNamespace("App_");
    }

    protected function _initAclHookPlugin() {
        Zend_Controller_Front::getInstance()->registerPlugin(new App_Controller_Plugin_Acl());
    }

    protected function _initPaginationControls() {
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginationNav.phtml');
    }
}

