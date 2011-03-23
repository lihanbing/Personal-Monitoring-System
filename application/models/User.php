<?php

class Application_Model_User
{
	
	
	public $user_id;
	public $dateCreated;
	
	

	/**
	 * Class constructor
	 * 
	 */
	public function __construct($user_id)
	{
		if (is_numeric($user_id))
			$this->user_id = $user_id;
		else
			$this->user_id = $this->_getUserIdByEmail($user_id);
			
	}
	
	
	/**
	 * Function gets user id by email
	 * 
	 */
	public function _getUserIdByEmail($email)
	{
		 $db = Zend_Registry::get("db");
		 $query = "SELECT user_id FROM users WHERE email LIKE '$email'";
		 $result = $db->fetchAll($query);
		 if (count($result)>0)
		 	return $result[0]['user_id'];
		 else
		 	throw "Wrong email has been specified";
	}
	
	
	/**
	 * Checks if the input password is valid
	 * 
	 * @param unknown_type $password
	 */
	public function isUserPasswordValid($password)
	{
		$encrypted_password = $this->encrypt_user_password($password); // encrypted password for checking 
		//echo $encrypted_password;
		 $db = Zend_Registry::get("db");
		 $query = "SELECT password FROM users WHERE user_id = '{$this->user_id}'";
		 $result = $db->fetchAll($query);
		 if ($result[0]['password'] == $encrypted_password)
		 	return true;
		 else
		 	return false;	
		
	}
	
	
	/**
	 * Encrypt user password
	 * 
	 * @param int $password user password
	 * @param int $date_created date when user has registered on a wibsite
	 */
	public function encrypt_user_password($password,$date_created = null)
	{
		if (!isset($date_created))
    	{// if date_cteated has not been specifed then get the current time in the Unix format
			$this->_getUserDateCreated();
    	}
    		
    	$password = $this->encrypt_password($password);
    		
    	return $password;	
		
	}
	
    protected function encrypt_password($password)
    {
    	//create salt
    	$salt = md5('olololovzmyachneupyachneololol' . substr($this->dateCreated,3,6));
    	return md5($password . $salt);
    }
	
	
	/**
	 * Get the date when user has been registered on a website
	 * 
	 */
	public function _getUserDateCreated()
	{
	
		 $db = Zend_Registry::get("db");
		 $query = "SELECT dateCreated FROM users WHERE user_id = '{$this->user_id}'";
		 $result = $db->fetchAll($query);
		 $this->dateCreated = $result[0]['dateCreated'];
		
	}
	
	
	public function getAllUserData()
	{
		$db = Zend_Registry::get("db");
		$query = "SELECT * FROM users WHERE user_id = '{$this->user_id}'";
		$result = $db->fetchAll($query);
		foreach ($result[0] as $field_name => $value)
			$this->$field_name = $value;
	}
	
	/**
	 * Function checks if the old password is correct and if new password and repeat new password are the same
	 * 
	 * @param unknown_type $old_password
	 * @param unknown_type $new_password
	 * @param unknown_type $repeat_new_password
	 */
	public function CheckOldPasswordAndNewPasswords($old_password, $new_password, $repeat_new_password)
	{
		if ($new_password != $repeat_new_password)
		{
			throw "New password and repeat new password are not the same";
			return false;
		}
		else
		{
			if ($this->isUserPasswordValid($old_password))
			{	
				return $new_password;
			}
			else
			{
				throw "Old password is wrong";
				return false;
			}
		}	
			
	}
	

}

