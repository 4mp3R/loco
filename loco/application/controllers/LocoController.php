<?php

class LocoController extends Zend_Controller_Action
{

    protected $_staticsModel;
    protected $_accomodationModel;
    protected $_faqForm;

    public function init() {
        $this->_helper->layout->setLayout("public");

        $this->_staticsModel = new Application_Model_Statics();
        $this->_accomodationModel = new Application_Model_Accomodation();
        $this->_faqForm = new Application_Form_Faq();
    }

    public function indexAction() {
        if(Zend_Auth::getInstance()->hasIdentity())
            $this->_helper->layout->setLayout("private");
    }

    public function faqViewAction() {
        $this->view->faq = $this->_staticsModel->getFaq();
    }

    public function faqEditAction() {
        $request = $this->_request;
        $this->_helper->layout->setLayout("private");

        $formParams = array(
            'id' => $request->getParam('id'),
            'question' => $request->getParam('question'),
            'answer' => $request->getParam('answer')
        );


        if(null != $formParams['id']) {
            if(null != $formParams['question'] && null != $formParams['answer']) {
                if($this->_faqForm->isValid($formParams) && 1 == count($this->_staticsModel->getFaqItem($formParams['id'])))
                    $this->_staticsModel->updateFaq($formParams);

                $this->_helper->redirector('faq-edit', 'loco');
            } else {
                if(null == $formParams['id'])
                    $this->_helper->redirector("faq-edit", "loco");

                $faqItem = $this->_staticsModel->getFaqItem($formParams['id']);

                $this->_faqForm->getElement('question')->setValue($faqItem[0]->question);
                $this->_faqForm->getElement('answer')->setValue($faqItem[0]->answer);
                $this->_faqForm->getElement('id')->setValue($faqItem[0]->id);

                $this->view->form = $this->_faqForm;
            }
        } else {
            $faq = $this->_staticsModel->getFaq();

            $this->view->faq = $faq;
        }
    }

    public function faqAddAction() {
        $this->_helper->layout->setLayout("private");

        $request = $this->_request;

        $formParams = array(
            'question' => $request->getParam('question'),
            'answer' => $request->getParam('answer')
        );

        if(null != $formParams['question'] && null != $formParams['answer']) {
            if($this->_faqForm->isValid($formParams))
                $this->_staticsModel->addFaq($formParams);

                $this->_helper->redirector('faq-edit', 'loco');
        } else {
            $this->view->form = $this->_faqForm;
        }
    }

    public function faqDeleteAction() {
        $id = $this->_request->getParam('id');

        if(null != $id && 1 == count($this->_staticsModel->getFaqItem($id)))
            $this->_staticsModel->deleteFaq($id);

        $this->_helper->redirector("faq-edit", "loco");
    }

    public function supportViewAction() {
    }

    public function settingsAction() {
        $request = $this->_request;
        $this->_helper->layout->setLayout("private");

        //faq
        $formParams = array(
            'id' => $request->getParam('id'),
            'question' => $request->getParam('question'),
            'answer' => $request->getParam('answer')
        );


        if(null != $formParams['id']) {
            if(null != $formParams['question'] && null != $formParams['answer']) {
                if($this->_faqForm->isValid($formParams) && 1 == count($this->_staticsModel->getFaqItem($formParams['id'])))
                    $this->_staticsModel->updateFaq($formParams);

                $this->_helper->redirector('faq-edit', 'loco');
            } else {
                if(null == $formParams['id'])
                    $this->_helper->redirector("faq-edit", "loco");

                $faqItem = $this->_staticsModel->getFaqItem($formParams['id']);

                $this->_faqForm->getElement('question')->setValue($faqItem[0]->question);
                $this->_faqForm->getElement('answer')->setValue($faqItem[0]->answer);
                $this->_faqForm->getElement('id')->setValue($faqItem[0]->id);

                $this->view->form = $this->_faqForm;
            }
        } else {
            $faq = $this->_staticsModel->getFaq();

            $this->view->faq = $faq;
        }

        //Types
        $types = $this->_accomodationModel->getTypes();

        $data = array();

        foreach($types as $t) {
            $features = $this->_accomodationModel->getFeaturesByType($t->id);
            $data[] = array('type' => $t, 'features' => $features);
        }

        $this->view->data = $data;
    }

    public function statisticsAction() {
        $this->_helper->layout->setLayout("private");

        $form = new Application_Form_Statistics();
        $request = $this->_request;

        $from = $request->getParam('from');
        $to = $request->getParam('to');
        $type_id = $request->getParam('type_id');

        if(!$form->isValid($request->getParams())) {
            $from = null;
            $to = null;
            $type_id = null;
        }

        if($type_id == 'none') $type_id = null;

        $accomodationModel = new Application_Model_Accomodation();

        $accomodations = $accomodationModel->getAccomodationsByIntervalAndType($from, $to, $type_id);

        $options = $accomodationModel->getOptionsByIntervalAndType($from, $to, $type_id);

        $typeName = null;

        if(null != $type_id) {
            $accomodationTypeModel = new Application_Model_Resources_Accomodationtype();
            $type = $accomodationTypeModel->getAccomodationType($type_id);
            $typeName = $type[0]->name;
        }

        $optioned = array();
        $located = array();

        foreach($options as $o) {
            if($o['option']->state == 'optioned') $optioned[] = $o;
            else $located[] = $o;
        }

        $profileModel = new Application_Model_Profile();
        $users = $profileModel->getAllProfiles();
        $this->view->user_count = count($users);

        $accomodations = $accomodationModel->getAllAccomodations();
        $this->view->accomodation_count = count($accomodations);

        $located_accomodation_count = 0;
        $optionModel = new Application_Model_Resources_Option();
        $options = $optionModel->getOptionsByInterval(null, null, null);
        foreach($options as $o)
            if($o->state == 'located')
                $located_accomodation_count++;
        $this->view->located_accomodation_count = $located_accomodation_count;

        $this->view->from = $from;
        $this->view->to = $to;
        $this->view->typeName = $typeName;

        $this->view->accomodations = $accomodations;
        $this->view->optioned = $optioned;
        $this->view->located = $located;

        $this->view->form = $form;
    }
}