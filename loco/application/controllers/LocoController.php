<?php

class LocoController extends Zend_Controller_Action
{

    protected $_staticsModel;
    protected $_faqForm;

    public function init() {
        $this->_helper->layout->setLayout("public");

        $this->_staticsModel = new Application_Model_Statics();
        $this->_faqForm = new Application_Form_Faq();
    }

    public function indexAction() {
        // action body
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
                if($this->_faqForm->isValid($formParams))
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

        if(null != $id)
            $this->_staticsModel->deleteFaq($id);

        $this->_helper->redirector("faq-edit", "loco");
    }

    public function supportViewAction() {
    }

    public function settingsAction() {
        $this->_helper->layout->setLayout('private');
    }
/*
    public function statisticsAction() {
        $this->_helper->layout->setLayout('private');

        $statistics = array();

        $profileModel = new Application_Model_Profile();
        $accomodationModel = new Application_Model_Accomodation();
        $messageModel = new Application_Model_Message();

        $request = $this->_request;
        $from = $request->getParam('from');
        $to = $request->getParam('to');
        $type = $request->getParam('type');

        if(null == $from || null == to) {
            $users = $profileModel->getAllProfiles();
            $statistics['user_count'] = array('Numero utenti' => count($users));

            $statistics['admin_count'] = array('Numero amministratori' => count($users));
            $statistics['lesser_count'] = array('Numero locatori' => 0);
            $statistics['lessee_count'] = array('Numero locatari' => 0);

            foreach($users as $u) {
                if('admin' == $u->role) $statistics['admin_count']['Numero amministratori']++;
                else if('lesser' == $u->role) $statistics['lesser_count']['Numero locatori']++;
                else $statistics['lessee_count']['Numero locatari']++;
            }

            $accomodations = $accomodationModel->getAllAccomodations();
            $statistics['accomodation_count'] = array('Numero annunci' => count($accomodations));

            $accomodationTypes = $accomodationModel->getTypes();

            foreach($accomodationTypes as $t) {
                for($i=0; $i<count($accomodations); $i++)
                    if($accomodations[$i]->type == $t->id)
                    if(!isset($statistics[$t->name])) $statistics[$t->name] = array('Numero annunci per la tipologia '.$t->name => 1);
                    else $statistics[$t->name]['Numero annunci per la tipologia '.$t->name]++;
            }

            $statistics['message_count'] = array('Numero messaggi memorizzati' => count($messageModel->getAllMessages()));
        } else {

        }

        $this->view->statistics = $statistics;
    }
*/

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

        $this->view->from = $from;
        $this->view->to = $to;
        $this->view->typeName = $typeName;

        $this->view->accomodations = $accomodations;
        $this->view->optioned = $optioned;
        $this->view->located = $located;

        $this->view->form = $form;
    }
}