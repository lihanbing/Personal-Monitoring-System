<?php

class Application_Model_AddUser
{
	protected $_user_id;
 	protected $_forename;
    protected $_surname;
    protected $_password;
    protected $_date_created;
    protected $_email;
    protected $_accesslevelid;
 
    public function __construct(array $options = null)
    {
    	
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid user property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid user property');
        }
        return $this->$method();
    }
 
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
 
    public function setForename($text)
    {
        $this->_forename = (string) $text;
        return $this;
    }
 
    public function getForename()
    {
        return $this->_forename;
    }
    
	public function setSurname($text)
    {
        $this->_surname = (string) $text;
        return $this;
    }
 
    public function getSurname()
    {
        return $this->_surname;
    }
    
 	public function setAccessLevelId($text)
    {
    	$this->_accesslevelid = (int) $text;
        return $this;
    }
    
    public function getAccesslevelid()
    {
    	return $this->_accesslevelid;
    }
    
    
    
    
 
    public function setPassword($password)
    {
		$dateCreated = $this->getDateCreated();
		echo 'sergii' . $dateCreated;
    	if (!isset($dateCreated))
    	{// if date_cteated has not been specifed then get the current time in the Unix format
    		$dateCreated = date('U');
    		//also it means (date has not been specified) that this is the user register operation and we will need to return the date to store it in the database
    		$this->setDateCreated($dateCreated);
    	}
    		
    	$password = $this->encrypt_password($password,$this->getDateCreated());
    		
    	$this->_password = (string) $password;		

        return $this;
    }
    
    
 
    protected function encrypt_password($password,$date_created)
    {
    	//create salt
    	$salt = md5('olololovzmyachneupyachneololol' . substr($date_created,3,6));
    	return md5($password . $salt);
    }
    
    
    public function getPassword()
    {
        return $this->_password;
    }
 
    public function setEmail($email)
    {
        $this->_email = (string) $email;
        return $this;
    }
    
 
    public function getEmail()
    {
        return $this->_email;
    }
 
 
    public function setUser_id($user_id)
    {
        $this->_user_id = (int) $user_id;
        return $this;
    }
 
    public function getUser_id()
    {
        return $this->_user_id;
    }
    
    public function setDateCreated($date_created)
    {
    	$this->_date_created = (int) $date_created;
        return $this;
    }
    
    public function getDateCreated()
    {
    	return $this->_date_created;
    }

    
    
}

