<?php

class ContractController extends Zend_Controller_Action
{
    protected $_accomodationModel;

    public function init()
    {
        $this->_accomodationModel = new Application_Model_Accomodation();

        $this->_helper->layout->setLayout('private');
    }

    public function createAction() {

    }

    public function indexAction()
    {
        $options = $this->_accomodationModel->getOptionsByUsername(
            Zend_Auth::getInstance()->getIdentity()->username
        );

        $accomodations = array();

        foreach($options as $o) {
            $acc = $this->_accomodationModel->getAccomodation($o->accomodation);
            $accomodations[] = $acc[0];
        }
        $this->view->accomodations = $accomodations;
    }

    public function viewAction() {

    }

    public function infoAddAction() {

    }

    public function confirmAction() {

    }

}