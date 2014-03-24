<?php

class Model_LibraryAcl extends Zend_Acl {
	public function __construct() {
		$this -> addRole(new Zend_Acl_Role('guests'));
		$this -> addRole(new Zend_Acl_Role('users'), 'guests');
		$this -> addRole(new Zend_Acl_Role('admins'), 'users');

		$this -> add(new Zend_Acl_Resource('auth'));
		$this -> add(new Zend_Acl_Resource('index'));
		$this -> add(new Zend_Acl_Resource('users'));
		$this -> add(new Zend_Acl_Resource('error'));
		$this -> add(new Zend_Acl_Resource('lesson'));

		$this -> allow('guests', 'auth', array('login', 'forgot', 'reset', 'logout'));
		$this -> allow('guests', 'error', 'error');
		$this -> allow('guests', 'users', array('register', 'active'));

		$this -> deny('users', 'auth', array('login', 'register'));
		$this -> allow('users', 'users', array('logout', 'manage', 'profile', 'delete'));
		
		$this -> allow('admins', 'lesson', array('add', 'list', 'edit', 'delete', 'order', 'view'));
	}

}
