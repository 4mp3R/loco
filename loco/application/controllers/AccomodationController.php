<?php

class AccomodationController extends Zend_Controller_Action
{
    protected $_accomodationModel;
    protected $_profileModel;
    protected $_accomodationForm;

    public function init()
    {
        $this->_helper->layout->setLayout('private');

        $this->_accomodationModel = new Application_Model_Accomodation();
        $this->_profileModel = new Application_Model_Profile();
        $this->_accomodationForm = new Application_Form_Accomodation();
    }

    public function indexAction() {
        $accomodations = $this->_accomodationModel->getAccomodationByProfile(
            Zend_Auth::getInstance()->getIdentity()->username
        );

        $data = array();

        foreach($accomodations as $acc) {
            $data[] = array('accomodation' => $acc, 'options' => $this->_accomodationModel->getOptionsByAccomodation($acc->id));
        }

        $this->view->data = $data;
    }

    public function getAction() {
        $id = $this->_request->getParam('id');

        if(null === $id || 0 == count($this->_accomodationModel->getAccomodation($id)))
            $this->_helper->redirector("search", "accomodation");

        $this->view->accomodation = $this->_accomodationModel->getAccomodation($id);
        $this->view->photos = $this->_accomodationModel->getPhotosForAccomodation($id);
        $this->view->characteristics = $this->_accomodationModel->getAccomodationFullInfo($id);
        $this->view->username = Zend_Auth::getInstance()->getIdentity()->username;
        $this->view->option = $this->_accomodationModel->getOption(Zend_Auth::getInstance()->getIdentity()->username, $id);
    }

    public function addAction() {
        $request = $this->_request;

        $generalAccomodationParams = array('type', 'title', 'description', 'lesser', 'available_from', 'available_untill', 'zone', 'address', 'fee');

        if(null == $request->getParam('title')) {
            $this->view->form = $this->_accomodationForm;
        } else if($this->_accomodationForm->isValid($request->getParams())) {
            $type = $request->getParam('type');
            $features = $this->_accomodationModel->getFeaturesByType($type);

            $specificAccomodationParams = array();
            foreach($features as $f) {
                $t = $this->_accomodationModel->getAccomodationType($type);
                $specificAccomodationParams[] = array('id' => $f->id, 'form_name' => str_replace(' ', '_', $t[0]->name.'_'.$f->name));
            }

            $request->setParam('lesser', Zend_Auth::getInstance()->getIdentity()->username);

            $this->_accomodationModel->addAccomodation(array_intersect_key($request->getParams(), array_flip($generalAccomodationParams)));
            $id = $this->_accomodationModel->accomodationLastInsertId();

            foreach($specificAccomodationParams as $sp) {
                $this->_accomodationModel->addAccomodationdata(array(
                    'accomodation' => $id,
                    'feature_id' => $sp['id'],
                    'feature_value' => $request->getParam($sp['form_name'])
            ));
            }

            $this->_helper->redirector('index', 'accomodation');
        } else {
            $this->view->form = $this->_accomodationForm;
        }
    }


    public function editAction() {

    }

    public function optionAction() {
        $request = $this->_request;

        $username = $request->getParam('username');
        $accomodation = $request->getParam('accomodation');

        if(null != $username && null != $accomodation && $username == Zend_Auth::getInstance()->getIdentity()->username) {
            if(1 == count($this->_profileModel->getProfile($username)) && 1 == count($this->_accomodationModel->getAccomodation($accomodation))
                && 0 == count($this->_accomodationModel->getOption($username, $accomodation))) {
                $this->_accomodationModel->setOption($username, $accomodation);
            }
        }

        $this->_helper->redirector('get', 'accomodation', null, array('id' => $accomodation));
    }

    public function deoptionAction() {
        $request = $this->_request;

        $username = $request->getParam('username');
        $accomodation = $request->getParam('accomodation');

        if(null != $username && null != $accomodation && $username == Zend_Auth::getInstance()->getIdentity()->username) {
            if(1 == count($this->_profileModel->getProfile($username)) && 1 == count($this->_accomodationModel->getAccomodation($accomodation))
                && 1 == count($this->_accomodationModel->getOption($username, $accomodation))) {
                $this->_accomodationModel->unsetOption($username, $accomodation);
            }
        }

        $this->_helper->redirector('get', 'accomodation', null, array('id' => $accomodation));
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
            $accomodations = $this->_accomodationModel->getLatestAccomodations(4);
        }

        for($i=0; $i<count($accomodations); $i++) {
            $lessers[] = $this->_profileModel->getProfile($accomodations[$i]->lesser);
            $photos[] = $this->_accomodationModel->getPhotosForAccomodation($accomodations[$i]->id);
            $types[] = $this->_accomodationModel->getAccType($accomodations[$i]->id);
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