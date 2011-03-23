<?php

class MyAccountController extends Zend_Controller_Action
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
                $this->view->headLink()->appendStylesheet('/css/global.css');
                $user = new Application_Model_User($data['user_id']);
                $user->getAllUserData();
                $this->view->user = $user;
    }

    public function editAction()
    {
	     $storage = new Zend_Auth_Storage_Session();
	     $data = $storage->read();
	     if(!$data){
	     	$this->_redirect('index/sign');
	     }
    	 $form    = new Application_Form_AddUser(array('edit' => true));
     	 $request = $this->getRequest();
             	
    	if ($this->getRequest()->isPost()) {
    		if ($form->isValid($request->getPost())) {
			    $user_object = new Application_Model_User($data['user_id']);
				$user_object->getAllUserData();
				$user_data_array = get_object_vars($user_object);
				/**
				 *  when we update the data, we do not update all the data. Current model is working in a way that all fields need to be present for update.
				 *  If some fields are missing then code will put them to null. For ex. when I update name password will be set to zero. 
				 *  For this reason we first get all the user data and then change some of this data and only after update then in the database.
				 */
				foreach ($form->getValues() as $field => $value)
					$user_data_array[$field] = $value;
		        	
			    $comment = new Application_Model_AddUser($user_data_array);
			    $mapper  = new Application_Model_AddUserMapper();
			    $mapper->save($comment,false);
    			return $this->_helper->redirector('index');
   			 }
   		 }
                
                $this->view->headTitle('Personal Monitoring System');
                $this->view->render('_login_window.phtml');
                $this->view->headLink()->appendStylesheet('/css/global.css');
                $user = new Application_Model_User($data['user_id']);
                $user->getAllUserData();
        		$user = get_object_vars($user); // conver user object data to the array data, in order to pass it into the populate method if the form object
               
                $form->populate($user);
                $this->view->form = $form;
    }

    public function changePasswordAction()
    {
    	$storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
        	$this->_redirect('index/sign');
        }
        $form    = new Application_Form_ChangePassword();
        $form->populate(array('user_id' => $data['user_id']));
        $request = $this->getRequest();
         if ($this->getRequest()->isPost()) {
         	
	         if ($form->isValid($request->getPost())) {
	         	
	         	 $data_from_form = $form->getValues();
		         $user_object = new Application_Model_User($data_from_form['user_id']);
		         $user_object->getAllUserData();
		         $password = $user_object->CheckOldPasswordAndNewPasswords($data_from_form['old_password'],$data_from_form['new_password'],$data_from_form['repeat_new_password']);
		         $user_data_array = get_object_vars($user_object);
		         $user_data_array['password'] = $password;
		        //Application_Model_AddUser object takes an array as input parameter. Now we want to modify only the password, so we specify the password and user id
		         $comment = new Application_Model_AddUser($user_data_array);
		         $mapper  = new Application_Model_AddUserMapper();
		         $mapper->save($comment);
		         return $this->_helper->redirector('index');

	         }
         }
            
        
        $this->view->headLink()->appendStylesheet('/css/global.css');
        
        $this->view->form = $form;
    }


}





