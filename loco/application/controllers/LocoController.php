<?php

class LocoController extends Zend_Controller_Action
{

    protected $_staticsModel;

    public function init() {
        $this->_helper->layout->setLayout("public");

        $this->_staticsModel = new Application_Model_Statics();
    }

    public function indexAction() {
        // action body
    }

    public function faqViewAction() {
        $this->view->faq = $this->_staticsModel->getFaq();
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
        $request = $this->_request;

        $from = $request->getParam('from');
        $to = $request->getParam('to');
        $type_id = $request->getParam('type_id');

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
    }
}