<?php
	class Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract {
		private $_acl = null;
		
		public function __construct(Zend_Acl $acl) {
			$this->_acl = $acl;
		}
		
		public function preDispatch(Zend_Controller_Request_Abstract $request) {
			$resource = $request -> getControllerName();
			$action = $request -> getActionName();
			$role = Zend_Registry :: get('role');
			
			if (!$this -> _acl -> isAllowed($role, $resource, $action)){
				if (Zend_Registry::get('role') == 'guests') {
					$request -> setControllerName('auth')
						 	 -> setActionName('login')
							 -> setParam('id', '1');
				} else {
					$request -> setControllerName('index')
							 -> setActionName('invalid');
				}
			}
		}
	}
