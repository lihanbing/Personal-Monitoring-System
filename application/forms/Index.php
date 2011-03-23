<?php


/**
 * Thsi is to print the login form
 * 
 * @author sergii
 *
 */
class Application_Form_Index extends Zend_Form
{

    public function init()
    {
         // Set the method for the display form to POST
        $this->setMethod('post');
        
        $this->setAttrib('id', 'login');
 
        // Add an email element
        $this->addElement('text', 'useremail', array(
            'label'      => 'Login name',
        	'size'		 => '15',
        ));
         
        $this->addElement('password', 'password', array(
            'label'      => 'Password',
        	'size'		 => '15',
            'required'   => true,
       
        ));
        
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Login',
        ));
 
       // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }


}

