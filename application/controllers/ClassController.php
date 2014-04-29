<?php

class ClassController extends Zend_Controller_Action {

	public function init() {
		$this -> _helper -> ajaxContext -> addActionContext('delete', 'json') -> initContext();

		if ($this -> getRequest() -> isXmlHttpRequest()) {
			$this -> _helper -> layout -> disableLayout();
			$this -> _helper -> viewRenderer -> setNoRender(true);
		}
	}

	public function indexAction() {
		// action body
	}

	public function addAction() {
		$id = $this -> _request -> getParam('id');
		$form = new Form_Class($id);
		$request = $this -> getRequest();

		if ($request -> isPost()) {
			if ($form -> isValid($this -> _request -> getPost())) {
				$model = new Model_DbTable_Class();
				$day = $form -> getValue('day');
				$hour = $form -> getValue('hour');
				$minute = $form -> getValue('minute');
				$id = $form -> getValue('lesson');
				$model -> insert(array('lid' => $id, 'day' => $day, 'hour' => $hour, 'minute' => $minute));
				$this -> _redirect('class/list');
			}
		}

		$form -> setAction($this -> view -> baseUrl() . '/class/add/id/' . $id);
		$this -> view -> form = $form;
	}

	public function listAction() {
		$val = $this -> _request -> getParam('val');
		if ($val == NULL)
			$val = 0;
		$this -> view -> val = $val;

		$model = new Model_DbTable_Class();
		$this -> view -> list = $model -> fetchAll($model -> select() -> where('status = ' . $val) -> order('lid') -> order('day') -> order('hour') -> order('minute'));
		$model = new Model_DbTable_Lesson();
		$ret = array();
		foreach ($model -> fetchAll() as $key => $value) {
			$ret[$value -> id] = $value;
		}
		$this -> view -> lessons = $ret;
	}

	public function editAction() {
		$id = $this -> _request -> getParam('id');
		$request = $this -> getRequest();
		$model = new Model_DbTable_Class();

		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$lid = $value -> lid;
		}

		$form = new Form_Class($lid);
		foreach ($lid as $key => $value) {

		}

		if ($request -> isPost()) {
			if ($form -> isValid($this -> _request -> getPost())) {
				$day = $form -> getValue('day');
				$hour = $form -> getValue('hour');
				$minute = $form -> getValue('minute');
				$model -> update(array('day' => $day, 'hour' => $hour, 'minute' => $minute), 'id = ' . $id);
				$this -> _redirect('class/list');
			}
		}

		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$form -> getElement('lesson') -> setValue($value -> lid) -> setAttrib('disabled', 'true');
			$form -> getElement('day') -> setValue($value -> day);
			$form -> getElement('hour') -> setValue($value -> hour);
			$form -> getElement('minute') -> setValue($value -> minute);
		}

		$form -> setAction($this -> view -> baseUrl() . '/class/edit/id/' . $id);
		$this -> view -> form = $form;
	}

	public function deleteAction() {
		if ($this -> _request -> getParam('thefor') == 'delete') {
			$id = $this -> _request -> getParam('id');
			$model = new Model_DbTable_Class();
			foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
				$lid = $value -> lid;
			}
			$model = new Model_DbTable_Lesson();
			foreach ($model -> fetchAll('id = ' . $lid) as $key => $value) {
				$uid = $value -> uid;
			}

			$model = new Model_DbTable_Class();
			$model -> delete('id = ' . $id . ' AND ' . $uid . ' = ' . Zend_Registry::get('id'));
		} else {
			$id = $this -> _request -> getParam('id');
			$model = new Model_DbTable_Class();
			foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
				$lid = $value -> lid;
			}
			$model = new Model_DbTable_Lesson();
			foreach ($model -> fetchAll('id = ' . $lid) as $key => $value) {
				$uid = $value -> uid;
			}

			$model = new Model_DbTable_Class();
			$model -> update(array('status' => $this -> _request -> getParam('val')), 'id = ' . $id . ' AND ' . $uid . ' = ' . Zend_Registry::get('id'));
		}
		echo Zend_Json::encode(array('status' => 1));
	}

	public function viewAction() {
		$id = $this -> _request -> getParam('id');
		$model = new Model_DbTable_Class();
		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$lid = $value -> lid;
			$this -> view -> cid = $value -> id;
			$this -> view -> day = $value -> day;
			$this -> view -> hour = $value -> hour;
			$this -> view -> minute = $value -> minute;
		}

		$model = new Model_DbTable_Lesson();
		foreach ($model -> fetchAll('id = ' . $lid) as $key => $value) {
			$this -> view -> lid = $value -> id;
			$this -> view -> lessonName = $value -> name;
		}

		$db = Zend_Registry::get('db');
		$sql = "SELECT u.fname as fname, u.lname as lname, u.id as id FROM users as u, learn as l WHERE l.uid = u.id AND l.cid = " . $id . ' ORDER BY u.fname, u.lname';
		$this -> view -> learners = $db -> fetchAll($sql);
	}

	public function deletestudentAction() {
		$model = new Model_DbTable_Class();
		$cid = $this -> _request -> getParam('cid');
		$sid = $this -> _request -> getParam('uid');
		foreach ($model -> fetchAll('id = ' . $cid) as $key => $value) {
			$model1 = new Model_DbTable_Lesson();
			foreach ($model1 -> fetchAll('id = ' . $value -> lid) as $key1 => $value1) {
				$uid = $value1 -> uid;
			}
		}
		if (Zend_Registry::get('id') == $uid) {
			$model = new Model_DbTable_Learn();
			$model -> delete('uid = ' . $sid . ' AND cid = ' . $cid);
			$model = new Model_DbTable_Request();
			$model -> delete('uid = ' . $sid . ' AND cid = ' . $cid);
		}

		$this -> _redirect('class/view/id/' . $cid);
	}

	function gettasksAction() {
		$cid = $this -> _request -> getParam('cid');
		$model = new Model_DbTable_Class();
		foreach ($model -> fetchAll('id = ' . $cid) as $key => $value) {
			$lid = $value -> lid;
		}
		$model = new Model_DbTable_Task();
		$res = $model -> fetchAll('lid = ' . $lid);
		foreach ($res as $key => $value) {
			echo '<option value = ' . $value -> id . '>' . $value -> name . '</option>';
		}
	}

	function taskaddAction() {
		$cid = $this -> _request -> getParam('cid');
		$tid = $this -> _request -> getParam('tid');
		$start = $this -> _request -> getParam('start');
		$end = $this -> _request -> getParam('end');
		$model = new Model_DbTable_Class();
		$ret = 0;
		foreach ($model -> fetchAll('id = ' . $cid) as $key => $value) {
			$lid1 = $value -> lid;
		}
		$model = new Model_DbTable_Task();
		foreach ($model -> fetchAll('id = ' . $tid) as $key => $value) {
			$lid2 = $value -> lid;
		}
		if ($lid1 == $lid2) {
			$model = new Model_DbTable_Lesson();
			foreach ($model -> fetchAll('id = ' . $lid1) as $key => $value) {
				$uid = $value -> uid;
			}
			if ($uid == Zend_Registry::get('id')) {
				$model = new Model_DbTable_Work();
				$model -> insert(array('cid' => $cid, 'tid' => $tid, 'start' => $start, 'end' => $end));
				$ret = 1;
			}
		}
		echo Zend_Json_Encoder::encode(array('status' => $ret));
	}

}
