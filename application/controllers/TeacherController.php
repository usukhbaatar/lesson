<?php

class TeacherController extends Zend_Controller_Action {

	public function init() {
		$this -> _helper -> ajaxContext -> addActionContext('request', 'json') -> initContext();

		if ($this -> getRequest() -> isXmlHttpRequest()) {
			$this -> _helper -> layout -> disableLayout();
			$this -> _helper -> viewRenderer -> setNoRender(true);
		}
	}

	public function indexAction() {
		
	}
	
	public function listAction() {
		$model = new Model_DbTable_Users();
		$this -> view -> list = $model -> fetchAll('role = \'admins\'');
	}
	
	public function lessonsAction() {
		$id = $this -> _request -> getParam('id');
		
		$model = new Model_DbTable_Users();
		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$this -> view -> teacher = mb_substr($value -> lname, 0, 1, 'utf8') . '. ' . $value -> fname;
			$this -> view -> tid = $value -> id;
		}
		
		$model = new Model_DbTable_Lesson();
		$this -> view -> list = $model -> fetchAll('uid = ' . $id);
		
		$req = array();
		$model = new Model_DbTable_Request();
		foreach ($model -> fetchAll('uid = ' . Zend_Registry::get('id')) as $key => $value) {
			$req[$value -> lid] = $value -> status;
		}
		$this -> view -> req = $req;
	}
	
	public function requestAction() {
		if ($this -> getRequest() -> isXmlHttpRequest()) {
			$model = new Model_DbTable_Request();
			$id = $this -> _request -> getParam('id');
			$q = $this -> _request -> getParam('q');
			if ($q == 0) {
				$model -> delete('lid = ' . $id . ' AND uid = ' . Zend_Registry::get('id'));
			} else if ($q == 1) {
				$model -> insert(array('lid' => $id, 'uid' => Zend_Registry::get('id'), 'status' => '0'));
			} else {
				$model -> update(array('status' => 0), 'lid = ' . $id . ' AND uid = ' . Zend_Registry::get('id'));
			}
			
			
			echo Zend_Json::encode(array('status' => 1));
		}
	}
}
