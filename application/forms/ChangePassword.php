<?php

class Application_Form_ChangePassword extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
        
        $this->addElement('hidden', 'user_id', array());
        
        // Add an old password field
	    $this->addElement('password', 'old_password', array(
	            'label'      => 'Old password:',
	            'required'   => true,
	        ));
        // Add a new password field
        $this->addElement('password', 'new_password', array(
            'label'      => 'New password:',
            'required'   => true,
        ));
        // Add a field to repeat the password
        $this->addElement('password', 'repeat_new_password', array(
            'label'      => 'Repeat new password:',
            'required'   => true,
        ));
        
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Chnage password',
        ));
        
        
    }


}

