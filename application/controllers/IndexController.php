<?php

class IndexController extends Zend_Controller_Action {

	public function init() {
		/* Initialize action controller here */
	}

	public function indexAction() {
		switch (Zend_Registry::get('role')) {
			case 'guests':
				//$this -> _redirect('auth/login');
				break;
			default:
				$this -> redirect('users/profile');
				break;
		}
	}
	
	public function invalidAction() {
		
	}
}
