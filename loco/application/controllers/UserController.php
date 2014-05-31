<?php

class UserController extends Zend_Controller_Action
{
    protected $_default_profile_image;

    protected $_loginForm;
    protected $_profileModel;

    public function init()
    {
        $this->_default_profile_image = APPLICATION_PATH . "/../public/img/default_profile.jpg";
    }

    public function indexAction()
    {
        $this->_helper->layout->setLayout("private");
    }

    public function registerAction() {
        $this->_helper->layout->setLayout("public");

        $this->_profileModel = new Application_Model_Profile();

        $registrationForm = new Application_Form_Registration();
        $request = $this->getRequest();
        $keys = array('username', 'password', 'email', 'name', 'surname', 'birth', 'sex', 'cf', 'profile_image', 'role', 'phone');

        if($request->isPost()) {
            if($registrationForm->isValid($request->getParams())) {

                /*
                echo "keys to be preserved => " . print_r($keys);
                echo "request array => " . print_r($request->getParams());
                echo "stuff that goes to db => " . print_r(array_intersect_key($request->getParams(), array_flip($keys)));
                */

                if(0 === $this->_profileModel->getProfile($request->getParam('username'))->count()) {
                    $upload = new Zend_File_Transfer_Adapter_Http();
                    $image_file = null;

                    $profile_data = array_intersect_key($request->getParams(), array_flip($keys));

                    if($upload->isValid("profile_image")) {
                        $upload->receive("profile_image");
                        $profile_data['profile_image'] = file_get_contents($upload->getFileName("profile_image"));
                    } else {
                        $profile_data['profile_image'] = file_get_contents($this->_default_profile_image);
                    }

                    $this->_profileModel->addProfile($profile_data);

                    $this->view->message = 'La registrazione è andata a buon fine';
                } else {
                    $this->view->message = 'Utente ' . $request->getParam('username') . ' già esiste. Riprova';
                }
            } else {
                $this->view->message = 'I dati inseriti non sono corretti, riprova';
            }
        } else {
            $this->view->message = 'Inserisci i dati necessari per la registrazione';
        }

        $this->view->registrationForm = $registrationForm;
    }

    public function loginAction() {
        $request = $this->getRequest();
        $form = null;

        $this->_helper->layout->setLayout("public");

        $this->_profileModel = new Application_Model_Profile();

        $urlHelper = $this->_helper->getHelper("url");
        $actionUrl = $urlHelper->url(array(
                'controller' => 'user',
                'action' => 'login'),
            'default'
        );

        $form = new Application_Form_Login();
        $form->setAction($actionUrl);
        $this->_loginForm = $form;

        if($request->isPost()) {

            //Check whether all the form parameters were passed in the request
            if($this->_loginForm->isValid($request->getPost())) {

                //Set up authenitication adapter to work with the same DB adapter as user for our models
                $dbAdapter = Zend_Db_Table::getDefaultAdapter();
                $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

                //Set table used for authentication and columns in which we store username and password
                $authAdapter->setTableName("profile")
                    ->setIdentityColumn("username")
                    ->setCredentialColumn("password");

                //Pass username and password read from submitted form to the authentication adapter
                $authAdapter->setIdentity($this->_loginForm->getValue("username"))
                    ->setCredential($this->_loginForm->getValue("password"));

                //Get an instance of Zend_Auth singleton
                $auth = Zend_Auth::getInstance();

                //Perform the authentication using the authentication adapter built before
                $result = $auth->authenticate($authAdapter);

                if($result->isValid()) {    //Authentication is successful

                    //Save authenticated user tuple into his session, so we can access username / role / email etc.
                    $auth->getStorage()->write($authAdapter->getResultRowObject());

                    //Go to profile page
                    $this->_helper->redirector("search", "accomodation");

                } else {    //Authentication failed

                    $this->view->message = "Autenticazione fallita, riprova.";

                    //Show the form again
                    //$this->render("login");
                }
            } else {    //Form parameters are wrong
                $this->view->message = "Il login non è corretto. Riprova";
            }
        }

        $this->view->loginForm = $form;
    }

    public function logoutAction() {
        $this->_helper->layout->setLayout("public");

        Zend_Auth::getInstance()->clearIdentity();

        $this->_helper->redirector("index", "loco");
    }

    public function profileViewAction() {
        $username = null;
        $profile = null;

        $this->_helper->layout->setLayout("private");

        $username = Zend_Auth::getInstance()->getIdentity()->username;

        $this->_profileModel = new Application_Model_Profile();

        $profile = $this->_profileModel->getProfile($username);

        $this->view->profile_info = $profile[0];
    }

    public function profileEditAction() {
        $this->_helper->layout->setLayout("private");

        $profileEditForm = null;
        $request = $this->_request;
        $profileData = null;
        $upload = null;

        $keys = array("name", "surname", "email", "birth", "sex", "cf", "phone");

        $upload = new Zend_File_Transfer_Adapter_Http();
        $profileEditForm = new Application_Form_ProfileEdit();
        $this->_profileModel = new Application_Model_Profile();
        $profileData = $this->_profileModel->getProfile(Zend_Auth::getInstance()->getIdentity()->username);
        $this->view->profile_info = $profileData[0];
        $profileData = $profileData[0]->toArray();

        if($request->isPost()) {
            if($profileEditForm->isValid($request->getParams())) {
                foreach($keys as $k)
                    $profileData[$k] = $request->getParam($k);

                if(null != $request->getParam("password"))
                    $profileData['password'] = $request->getParam('password');

                if($upload->isValid('profile_image')) {
                    $upload->receive('profile_image');
                    $profileData['profile_image'] = file_get_contents($upload->getFileName('profile_image'));
                }

                $this->_profileModel->updateProfile($profileData['username'], $profileData);

                $this->view->message = "L'aggiornamento del profilo è andato a buon file";
            } else $this->view->message = "I dati inseriti non sono corretti. Riprova";
        } else {
            $this->view->message = "Modifica del profilo utente";
        }

        $profileEditForm->populate($profileData);

        $this->view->form = $profileEditForm;
    }

    public function viewAllAction() {
        $this->_helper->layout->setLayout("private");

        $this->_profileModel = new Application_Model_Profile();

        $this->view->allProfiles = $this->_profileModel->getAllProfiles();
    }

    public function deleteAction() {
        $request = $this->_request;
        $username = $request->getParam('username');
        $confirm = $request->getParam('confirm');

        $this->_profileModel = new Application_Model_Profile();

        if(isset($username) && count($this->_profileModel->getProfile($username)) == 1) {
            if(isset($confirm) && $confirm == 'yes') {
                $this->_profileModel->deleteProfile($username);
                $this->view->message = "Profilo eliminato";
            } else $this->view->message = "Devi confermare l'eliminazione profilo utente";
        }
         else
            $this->view->message = "Devi specificare l'utente da eliminare";

    }
}