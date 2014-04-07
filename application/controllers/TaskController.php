<?php

class TaskController extends Zend_Controller_Action
{

    public function init()
    {
        $this -> _helper -> ajaxContext -> addActionContext('save', 'json') -> initContext();

        if ($this -> getRequest() -> isXmlHttpRequest()) {
            $this -> _helper -> layout -> disableLayout();
            $this -> _helper -> viewRenderer -> setNoRender(true);
        }
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction() {
        $form = new Form_Task();
		$request = $this -> getRequest();
		$id = $this -> _request -> getParam('id');
		
		if ($request -> isPost()) {
			if ($form -> isValid($this -> _request -> getPost())) {
				$model = new Model_DbTable_Task();
				$name = $form -> getValue('name');
				$description = $form -> getValue('description');
				$model -> insert(array('name' => $name, 'description' => $description, 'lid' => $id));
				$this -> _redirect('task/list/id/' . $id);
			}
		}

		$form -> setAction($this -> view -> baseUrl() . '/task/add/id/' . $id);
		$this -> view -> form = $form;
		
		$model = new Model_DbTable_Lesson();
		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$this -> view -> lid = $id;
			$this -> view -> lessonName = $value -> name;
		}
    }

    public function listAction()
    {
        $id = $this -> _request -> getParam('id');
        $model = new Model_DbTable_Task();
		$this -> view -> list = $model -> fetchAll('lid = ' . $id);
		$model = new Model_DbTable_Lesson();
		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$this -> view -> lid = $id;
			$this -> view -> lessonName = $value -> name;
		}
    }

    public function editAction()
    {
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
				$model -> update(array('name' => $name, 'description' => $description), 'id = ' . $id);
				$this -> _redirect('task/list/id/' . $lid);
			}
		}

		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$form -> getElement('name') -> setValue($value -> name);
			$form -> getElement('description') -> setValue($value -> description);
		}

		$form -> setAction($this -> view -> baseUrl() . '/task/edit/id/' . $id);
		$this -> view -> form = $form;
		
		$model = new Model_DbTable_Lesson();
		foreach ($model -> fetchAll('id = ' . $lid) as $key => $value) {
			$this -> view -> lessonName = $value -> name;
		}
    }

    public function deleteAction()
    {
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
		$this -> _redirect('task/list/id/' . $lid);
    }


}
