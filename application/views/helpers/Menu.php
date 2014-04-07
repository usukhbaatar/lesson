<?php

class View_Helper_Menu extends Zend_View_Helper_Abstract {
	private $controller = NULL;
	private $action = NULL;
	private $baseUrl = NULL;
	
	public function __construct($bu) {
		$this -> baseUrl = $bu;
		$fc = Zend_Controller_Front :: getInstance()->getRequest();
        $this -> controller = $fc -> getControllerName();
        $this -> action = $fc -> getActionName();
	}
	
	public function getMenu() {
		$role = Zend_Registry::get('role');
		if ($role == 'guests') return $this -> guests();
		if ($role == 'users') return $this -> users();
		if ($role == 'admins') return $this -> guests();
		if ($role == 'superadmin') return $this -> guests();
	}
	
	function getActive($role, $c, $a) {
		if ($this -> controller == $c && $this -> action == $a)	return 'active';
		else {
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
        $ret .= '<li class="'.$this -> getActive($role, 'student', 'lessons').'"><a href="'.$this -> baseUrl.'/lesson/list">Хичээлүүд</a></li>';
        return $ret;
	}
	
}

/*<li><a href="#">Link</a></li>
		            <li><a href="#">Link</a></li>
		            <li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<a href="#">Action</a>
							</li>
							<li>
								<a href="#">Another action</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#">Separated link</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#">One more separated link</a>
							</li>
						</ul>
					</li>';*/
