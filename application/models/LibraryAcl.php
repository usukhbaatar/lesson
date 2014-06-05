<?php

class Model_LibraryAcl extends Zend_Acl {
	public function __construct() {
		$this -> addRole(new Zend_Acl_Role('guests'));
		$this -> addRole(new Zend_Acl_Role('users'), 'guests');
		$this -> addRole(new Zend_Acl_Role('admins'), 'users');

		$this -> add(new Zend_Acl_Resource('auth'));
		$this -> add(new Zend_Acl_Resource('file'));
		$this -> add(new Zend_Acl_Resource('task'));
		$this -> add(new Zend_Acl_Resource('class'));
		$this -> add(new Zend_Acl_Resource('topic'));
		$this -> add(new Zend_Acl_Resource('index'));
		$this -> add(new Zend_Acl_Resource('users'));
		$this -> add(new Zend_Acl_Resource('error'));
		$this -> add(new Zend_Acl_Resource('lessons'));
		$this -> add(new Zend_Acl_Resource('teacher'));
		$this -> add(new Zend_Acl_Resource('student'));

		$this -> allow('guests', 'auth', array('login', 'forgot', 'reset', 'logout'));
		$this -> allow('guests', 'error', 'error');
		$this -> allow('guests', 'index', array('invalid'));
		$this -> allow('guests', 'users', array('register', 'active'));

		$this -> deny('users', 'auth', array('login'));
		$this -> deny('users', 'users', array('register'));
		$this -> allow('users', 'index', array('index'));
		$this -> allow('users', 'users', array('logout', 'manage', 'profile', 'delete'));
		$this -> allow('users', 'teacher', array('list', 'lessons', 'request', 'getclasses'));
		$this -> allow('users', 'file', array('upload', 'download', 'delete', 'list'));
		$this -> allow('users', 'student', array('lessons', 'tasks', 'topics', 'task', 'topic'));
		
		$this -> allow('admins', 'lessons', array('add', 'list', 'edit', 'delete', 'order', 'view', 'students', 'save', 'get'));
		$this -> allow('admins', 'task', array('add', 'list', 'edit', 'delete', 'view', 'addcontent', 'deletecontent', 'getcontent', 'getcontents', 'addfile', 'saveorder'));
		$this -> allow('admins', 'topic', array('add', 'list', 'edit', 'delete', 'view', 'addcontent', 'deletecontent', 'getcontent', 'getcontents', 'addfile', 'saveorder'));
		$this -> allow('admins', 'class', array('add', 'list', 'edit', 'delete', 'view', 'deletestudent', 'gettasks', 'taskadd'));
	}

}
