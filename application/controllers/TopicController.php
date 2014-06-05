<?php

class TopicController extends Zend_Controller_Action {

	public function init() {
		$this -> _helper -> ajaxContext -> addActionContext('addcontent', 'json') -> initContext();

		if ($this -> getRequest() -> isXmlHttpRequest()) {
			$this -> _helper -> layout -> disableLayout();
			$this -> _helper -> viewRenderer -> setNoRender(true);
		}
	}

	public function indexAction() {
		$this -> _redirect('auth/logout');
	}

	public function addAction() {
		$form = new Form_Topic();
		$request = $this -> getRequest();
		$id = $this -> _request -> getParam('id');
		$model = new Model_DbTable_Lesson();
		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$uid = $value -> uid;
		}
		
		if (Zend_Registry::get('id') == $uid) {
			if ($request -> isPost()) {
				
				if ($form -> isValid($this -> _request -> getPost())) {
					$model = new Model_DbTable_Topic();
					$name = $form -> getValue('name');
					$description = base64_encode($form -> getValue('description'));
					$format = $form -> getValue('format');
					$model -> insert(array('name' => $name, 'description' => $description, 'lid' => $id, 'format' => $format));
					$this -> _redirect('topic/list/id/' . $id);
				}
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

	public function listAction() {
		$id = $this -> _request -> getParam('id');
		$model = new Model_DbTable_Topic();
		$this -> view -> list = $model -> fetchAll('lid = ' . $id);
		$model = new Model_DbTable_Lesson();
		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$this -> view -> lid = $id;
			$this -> view -> lessonName = $value -> name;
		}
	}

	public function editAction() {
		$id = $this -> _request -> getParam('id');
		$form = new Form_Topic();
		$request = $this -> getRequest();
		$model = new Model_DbTable_Topic();
		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$this -> view -> lid = $value -> lid;
			$lid = $value -> lid;
		}
		
		$model1 = new Model_DbTable_Lesson();
		foreach ($model1 -> fetchAll('id = ' . $lid) as $key => $value) {
			$uid = $value -> uid;
		}
		
		if (Zend_Registry::get('id') == $uid) {
			if ($request -> isPost()) {
				if ($form -> isValid($this -> _request -> getPost())) {
					$name = $form -> getValue('name');
					$description = base64_encode($form -> getValue('description'));
					$model -> update(array('name' => $name, 'description' => $description), 'id = ' . $id);
					$this -> _redirect('topic/list/id/' . $lid);
				}
			}
		}

		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$form -> getElement('name') -> setValue($value -> name);
			$form -> getElement('description') -> setValue(base64_decode($value -> description));
		}

		$form -> setAction($this -> view -> baseUrl() . '/topic/edit/id/' . $id);
		$this -> view -> form = $form;

