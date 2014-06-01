<?php

class TestController extends Zend_Controller_Action {

    protected $_testModel;

    public function init() {
        $this->_testModel = new Application_Model_Test();
        $this->_helper->layout->setLayout("public");
    }

    public function indexAction() {
        $this->_helper->redirector("get","test");
    }

    public function getAction() {
        $this->view->faq = $this->_testModel->getFaq();
    }

    public function addAction() {
        $question = $this->_request->getParam("question");
        $answer = $this->_request->getParam("answer");

        if(isset($question) && isset($answer)) {
            $this->_testModel->addFaq(
                array("question" => $question,
                    "answer" => $answer
                )
            );
        }

        $this->_helper->redirector("get", "test");
    }

    public function updateAction() {
        $id = $this->_request->getParam("id");
        $question = $this->_request->getParam("question");
        $answer = $this->_request->getParam("answer");

        if(isset($id) && isset($question) && isset($answer)) {
            $this->_testModel->updateFaq(
                $id,
                array(
                    "question" => $question,
                    "answer" => $answer
                )
            );
        }

        $this->_helper->redirector("get", "test");
    }

    public function deleteAction() {
        $id = $this->_request->getParam("id");

        if(isset($id)) {
            $this->_testModel->deleteFaq($id);
        }

        $this->_helper->redirector("get", "test");
    }

}