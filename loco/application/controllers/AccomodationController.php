<?php

class AccomodationController extends Zend_Controller_Action
{
    protected $_accomodatioModel;
    protected $_profileModel;

    public function init()
    {
        $this->_helper->layout->setLayout('private');

        $this->_accomodatioModel = new Application_Model_Accomodation();
        $this->_profileModel = new Application_Model_Profile();
    }

    public function indexAction()
    {

    }

    public function getAction() {
        $id = $this->_request->getParam('id');

        if(null === $id || 0 == count($this->_accomodatioModel->getAccomodation($id)))
            $this->_helper->redirector("search", "accomodation");

        $accomodation = $this->_accomodatioModel->getAccomodation($id);
        $photos = $this->_accomodatioModel->getPhotosForAccomodation($id);
        $characteristics = $this->_accomodatioModel->getAccomodationCharacteristics($id);
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
        $request = $this->_request;

        $accomodations = array();
        $lessers = array();
        $types = array();
        $photos = array();

        //user entered some search params
        if($request->isPost()) {
            if($searchForm->isValid($request->getParams())) {
                echo "<h1>RICERCA</h1>";
            }
        } else {    //no search params, show latest accomodations inserted
            $accomodations = $this->_accomodatioModel->getLatestAccomodations(4);
        }

        for($i=0; $i<count($accomodations); $i++) {
            $lessers[] = $this->_profileModel->getProfile($accomodations[$i]->lesser);
            $photos[] = $this->_accomodatioModel->getPhotosForAccomodation($accomodations[$i]->id);
            $types[] = $this->_accomodatioModel->getAccType($accomodations[$i]->id);
        }

        $this->view->accomodations = $accomodations;
        $this->view->lessers = $lessers;
        $this->view->accomodations_type = $types;
        $this->view->photos = $photos;
        $this->view->form = $searchForm;
    }

    public function typeManageAction() {

    }
}