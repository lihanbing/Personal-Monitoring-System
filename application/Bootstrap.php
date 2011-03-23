<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	
	
	
 	protected function _initDoctype()
    {
    	
        $this->bootstrap('view');
        
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
        
        $view->placeholder('left_sidebar')
             // "prefix" -> markup to emit once before all items in collection
             ->setPrefix("<div class=\"left_sidebar\">\n    <div class=\"block\">\n")
             // "separator" -> markup to emit between items in a collection
             ->setSeparator("</div>\n    <div class=\"block\">\n")
             // "postfix" -> markup to emit once after all items in a collection
             ->setPostfix("</div>\n</div>");
        
         $view->placeholder('right_sidebar')
             // "prefix" -> markup to emit once before all items in collection
             ->setPrefix("<div class=\"right_sidebar\">\n    <div class=\"block\">\n")
             // "separator" -> markup to emit between items in a collection
             ->setSeparator("</div>\n    <div class=\"block\">\n")
             // "postfix" -> markup to emit once after all items in a collection
             ->setPostfix("</div>\n</div>");
             
             
            
       
    }
  
    
    protected function _initDb ()
{
		$conf = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
	    //$options = Zend_Registry::get($conf);
		$db = Zend_Db::factory($conf->database);
				
	    Zend_Registry::set('db', $db);
}


    
    

}

