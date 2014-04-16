<?php

class ClassController extends Zend_Controller_Action {

	public function init() {
		//$this -> _helper -> ajaxContext -> addActionContext('save', 'json') -> initContext();

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
		$form = new Form_Class($this -> _request -> getParam('id'));
		$request = $this -> getRequest();
		$id = $this -> _request -> getParam('id');

		if ($request -> isPost()) {
			if ($form -> isValid($this -> _request -> getPost())) {
				$model = new Model_DbTable_Task();
				$name = $form -> getValue('name');
				$description = $form -> getValue('description');
				$day = $form -> getValidValue('day');
				$hour = $form -> getValue('hour');
				$minute = $form -> getValue('hour');
				$id = $form -> getValue('lesson');
				$model -> insert(array('name' => $name, 'description' => $description, 'lid' => $id, 'day' => $day, 'hour' => $hour, 'minute' => $minute));
				$this -> _redirect('class/list');
			}
		}

		$form -> setAction($this -> view -> baseUrl() . '/class/add/id/' . $id);
		$this -> view -> form = $form;
	}

	public function listAction() {
		$model = new Model_DbTable_Class();
		$this -> view -> list = $model -> fetchAll($model -> select() -> order('status') -> order('lid') -> order('day') -> order('hour'));

		$model = new Model_DbTable_Lesson();
		$ret = array();
		foreach ($model -> fetchAll() as $key => $value) {
			$ret[$value -> id] = $value;
		}
		$this -> view -> lessons = $ret;
	}

	public function editAction() {
		$id = $this -> _request -> getParam('id');
		$form = new Form_Task();
		$request = $this -> getRequest();
		$model = new Model_DbTable_Task();
		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$lid = $value -> lid;
		}

		if ($request -> isPost()) {
			if ($form -> isValid($this -> _request -> getPost())) {
				$name = $form -> getValue('name');
				$description = $form -> getValue('description');
				$day = $form -> getValidValue('day');
				$hour = $form -> getValue('hour');
				$minute = $form -> getValue('hour');
				$model -> update(array('name' => $name, 'description' => $description, 'day' => $day, 'hour' => $hour, 'minute' => $minute), 'id = ' . $id);
				$this -> _redirect('class/list/id/' . $lid);
			}
		}

		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$form -> getElement('name') -> setValue($value -> name);
			$form -> getElement('description') -> setValue($value -> description);
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
			$model = new Model_DbTable_Task();
			foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
				$lid = $value -> lid;
			}
			$model = new Model_DbTable_Lesson();
			foreach ($model -> fetchAll('id = ' . $lid) as $key => $value) {
				$uid = $value -> uid;
			}
	
			$model = new Model_DbTable_Task();
			$model -> delete('id = ' . $id . ' AND ' . $uid . ' = ' . Zend_Registry::get('id'));
			$this -> _redirect('class/list/id/' . $lid);
		} else {
			$id = $this -> _request -> getParam('id');
			$model = new Model_DbTable_Task();
			foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
				$lid = $value -> lid;
			}
			$model = new Model_DbTable_Lesson();
			foreach ($model -> fetchAll('id = ' . $lid) as $key => $value) {
				$uid = $value -> uid;
			}
	
			$model = new Model_DbTable_Task();
			$model -> update(array('status' => 1), 'id = ' . $id . ' AND ' . $uid . ' = ' . Zend_Registry::get('id'));
			$this -> _redirect('class/list/id/' . $lid);
		}
	}

}
