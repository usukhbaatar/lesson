<?php

class LessonController extends Zend_Controller_Action {

	public function init() {
		/* Initialize action controller here */
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
				$id = $model -> insert(array('name' => $name, 'description' => $description, 'uid' => Zend_Registry::get('id'), 'order' => $order));
				$this -> _redirect('lesson/view/id/' . $id);
			}
		}

		$form -> setAction($this -> view -> baseUrl() . '/lesson/add');
		$this -> view -> form = $form;
	}

	public function listAction() {
		$id = Zend_Registry::get('id');
		$model = new Model_DbTable_Lesson();
		$this -> view -> list = $model -> fetchAll($model -> select() -> where('uid = ' . Zend_Registry::get('id')) -> order('order'));
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
				$this -> _redirect('lesson/view/id/' . $id);
			}
		}
		
		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$form -> getElement('name') -> setValue($value -> name);
			$form -> getElement('description') -> setValue($value -> description);
		}

		$form -> setAction($this -> view -> baseUrl() . '/lesson/edit/id/' . $id);
		$this -> view -> form = $form;
	}

	public function deleteAction() {
		$id = $this -> _request -> getParam('id');
		$model = new Model_DbTable_Lesson();
		$model -> delete('id = ' . $id . ' AND uid = ' . Zend_Registry('id'));
		$this -> _redirect('lesson/list');
	}
	
	public function viewAction() {
		$id = $this -> _request -> getParam('id');
		$model = new Model_DbTable_Lesson();
		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$this -> view -> name = $value -> name;
			$this -> view -> description = $value -> description;
		}
	}
	
	public function orderAction() {
		
	}

}
