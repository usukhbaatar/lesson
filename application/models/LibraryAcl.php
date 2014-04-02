<?php

class Model_LibraryAcl extends Zend_Acl {
	public function __construct() {
		$this -> addRole(new Zend_Acl_Role('guests'));
		$this -> addRole(new Zend_Acl_Role('users'), 'guests');
		$this -> addRole(new Zend_Acl_Role('admins'), 'users');

		$this -> add(new Zend_Acl_Resource('auth'));
		$this -> add(new Zend_Acl_Resource('file'));
		$this -> add(new Zend_Acl_Resource('index'));
		$this -> add(new Zend_Acl_Resource('users'));
		$this -> add(new Zend_Acl_Resource('error'));
		$this -> add(new Zend_Acl_Resource('lesson'));
		$this -> add(new Zend_Acl_Resource('teacher'));

		$this -> allow('guests', 'auth', array('login', 'forgot', 'reset', 'logout'));
		$this -> allow('guests', 'error', 'error');
		$this -> allow('guests', 'users', array('register', 'active'));

		$this -> deny('users', 'auth', array('login', 'register'));
		$this -> allow('users', 'users', array('logout', 'manage', 'profile', 'delete'));
		$this -> allow('users', 'teacher', array('list', 'lessons', 'request'));
		$this -> allow('users', 'file', array('upload', 'download', 'delete', 'list'));
		
		$this -> allow('admins', 'lesson', array('add', 'list', 'edit', 'delete', 'order', 'view', 'students', 'save', 'get'));
	}

}
