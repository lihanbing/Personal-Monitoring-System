<?php

class Application_Model_AddUserMapper
{
 
    public function save(Application_Model_AddUser $user, $update_password = true)
    {
 		//foreach (get_class_methods)
        $data = array(
        	'accessLevelId' => $user->getAccessLevelID(),
            'forename'   => $user->getForename(),
            'surname' => $user->getSurname(),
        	'email' => $user->getEmail(),
            'dateCreated' => $user->getDateCreated(),
        );
        
        if ($update_password)
        	$data = array_merge(array('password' => $user->getPassword()),$data);

        $db = Zend_Registry::get("db");
        if (null === ($id = $user->getUser_Id())) {
            unset($data['user_id']);
            $db->insert('users',$data);
        } else {
            $db->update('users',$data, array('user_id = ?' => $id));
        }
        
    }
    
    
 

 


}

