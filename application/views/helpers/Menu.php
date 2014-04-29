<?php

class View_Helper_Menu extends Zend_View_Helper_Abstract {
	private $controller = NULL;
	private $action = NULL;
	private $id = NULL;
	private $baseUrl = NULL;
	
	public function __construct($bu) {
		$this -> baseUrl = $bu;
		$fc = Zend_Controller_Front :: getInstance() -> getRequest();
        $this -> controller = $fc -> getControllerName();
        $this -> action = $fc -> getActionName();
		$this -> id = $fc -> getParam('id');
	}
	
	public function getMenu() {
		$role = Zend_Registry::get('role');
		if ($role == 'guests') return $this -> guests();
		if ($role == 'users') return $this -> users();
		if ($role == 'admins') return $this -> admins();
		if ($role == 'superadmin') return $this -> guests();
	}
	
	function getActive($role, $c, $a) {
		
		if ($this -> controller == $c && $this -> action == $a)	{
			if ($c == 'users' && $a == 'profile') {
				if ($this -> id == NULL) return 'active';
				else return "";
			} else {
				return 'active';
			}
		} else {
			if ($c == 'teacher' && $c == $this -> controller) return 'active';
		}
		return "";
	}
	
    public function guests() {
        $ret = NULL;
		$role = 'guests';
		$ret .= '<li class="'.$this -> getActive($role, 'auth', 'login').'"><a href="'.$this -> baseUrl.'/auth/login">Нэвтрэх</a></li>';
		$ret .= '<li class="'.$this -> getActive($role, 'users', 'register').'"><a href="'.$this -> baseUrl.'/users/register">Бүртгүүлэх</a></li>';
        return $ret;
    }
	
	public function users() {
		$ret = NULL;
		$role = 'users';
		$ret .= '<li class="'.$this -> getActive($role, 'users', 'profile').'"><a href="'.$this -> baseUrl.'/users/profile">Нүүр</a></li>';
		$ret .= '<li class="'.$this -> getActive($role, 'teacher', 'list').'"><a href="'.$this -> baseUrl.'/teacher/list">Багш нар</a></li>';
        $ret .= '<li class="'.$this -> getActive($role, 'student', 'lessons').'"><a href="'.$this -> baseUrl.'/student/lessons">Хичээлүүд</a></li>';
        return $ret;
	}
	
	public function admins() {
		$ret = NULL;
		$role = 'admins';
		$ret .= '<li class="'.$this -> getActive($role, 'users', 'profile').'"><a href="'.$this -> baseUrl.'/users/profile">Нүүр</a></li>';
		$ret .= '<li class="'.$this -> getActive($role, 'lessons', 'list').'"><a href="'.$this -> baseUrl.'/lessons/list">Хичээлүүд</a></li>';
		$ret .= '<li class="'.$this -> getActive($role, 'class', 'list').'"><a href="'.$this -> baseUrl.'/class/list">Ангиуд</a></li>';
        $ret .= '<li class="'.$this -> getActive($role, 'file', 'list').'"><a href="'.$this -> baseUrl.'/file/list">Файл удирдах</a></li>';
        return $ret;
	}
	
}
