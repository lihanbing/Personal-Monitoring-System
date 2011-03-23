<?php

class IndexController extends Zend_Controller_Action
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
                $auth = Zend_Auth::getInstance();
                
                $this->view->headTitle('Personal Monitoring System');
                $this->view->render('_login_window.phtml');
                $this->view->headLink()->appendStylesheet('/css/global.css');
    }

    public function signAction()
    {
        $this->view->headTitle('Personal Monitoring System');
                $this->view->render('_login_window.phtml');
                $this->view->headLink()->appendStylesheet('/css/global.css');
                
                $form    = new Application_Form_Index();
               	$this->view->form = $form;
               	
                if($this->getRequest()->isPost()){
                    if($form->isValid($_POST)){
                        $data = $form->getValues();
        				$user = new Application_Model_User($data['useremail']);
        				
                        if($user->isUserPasswordValid($data['password'])){
                            $storage = new Zend_Auth_Storage_Session();
                            $storage->write(array('user_id' => $user->user_id));
                            $this->_redirect('index/index');
                        } else {
                            $this->view->errorMessage = "Invalid username or password. Please try again.";
                        }         
                    }
                }
    }

    public function logoutAction()
    {
        $storage = new Zend_Auth_Storage_Session();
                $storage->clear();
                $this->_redirect('index/sign');
    }




}





