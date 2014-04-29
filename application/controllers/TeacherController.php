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
			$status = -1;
			
			if ($q == 0) {
				foreach ($model -> fetchAll('lid = ' . $id . ' AND uid = ' . Zend_Registry::get('id')) as $key => $value) {
					$status = $value -> status;
					$cid = $value -> cid;
				}
				if ($status == 1) {
					$class = new Model_DbTable_Class();
					foreach ($class -> fetchAll('id = ' . $cid) as $key => $value) {
						if ($value -> status == 0) $status = 1;
						else $status = 0;
						$ispublic = $value -> ispublic;
					}
					if ($ispublic == 1) {
						$status = 0;
						$model -> delete('lid = ' . $id . ' AND uid = ' . Zend_Registry::get('id'));
						$model1 = new Model_DbTable_Learn();
						$model1 -> delete('lid = ' . $id . ' AND uid = ' . Zend_Registry::get('id') . ' AND cid = ' . $cid);
					} else {
						if ($status == 0)
							$model -> delete('lid = ' . $id . ' AND uid = ' . Zend_Registry::get('id'));
					}
				} else {
					$model -> delete('lid = ' . $id . ' AND uid = ' . Zend_Registry::get('id'));
				}
			} else if ($q == 1) {
				$is = FALSE;
				foreach ($model -> fetchAll('lid = ' . $id . ' AND uid = ' . Zend_Registry::get('id')) as $key => $value) {
					$is = true;
				}
				if (!$is) {
					$model1 = new Model_DbTable_Class();
					foreach ($model1 -> fetchAll('id = ' . $this -> _request -> getParam('c')) as $key => $value) {
						$ispublic = $value -> ispublic;
					}
					if ($ispublic == 0)
						$model -> insert(array('lid' => $id, 'uid' => Zend_Registry::get('id'), 'status' => '0', 'cid' => $this -> _request -> getParam('c')));
					else {
						$model -> insert(array('lid' => $id, 'uid' => Zend_Registry::get('id'), 'status' => '1', 'cid' => $this -> _request -> getParam('c')));
						$model1 = new Model_DbTable_Learn();
						$model1 -> insert(array('lid' => $id, 'uid' => Zend_Registry::get('id'), 'cid' => $this -> _request -> getParam('c')));
					}
				}
				else
					$status = 1;
			} else {
				$model -> update(array('status' => 0, 'cid' => $this -> _request -> getParam('c')), 'lid = ' . $id . ' AND uid = ' . Zend_Registry::get('id'));
			}
			
			if ($status == 1) {
				echo Zend_Json::encode(array('status' => 0));
			} else {
				echo Zend_Json::encode(array('status' => 1));
			}
		}
	}
	
	public function getclassesAction() {
		if ($this -> getRequest() -> isXmlHttpRequest()) {
			$model = new Model_DbTable_Class();
			$id = $this -> _request -> getParam('id');
			$res = $model -> fetchAll($model -> select() -> where('status = 0 AND lid = ' . $id) -> order('day') -> order('hour') -> order('minute'));
			$ret = "";
			$date = array('Даваа', 'Мягмар', 'Лхагва', 'Дүрэв', 'Баасан', 'Бямба', 'Ням');
			foreach ($res as $key => $value) {
				if ($value -> ispublic == 1) {
					$ret .= '<option value = '.$value -> id.'>Нээлттэй анги</option>';
				} else {
					$ret .= '<option value = '.$value -> id.'>'. $date[$value -> day].' ('.$this -> fix($value -> hour) .':' . $this -> fix($value -> minute) .')</option>';
				}
			}
			
			echo $ret;
		}
	}
	
	public function fix($str) {
		if (strlen($str) == 1) $str = "0" . $str;
		return $str;
	}
}
