<?php

class AccomodationController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout->setLayout('private');
    }

    public function indexAction()
    {
        // action body
    }

    public function getAction() {

    }

    public function addAction() {

    }

    public function editAction() {

    }

    public function optionAction() {

    }

    public function lesseeSelectAction() {

    }

    public function viewAllAction()
    {

        $this->_accomodationsModel = new Application_Model_Accomodation();
        $this->view->allAccomodations = $this->_accomodationsModel->getAllAccomodations();
    }

    public function searchAction() {
        $searchForm = new Application_Form_Search();
        $this->view->form = $searchForm;
    }

    public function typeManageAction() {

    }
}