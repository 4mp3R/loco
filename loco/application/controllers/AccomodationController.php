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

        $options = $this->_accomodationModel->getOptionsByAccomodation($id);
        $interestedLessees = array();

        foreach($options as $o) {
            $lessee = $this->_profileModel->getProfile($o->lessee);
            $interestedLessees[] = $lessee[0];
        }

        $this->view->interestedLessees = $interestedLessees;
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

            //add generic accomodation data
            $this->_accomodationModel->addAccomodation(array_intersect_key($request->getParams(), array_flip($generalAccomodationParams)));
            $id = $this->_accomodationModel->accomodationLastInsertId();

            //add specific accomodation data
            foreach($specificAccomodationParams as $sp) {
                $this->_accomodationModel->addAccomodationdata(array(
                    'accomodation' => $id,
                    'feature_id' => $sp['id'],
                    'feature_value' => $request->getParam($sp['form_name'])
            ));
            }

            //add accomodation photos
            $upload = new Zend_File_Transfer_Adapter_Http();
            $files = $upload->getFileInfo();


            foreach($files as $file=>$fileinfo) {
                if($upload->isUploaded($file)){
                    if($upload->isValid($file)) {
                        if($upload->receive($file)) {
                            $info = $upload->getFileInfo($file);
                            $tmp = $info[$file]['tmp_name'];
                            $this->_accomodationModel->addPhotoForAccomodation($id, file_get_contents($tmp));
                        }
                    }
                }
            }

            $this->_helper->redirector('index', 'accomodation');
        } else {
            $this->view->form = $this->_accomodationForm;
        }
    }


    public function editAction() {
        $request = $this->_request;

        $accomodation_id = $request->getParam('accomodation');

        if(null != $accomodation_id && 1 == count($this->_accomodationModel->getAccomodation($accomodation_id))) {
            if(null == $request->getParam('title')) {   //visualizzare la form riempita
                $accomodationGenericInfo = $this->_accomodationModel->getAccomodation($accomodation_id);
                $accomodationData = $this->_accomodationModel->getAccomodationdata($accomodation_id);
                $type = $this->_accomodationModel->getAccomodationType($accomodationGenericInfo[0]->type);

                $data = $accomodationGenericInfo[0]->toArray();
                $data['fee'] = str_replace('.', ',', $data['fee']);

                foreach($accomodationData as $ad) {
                    $feature = $this->_accomodationModel->getAccomodationfeature($ad->feature_id);

                    $value = $ad->feature_value;
                    if($feature[0]->data_type == 'bool' && $value != '0')
                        $value = '1';

                    $data[str_replace(' ', '_', $type[0]->name.'_'.$feature[0]->name)] = $value;
                }

                //load accomodation's photos
                $photos = $this->_accomodationModel-> getPhotosForAccomodation($accomodation_id);

                $this->_accomodationForm->populate($data);
                $this->_accomodationForm->getElement('submit')->setLabel('Aggiorna');

                $this->view->form = $this->_accomodationForm;
                $this->view->photos = $photos;
            } else {    //salvare le modifiche
                $acc = $this->_accomodationModel->getAccomodation($accomodation_id);
                if(($acc[0]->lesser == Zend_Auth::getInstance()->getIdentity()->username|| 'admin' == Zend_Auth::getInstance()->getIdentity()->role) && $this->_accomodationForm->isValid($request->getParams())) {
                    $keys = array('type', 'title', 'description', 'lesser', 'available_from', 'available_untill', 'zone', 'address', 'fee');
                    $generalParams = array_intersect_key($request->getParams(), array_flip($keys));
                    $generalParams['lesser'] = Zend_Auth::getInstance()->getIdentity()->username;

                    $features = $this->_accomodationModel->getFeaturesByType($generalParams['type']);
                    $specificParams = array();

                    $type = $this->_accomodationModel-> getAccomodationType($generalParams['type']);

                    foreach($features as $f) {
                        $specificParams[] = array('id' => $f->id, 'form_name' => str_replace(' ', '_', $type[0]->name.'_'.$f->name));
                    }

                    $this->_accomodationModel->updateAccomodation($accomodation_id ,$generalParams);

                    foreach($specificParams as $sp) {
                        $this->_accomodationModel->updateAccomodationdata(
                            $accomodation_id, $sp['id'], array(
                            'accomodation' => $accomodation_id,
                            'feature_id' => $sp['id'],
                            'feature_value' => $request->getParam($sp['form_name'])
                        ));

                    }

                    $upload = new Zend_File_Transfer_Adapter_Http();
                    $files = $upload->getFileInfo();


                    foreach($files as $file=>$fileinfo) {
                        if($upload->isUploaded($file)){
                            if($upload->isValid($file)) {
                                if($upload->receive($file)) {
                                    $info = $upload->getFileInfo($file);
                                    $tmp = $info[$file]['tmp_name'];
                                    $this->_accomodationModel->addPhotoForAccomodation($accomodation_id, file_get_contents($tmp));
                                }
                            }
                        }
                    }

                    $this->_helper->redirector('get', 'accomodation', null, array('id' => $accomodation_id));
                } else {
                    $this->view->form = $this->_accomodationForm;
                }
            }
        } else {
            $this->_helper->redirector('index', 'accomodation');
        }
    }

    public function deleteAction() {
        $id = $this->_request->getParam('id');

        if(null != $id) {
            $accomodation = $this->_accomodationModel->getAccomodation($id);

            if(1 == count($accomodation)) {
                $lesser = $accomodation[0]->lesser;

                if($lesser == Zend_Auth::getInstance()->getIdentity()->username
                || 'admin' == Zend_Auth::getInstance()->getIdentity()->role) {
                    $this->_accomodationModel->deleteAccomodationData($id);
                    $this->_accomodationModel->deleteAccomodationPhotos($id);
                    $this->_accomodationModel->deleteAccomodation($id);
                }
            }

        }

        if('admin' == Zend_Auth::getInstance()->getIdentity()->role)
            $this->_helper->redirector('view-all', 'accomodation');
        else
            $this->_helper->redirector('index', 'accomodation');

    }

    public function deletePhotoAction() {
        $id = $this->_request->getParam('id');

        if(null != $id && 1 == count($this->_accomodationModel->getPhoto($id))) {
            $photo = $this->_accomodationModel->getPhoto($id);
            $accomodation = $this->_accomodationModel->getAccomodation($photo[0]->accomodation);

            if($accomodation[0]->lesser == Zend_Auth::getInstance()->getIdentity()->username || 'admin' == Zend_Auth::getInstance()->getIdentity()->role) {
                $this->_accomodationModel->deleteAccomodationPhoto($id);
            }

            $this->_helper->redirector('edit', 'accomodation', array('accomodation' => $accomodation[0]->id));
        } else $this->_helper->redirector('index', 'error');

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
                if($request->getParam('type') == 'None') {
                    $accomodations = $this->_accomodationModel->searchGenericAccomodation($request->getParams());
                } else {

                }
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

    public function typeListAction() {
        $request = $this->_request;

        $types = $this->_accomodationModel->getTypes();

        $data = array();

        foreach($types as $t) {
            $features = $this->_accomodationModel->getFeaturesByType($t->id);
            $data[] = array('type' => $t, 'features' => $features);
        }

        $this->view->data = $data;
    }

    public function typeAddAction() {
        $request = $this->_request;

        $form = new Zend_Form();
        $form->setName('type_form');
        $form->setMethod('post');
        $form->setAttrib('class', 'form');

        $message = null;

        if(null == $request->getParam('name') || null == $request->getParam('feature_count')) { //form creazione nuova tipologia
            $message = "Inserisci il nome della nuova tipologia: ";

            $form->addElement('text', 'name', array(
                'filters' => array('StringTrim'),
                'validators' => array(
                    'Alpha',
                    array('StringLength', true, array(2, 128))
                ),
                'required' => true,
                'label' => 'Nome della tipologia'
            ));

            $form->addElement('text', 'feature_count', array(
                'filter' => array('StringTrim'),
                'validators' => array(
                    'Digits',
                    array('StringLength', true, array(1,2))
                ),
                'required' => true,
                'label' => 'Numero di proprietà'
            ));
        } else if(null == $request->getParam('complete')) { //form creazione nuove feature
            if($form->isValid($request->getParams())) {
                $name = $request->getParam('name');
                $feature_count = $this->getParam('feature_count');

                $form->addElement('hidden', 'complete', array(
                    'required' => true,
                    'value' => 'yes'
                ));

                $form->addElement('hidden', 'name', array(
                    'filters' => array('StringTrim'),
                    'validators' => array(
                        'Alpha',
                        array('StringLength', true, array(2, 128))
                    ),
                    'required' => true,
                    'value' => $name
                ));

                $form->addElement('hidden', 'feature_count', array(
                    'filter' => array('StringTrim'),
                    'validators' => array(
                        'Digits',
                        array('StringLength', true, array(1,2))
                    ),
                    'required' => true,
                    'value' => $feature_count
                ));

                for($i=0; $i<$feature_count; $i++) {
                    $form->addElement('text', 'feature'.$i, array(
                        'filter' => array('StringTrim'),
                        'validators' => array(array('StringLength', true, array(4,64))),
                        'required' => true,
                        'label' => 'Nome proprieta '.($i+1)
                    ));

                    $form->addElement('select', 'data_type'.$i, array(
                        'multiOptions' => array(
                            'bool' => 'Booleano',
                            'string' => 'Stringa',
                            'int' => 'Numero intero'
                        ),
                        'filter' => array('StringTrim'),
                        'validators' => array(array('StringLength', true, array(4,64))),
                        'required' => true,
                        'label' => 'Tipo di dato '.($i+1)
                    ));
                }
            }
        } else {    //inserimento nuova tupologia e features nel db
            $name = $request->getParam('name');
            $feature_count = $this->getParam('feature_count');

            $form->addElement('hidden', 'complete', array(
                'required' => true,
                'value' => 'yes'
            ));

            $form->addElement('hidden', 'name', array(
                'filters' => array('StringTrim'),
                'validators' => array(
                    'Alpha',
                    array('StringLength', true, array(2, 128))
                ),
                'required' => true,
                'value' => $name
            ));

            $form->addElement('hidden', 'feature_count', array(
                'filter' => array('StringTrim'),
                'validators' => array(
                    'Digits',
                    array('StringLength', true, array(1,2))
                ),
                'required' => true,
                'value' => $feature_count
            ));

            for($i=0; $i<$feature_count; $i++) {
                $form->addElement('text', 'feature'.$i, array(
                    'filter' => array('StringTrim'),
                    'validators' => array(array('StringLength', true, array(4,64))),
                    'required' => true,
                    'label' => 'Nome proprieta '.($i+1)
                ));

                $form->addElement('select', 'data_type'.$i, array(
                    'multiOptions' => array(
                        'bool' => 'Booleano',
                        'string' => 'Stringa',
                        'int' => 'Numero intero'
                    ),
                    'filter' => array('StringTrim'),
                    'validators' => array(array('StringLength', true, array(4,64))),
                    'required' => true,
                    'label' => 'Tipo di dato '.($i+1)
                ));
            }

            if($form->isValid($request->getParams())) {
                $this->_accomodationModel->addAccomodationType(
                    array('name' => $name)
                );

                $id = $this->_accomodationModel->accomodationTypeLastInsertedId();

                for($i=0; $i<$feature_count; $i++) {
                    $this->_accomodationModel->addFeature(array(
                        'type' => $id,
                        'name' => $request->getParam('feature'.$i),
                        'data_type' => $request->getParam('data_type'.$i)
                    ));
                }

                $this->_helper->redirector('type-list', 'accomodation');
            }
        }

        $form->addElement('submit', 'Vai');

        $this->view->form = $form;
        $this->view->message = $message;
    }

    public function typeEditAction() {
        $request = $this->_request;
        $type = $request->getParam('type');

        $form = new Zend_Form();
        $form->setName('type_form');
        $form->setMethod('post');
        $form->setAttrib('class', 'form');

        if(null != $type && 1 == count($this->_accomodationModel->getAccomodationType($type))) {
            $features = $this->_accomodationModel->getFeaturesByType($type);

            for($i=0; $i<count($features); $i++) {
                $form->addElement('text', 'feature_'.$features[$i]->id, array(
                    'filter' => array('StringTrim'),
                    'validators' => array(array('StringLength', true, array(4,64))),
                    'required' => true,
                    'label' => 'Nome proprieta '.($i+1),
                    'value' => $features[$i]->name
                ));

                $form->addElement('select', 'data_type_'.$features[$i]->id, array(
                    'multiOptions' => array(
                        'bool' => 'Booleano',
                        'string' => 'Stringa',
                        'int' => 'Numero intero'
                    ),
                    'filter' => array('StringTrim'),
                    'validators' => array(array('StringLength', true, array(4,64))),
                    'required' => true,
                    'label' => 'Tipo di dato '.($i+1),
                    'value' => $features[$i]->data_type
                ));
            }

            $form->addElement('hidden', 'complete', array(
                'required' => true,
                'value' => 'yes'
            ));
            $form->addElement('submit', 'Salva');

            if('yes' == $request->getParam('complete')) {
                for($i=0; $i<count($features); $i++) {

                    $this->_accomodationModel->updateFeature(array(
                        'id' =>  $features[$i]->id,
                        'type' => $type,
                        'name' => $request->getParam('feature_'.$features[$i]->id),
                        'data_type' => $request->getParam('data_type_'.$features[$i]->id)
                    ));

                    $this->_helper->redirector('type-list', 'accomodation');
                }
            }

            $this->view->type = $this->_accomodationModel->getAccomodationType($type);
            $this->view->form = $form;
        } else $this->_helper->redirector('type-list', 'accomodation');
    }

    public function typeDeleteAction() {
        $type = $this->_request->getParam('type');

        if(null != $type && 1 == count($this->_accomodationModel->getAccomodationType($type)))
            $this->_accomodationModel->deleteAccomodationType($type);

        $this->_helper->redirector('type-list', 'accomodation');
    }

    public function viewOptionsAction() {
        $username = Zend_Auth::getInstance()->getIdentity()->username;

        $message = null;

            $message = "Gli alloggi opzionati da te";

            $options = $this->_accomodationModel->getOptionsByUsername($username);

            $accomodations = array();

            foreach($options as $o) {
                $acc = $this->_accomodationModel->getAccomodation($o->accomodation);
                $accomodations[] = $acc[0];
            }
            $this->view->accomodations = $accomodations;
    }
}