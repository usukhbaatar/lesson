<?php

class TopicController extends Zend_Controller_Action
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
        $this -> _redirect('auth/logout');
    }

    public function addAction() {
        $form = new Form_Topic();
		$request = $this -> getRequest();
		$id = $this -> _request -> getParam('id');
		
		if ($request -> isPost()) {
			if ($form -> isValid($this -> _request -> getPost())) {
				$model = new Model_DbTable_Topic();
				$name = $form -> getValue('name');
				$description = $form -> getValue('description');
				$model -> insert(array('name' => $name, 'description' => $description, 'lid' => $id));
				$this -> _redirect('topic/list/id/' . $id);
			}
		}

		$form -> setAction($this -> view -> baseUrl() . '/topic/add/id/' . $id);
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
        $model = new Model_DbTable_Topic();
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
		$form = new Form_Topic();
		$request = $this -> getRequest();
		$model = new Model_DbTable_Topic();
		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$lid = $value -> lid;
		}
		
		if ($request -> isPost()) {
			if ($form -> isValid($this -> _request -> getPost())) {
				$name = $form -> getValue('name');
				$description = $form -> getValue('description');
				$model -> update(array('name' => $name, 'description' => $description), 'id = ' . $id);
				$this -> _redirect('topic/list/id/' . $lid);
			}
		}

		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$form -> getElement('name') -> setValue($value -> name);
			$form -> getElement('description') -> setValue($value -> description);
		}

		$form -> setAction($this -> view -> baseUrl() . '/topic/edit/id/' . $id);
		$this -> view -> form = $form;
		
		$model = new Model_DbTable_Lesson();
		foreach ($model -> fetchAll('id = ' . $lid) as $key => $value) {
			$this -> view -> lessonName = $value -> name;
		}
    }

    public function deleteAction()
    {
        $id = $this -> _request -> getParam('id');
		$model = new Model_DbTable_Topic();
		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$lid = $value -> lid;
		}
		$model = new Model_DbTable_Lesson();
		foreach ($model -> fetchAll('id = ' . $lid) as $key => $value) {
			$uid = $value -> uid;
		}
		
		$model = new Model_DbTable_Topic();
		$model -> delete('id = ' . $id . ' AND ' . $uid . ' = ' . Zend_Registry::get('id'));
		$this -> _redirect('topic/list/id/' . $lid);
    }
	
	public function viewAction() {
		
	}


}
