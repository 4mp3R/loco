<?php

class UserController extends Zend_Controller_Action
{
    protected $_default_profile_image;

    protected $_loginForm;
    protected $_profileModel;

    public function init()
    {
        $this->_default_profile_image = APPLICATION_PATH . "/../public/img/default_profile.jpg";
        $this->_profileModel = new Application_Model_Profile();
    }

    public function indexAction()
    {
        $this->_helper->layout->setLayout("private");
    }

    public function registerAction() {
        $this->_helper->layout->setLayout("public");

        $registrationForm = new Application_Form_Registration();
        $request = $this->getRequest();
        $keys = array('username', 'password', 'email', 'name', 'surname', 'birth', 'sex', 'cf', 'profile_image', 'role', 'phone');

        if($request->isPost()) {
            if($registrationForm->isValid($request->getParams())) {
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

                    $this->_helper->redirector('login', 'user');
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

                    //Go to appropriate page
                    if($auth->getIdentity()->role == 'admin') $this->_helper->redirector("statistics", "loco");
                    elseif($auth->getIdentity()->role == 'lessee') $this->_helper->redirector("search", "accomodation");
                    elseif($auth->getIdentity()->role == 'lesser') $this->_helper->redirector("index", "accomodation");

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

        $username = $this->_request->getParam('username');

        if(null === $username || 1 != count($this->_profileModel->getProfile($username)))
            $username = Zend_Auth::getInstance()->getIdentity()->username;

        $profile = $this->_profileModel->getProfile($username);

        $this->view->profile_info = $profile[0];
    }

    public function profileEditAction() {
        $this->_helper->layout->setLayout("private");

        $profileEditForm = null;
        $request = $this->_request;
        $profileData = null;
        $upload = null;
        $profileDataArray = array();

        $keys = array("name", "surname", "email", "birth", "sex", "cf", "phone");

        $upload = new Zend_File_Transfer_Adapter_Http();
        $profileEditForm = new Application_Form_ProfileEdit();
        $this->_profileModel = new Application_Model_Profile();

            $username = $request->getParam('username');

            if(null != $username && 1 == count($this->_profileModel->getProfile($username))) {

                if($username == Zend_Auth::getInstance()->getIdentity()->username || 'admin' == Zend_Auth::getInstance()->getIdentity()->role) {

                    $profileData = $this->_profileModel->getProfile($username);

                    if(null != $request->getParam('name') && $profileEditForm->isValid($request->getParams())) {
                        $profileDataArray['username'] = $profileData[0]->username;
                        echo "<h1>TEST</h1>";
                        foreach($keys as $k)
                            $profileDataArray[$k] = $request->getParam($k);

                        if(null != $request->getParam("password"))
                            $profileDataArray['password'] = $request->getParam('password');

                        if($upload->isValid('profile_image')) {
                            $upload->receive('profile_image');
                            $profileDataArray['profile_image'] = file_get_contents($upload->getFileName('profile_image'));
                        }

                        $this->_profileModel->updateProfile($profileDataArray, $profileDataArray['username']);

                        if('admin' == Zend_Auth::getInstance()->getIdentity()->role)
                            $this->_helper->redirector('view-all', 'user');
                        else
                            $this->_helper->redirector('profile-view', 'user');

                    }
                }
                else {
                    $profileData = $this->_profileModel->getProfile(Zend_Auth::getInstance()->getIdentity()->username);
                }
            } else {
                $profileData = $this->_profileModel->getProfile(Zend_Auth::getInstance()->getIdentity()->username);
            }



        $profileEditForm->populate($profileData[0]->toArray());

        $this->view->form = $profileEditForm;
        $this->view->profile_info = $profileData[0];
    }

    public function viewAllAction() {
        $this->_helper->layout->setLayout("private");

        $page = $this->_request->getParam('page');
        if(!is_numeric($page)) $page = null;

        $this->_profileModel = new Application_Model_Profile();

        $this->view->allProfiles = $this->_profileModel->getAllProfiles($page);
    }

    public function deleteAction() {
        $username = $this->_request->getParam('username');

        $this->_profileModel = new Application_Model_Profile();

        if(isset($username) && count($this->_profileModel->getProfile($username)) == 1) {
            $this->_profileModel->deleteProfile($username);

            $this->_helper->redirector('view-all', 'user');
        }
         else
            $this->_helper->redirector('view-all', 'user');

    }
}