		$model = new Model_DbTable_Lesson();
		foreach ($model -> fetchAll('id = ' . $lid) as $key => $value) {
			$this -> view -> lessonName = $value -> name;
		}
	}

	public function deleteAction() {
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
		$id = $this -> _request -> getParam('id');
		$model = new Model_DbTable_Topic();
		foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
			$this -> view -> topicName = $value -> name;
			$this -> view -> tid = $id;
		}
		$model = new Model_DbTable_Content();
		$result = $model -> fetchAll($model -> select() -> where('tid = ' . $id . ' AND category = \'topic\'') -> order('order') -> order('id'));
		$this -> view -> list = $result;
		
		$model = new Model_DbTable_File();
		$result = $model -> fetchAll($model -> select() -> where('tid = ' . $id . ' AND category =\'topic\''));
		$this -> view -> files = $result;
		$this -> view -> e = $this -> _request -> getParam('e');
	}
	
	public function addcontentAction() {
		$request = $this -> _request;
		if ($request -> isXmlHttpRequest()) {
			$id = $this -> _request -> getParam('id');
			$data = $this -> _request -> getPost();
			$tid = $data['tid'];
			$model = new Model_DbTable_Topic();
			foreach ($model -> fetchAll('id = ' . $tid) as $key => $value) {
				$model1 = new Model_DbTable_Lesson();
				foreach ($model1 -> fetchAll('id = ' . $value -> lid) as $key1 => $value1) {
					$uid = $value1 -> uid;
				}
			}
			
			if (Zend_Registry::get('id') == $uid) {
				$model = new Model_DbTable_Content();
				if ($id == 0) {
					$id = $model -> insert($data);
					$res = $model -> fetchAll($model -> select() -> where('tid = ' . $tid . ' AND category = \'topic\'') -> order('order DESC') -> limit(1));
					foreach ($res as $key => $value) {
						$model -> update(array('order' => $value -> order + 1), 'id = ' . $id);
					}
				} else {
					$model -> update($data, 'id = ' . $id);
				}
			}
			echo Zend_Json::encode(array('statys' => 1));
		}
	}
	
	public function deletecontentAction() {
		$request = $this -> _request;
		if ($request -> isXmlHttpRequest()) {
			$id = $this -> _request -> getParam('id');
			$model = new Model_DbTable_Content();
			foreach ($model -> fetchAll('id = ' . $id) as $key => $value) {
				$tid = $value -> tid;
			}
			$model = new Model_DbTable_Topic();
			foreach ($model -> fetchAll('id = ' . $tid) as $key => $value) {
				$lid = $value -> lid;
			}
			$model = new Model_DbTable_Lesson();
			foreach ($model -> fetchAll('id = ' . $lid) as $key => $value) {
				$uid = $value -> uid;
			}
			if ($uid == Zend_Registry::get('id')) {
				$model = new Model_DbTable_Content();
				$model -> delete('id = ' . $id);
				echo Zend_Json::encode(array('statys' => 1));
			}
		}
	}
	
	public function getcontentAction() {
		$request = $this -> _request;
		if ($request -> isXmlHttpRequest()) {
			$id = $this -> _request -> getParam('id');
			$model = new Model_DbTable_Content();
			$res = $model -> fetchAll('id = ' . $id);
			$i = 0;
			foreach ($res as $key => $value) {
				$res[$i]['content'] = base64_decode($value -> content);
				$i++;
			}
			echo Zend_Json::encode($res);
		}
	}
	
	public function getcontentsAction() {
		$request = $this -> _request;
		if ($request -> isXmlHttpRequest()) {
			$id = $this -> _request -> getParam('id');
			$model = new Model_DbTable_Content();
			$res = $model -> fetchAll($model -> select() -> from($model, array('id', 'title')) -> where('tid = ' . $id . ' AND category = \'topic\'') -> order('order') -> order('id'));
			echo Zend_Json::encode($res);
		}
	}
	
	public function saveImage($source, $gid, $ex) {
        $image=file_get_contents($source);		
		$dir=APPLICATION_PATH.'/../public/files/'.md5($gid.'imagesSIT-d').'.'.$ex;
		file_put_contents($dir, $image);
		$data=array(
			'uri' => '/public/files/' .md5($gid.'imagesSIT-d') .'.'. $ex
		);
		return $data;
    }
	
	public function addfileAction() {
		$form = new Form_FileForm();
        $request= $this -> getRequest();
		$idd = $this -> _request -> getParam('id');
		$model = new Model_DbTable_Task();
		foreach ($model -> fetchAll('id = ' . $idd) as $key => $value) {
			$model1 = new Model_DbTable_Lesson();
			foreach ($model1 -> fetchAll('id = ' . $value -> lid) as $key1 => $value1) {
				$uid = $value1 -> uid;
			}
		}
		
        if ($request -> isPost() && Zend_Registry::get('id') == $uid){
        	if ($form->isValid($this -> _request -> getPost())){
        		if ($form->file->isUploaded() && $form->file->receive()){
        			$file = new Model_DbTable_File();
					echo $form -> getElement('file') -> getFileName();
					$extention = pathinfo($form -> getElement('file') -> getFileName(), PATHINFO_EXTENSION);
        			$data = array(
						'uri' => "asfdf",
						'name' => $this -> _request -> getParam('name'),
						'extention' => $extention,
						'uid' => Zend_Registry::get('id'),
						'category' => 'topic',
						'tid' => $idd
					);
        			$id = $file->insert($data);
        			$data = $this->saveImage($form->file->getFileName(), $id, $extention);
        			$where['id = ?']= $id;
        			$file->update($data, $where);
        			$this->_redirect('topic/view/id/' . $idd);
        		}
        	}
        }
		$this->_redirect('topic/view/id/' . $idd . '/e/1');
	}

	public function saveorderAction() {
		$id = $this -> _request -> getParam('id');
		$ids = ($this -> _request -> getParam('ids'));
		$model = new Model_DbTable_Content();
		$order = 0;
		foreach ($ids as $value) {
			$model -> update(array('order' => $order++), 'id = ' . $value);
		}
		
		echo Zend_Json::encode(array('status' => 1));
	}


}
