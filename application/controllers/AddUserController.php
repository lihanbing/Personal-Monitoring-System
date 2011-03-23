<?php

class AddUserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	$storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
        	$this->_redirect('index/sign');
         }
    	
    	
        $form    = new Application_Form_AddUser();
        $this->view->form = $form;
    }

    public function signAction()
    {
    	
    	$storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
        	$this->_redirect('index/sign');
         }
    	
    	
        $request = $this->getRequest();
        $form    = new Application_Form_AddUser();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $comment = new Application_Model_AddUser($form->getValues());
                $mapper  = new Application_Model_AddUserMapper();
                $mapper->save($comment);
                return $this->_helper->redirector('index');
            }
        }
        $this->view->headTitle('Personal Monitoring System');
        $this->view->render('_login_window.phtml');
        $this->view->headLink()->appendStylesheet('/css/global.css');
 
        $this->view->form = $form;
    }


}



