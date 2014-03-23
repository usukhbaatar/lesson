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

		$this -> allow('guests', 'auth', array('login', 'forgot', 'reset'));
		$this -> allow('guests', 'error', 'error');
		$this -> allow('guests', 'index', array('index', 'invalid'));
		$this -> allow('guests', 'users', array('register', 'active'));

		$this -> deny('users', 'auth', array('login', 'register'));
		$this -> allow('users', 'auth', array('logout'));
		$this -> allow('users', 'users', array('logout', 'manage', 'profile'));
		
		$this -> allow('admins', 'users', array('delete'));
	}

}
