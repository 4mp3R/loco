<?php

class UserController extends Zend_Controller_Action
{
    protected $_loginForm;
    protected $_profileModel;

    public function init()
    {
        $this->_helper->layout->setLayout("public");

        $this->_profileModel = new Application_Model_Profile();

        $urlHelper = $this->_helper->getHelper("url");
        $actionUrl = $urlHelper->url(array(
                'controller' => 'user',
                'action' => 'authenticate'),
            'default'
        );

        $form = new Application_Form_Login();
        $form->setAction($actionUrl);

        $this->_loginForm = $form;

        $this->view->loginForm = $form;
    }

    public function indexAction()
    {
        $this->_helper->layout->setLayout("private");
    }

    public function registerAction() {
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
                    $this->_profileModel->addProfile(array_intersect_key($request->getParams(), array_flip($keys)));

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
        $this->view->loginMessage = "Per favore, esegua il log in";
    }

    public function authenticateAction() {
        $request = $this->getRequest();

        //Accept only post reuqests for authenitication procedure
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
                    $this->_helper->redirector("index", "user");

                } else {    //Authentication failed

                    $this->view->loginMessage = "Autenticazione fallita, riprova.";

                    //Show the form again
                    $this->render("login");
                }
            } else {    //Form parameters are wrong
                $this->_helper->redirector("index", "loco");
            }
        } else {    //If current request wasn't made by POST, go back to the home page
            $this->_helper->redirector("index", "loco");
        }
    }

    public function logoutAction() {
        Zend_Auth::getInstance()->clearIdentity();

        $this->_helper->redirector("index", "loco");
    }

    public function profileViewAction() {

    }

    public function profileEditAction() {

    }

    public function viewAllAction() {

    }

    public function addAction() {

    }

    public function deleteAction() {

    }
}