<?php

class Application_Form_AddUser extends Zend_Form
{
	
	
	/**
	 * Creates add/edit user form. If this is an edit form then user object will be given to the class, 
	 * so that user data can be displayed 
	 * 
	 */
    public function init()
    {
    	
        // Set the method for the display form to POST
        $this->setMethod('post');
 
        // Add an email element
        $this->addElement('text', 'forename', array(
            'label'      => 'User forename',
        ));
         
        $this->addElement('text', 'surname', array(
            'label'      => 'User surname',
            'required'   => true,
       
        ));
        
        
 
 	 	 // Add an email element
        $this->addElement('text', 'email', array(
            'label'      => 'User email address:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            )
        ));
        
         if (isset($this->_attribs['edit']))
         {
         	 $this->addElement('hidden', 'user_id', array(
       
        	));
         }
        
        
        // if this is an edit form that do not print password and access level fileds as to change the password we will use different form
        if (!isset($this->_attribs['edit']))
        {
		    $user_access_level = new Zend_Form_Element_Select('accessLevelId');
			$user_access_level->setLabel('User access level')
			         ->setRequired(true);
			 
			$db = Zend_Registry::get("db");
			$query = "SELECT * FROM user_access_levels";
			foreach ($db->fetchAll($query) as $c) {
				//print_r($c);
			    $user_access_level->addMultiOption($c['access_level_id'], $c['access_level_description']);
			}
	        
			$this->addElement($user_access_level);
			
	        // Add an email element
	        $this->addElement('password', 'password', array(
	            'label'      => 'User password:',
	            'required'   => true,
	            'filters'    => array('StringTrim'),
	        ));
	                
        }
        
        // Add the submit button
        if (isset($this->_attribs['edit']))
        	$submit_button_name = "Edit my account";
        else
        	$submit_button_name = "Add user";	
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => $submit_button_name,
        ));
 
       // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }


}

