<?php

class LessonsController extends Zend_Controller_Action {

	public function init() {
		$this -> _helper -> ajaxContext -> addActionContext('get', 'json') -> initContext();
		$this -> _helper -> ajaxContext -> addActionContext('save', 'json') -> initContext();

		if ($this -> getRequest() -> isXmlHttpRequest()) {
			$this -> _helper -> layout -> disableLayout();
			$this -> _helper -> viewRenderer -> setNoRender(true);
		}
	}

	public function indexAction() {

	}

	public function addAction() {
		$form = new Form_Lesson();
		$request = $this -> getRequest();

		if ($request -> isPost()) {
			if ($form -> isValid($this -> _request -> getPost())) {
				$model = new Model_DbTable_Lesson();
				$name = $form -> getValue('name');
				$order = count($model -> fetchAll('uid = ' . Zend_Registry::get('id')));
				$description = $form -> getValue('description');
				$public = $form -> getValue('public');
				$id = $model -> insert(array('name' => $name, 'description' => $description, 'uid' => Zend_Registry::get('id'), 'order' => $order, 'ispublic' => $public));
				if ($public == 1) {
					$model = new Model_DbTable_Class();
					$model -> insert(array('lid' => $id, 'status' => 0, 'day' => 0, 'hour' => 0, 'minute' => 0, 'ispublic' => 1));
				}
				$this -> _redirect('lessons/list');
			}
		}

		$form -> setAction($this -> view -> baseUrl() . '/lessons/add');
		$this -> view -> form = $form;
	}

	public function listAction() {
		$id = Zend_Registry::get('id');
		$model = new Model_DbTable_Lesson();
		$this -> view -> list = $model -> fetchAll($model -> select() -> where('uid = ' . Zend_Registry::get('id')) -> order('order'));

		$req = array();
		$request = new Model_DbTable_Request();
		$result = $request -> fetchAll();
		foreach ($result as $key => $value) {
			if (!isset($req[$value -> lid]))
				$req[$value -> lid] = array(0, 0, 0);
			$req[$value -> lid][$value -> status]++;
		}
		$this -> view -> req = $req;
	}

	public function editAction() {
		$id = $this -> _request -> getParam('id');
		$form = new Form_Lesson();
		$request = $this -> getRequest();
		$model = new Model_DbTable_Lesson();

		if ($request -> isPost()) {
			if ($form -> isValid($this -> _request -> getPost())) {
				$name = $form -> getValue('name');
				$description = $form -> getValue('description');
				$model -> update(array('name' => $name, 'description' => $description), 'id = ' . $id);
				$this -> _redirect('lessons/view/id/' . $id);
			}
		}

		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$form -> getElement('name') -> setValue($value -> name);
			$form -> getElement('description') -> setValue($value -> description);
		}

		$form -> setAction($this -> view -> baseUrl() . '/lessons/edit/id/' . $id);
		$this -> view -> form = $form;
	}

	public function deleteAction() {
		$id = $this -> _request -> getParam('id');
		$model = new Model_DbTable_Lesson();
		$model -> delete('id = ' . $id . ' AND uid = ' . Zend_Registry::get('id'));
		$this -> _redirect('lessons/list');
	}

	public function viewAction() {
		$id = $this -> _request -> getParam('id');
		$model = new Model_DbTable_Lesson();
		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$this -> view -> name = $value -> name;
		}
		
		
	}

	public function orderAction() {

	}

	public function studentsAction() {
		$id = $this -> _request -> getParam('id');
		$val = $this -> _request -> getParam('val');
		$this -> view -> val = $val;
		$this -> view -> id = $id;
		$db = Zend_Registry::get('db');
		$sql = "SELECT users.fname, users.lname, request.id, request.uid FROM users, request WHERE request.lid = " . $id . ' AND request.status = ' . $val . ' AND request.uid = users.id';
		$this -> view -> list = $db -> fetchAll($sql);
		$model = new Model_DbTable_Lesson();
		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$this -> view -> name = $value -> name;
		}
	}

	public function saveAction() {
		if ($this -> getRequest() -> isXmlHttpRequest()) {
			$id = $this -> _request -> getParam('id');
			$q = $this -> _request -> getParam('q');
			$val = $this -> _request -> getParam('val');

			$model = new Model_DbTable_Request();
			$model1 = new Model_DbTable_Learn();
			
			if ($val == 1) {
				if ($q > 0) {
					$model -> update(array('status' => $q), 'id = ' . $id);
					if ($q == 1) {
						foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
							$model1 -> insert(array('cid' => $value -> cid, 'uid' => $value -> uid, 'lid' => $value -> lid));
						}
					} else {
						foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
							$model1 -> delete('cid = ' . $value -> cid . ' AND uid = ' . $value -> uid . ' AND lid = ' . $value -> lid);
							$model -> delete('id = ' . $id);
						}
					}
					
				} else {
					$model -> delete('id = ' . $id);
					foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
						$model1 -> delete('cid = ' . $value -> cid . ' AND uid = ' . $value -> uid . ' AND lid = ' . $value -> lid);
					}
				}
			} else {
				$old = $this -> _request -> getParam('old');
				if ($q > 0) {
					if ($q == 1) {
						foreach ($model -> fetchAll('lid = ' . $id . ' AND status = ' . $old) as $key => $value) {
							$model1 -> insert(array('cid' => $value -> cid, 'uid' => $value -> uid, 'lid' => $value -> lid));
						}
					} else {
						foreach ($model -> fetchAll('lid = ' . $id . ' AND status = ' . $old) as $key => $value) {
							$model1 -> delete('cid = ' . $value -> cid . ' AND uid = ' . $value -> uid . ' AND lid = ' . $value -> lid);
						}
					}
					$model -> update(array('status' => $q), 'lid = ' . $id . ' AND status = ' . $old);
				} else {
					foreach ($model -> fetchAll('lid = ' . $id . ' AND status = ' . $old) as $key => $value) {
						$model1 -> delete('cid = ' . $value -> cid . ' AND uid = ' . $value -> uid . ' AND lid = ' . $value -> lid);
					}
					$model -> delete('lid = ' . $id . ' AND status = ' . $old);
				}
			}
			echo Zend_Json::encode(array('status' => $id));
		}
	}

	public function getAction() {
		if ($this -> getRequest() -> isXmlHttpRequest()) {
			$id = $this -> _request -> getParam('id');
			$model = new Model_DbTable_Request();
			$ret = array();
			$ret[0] = 0; $ret[1] = 0; $ret[2] = 0;
			foreach ($model -> fetchAll('lid = ' . $id) as $key => $value) {
				$ret[$value -> status]++;
			}

			echo Zend_Json::encode(array('a' => $ret[0], 'b' => $ret[1], 'c' => $ret[2]));
		}
	}

}
