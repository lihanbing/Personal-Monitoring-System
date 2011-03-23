<?php

class HelpController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->headTitle('Personal Monitoring System :: Help');
		//$this->view->render('_navigationbar.phtml');
		$this->view->headLink()->appendStylesheet('/css/global.css');
		$this->view->headLink()->appendStylesheet('/css/help.css');
    }


}

