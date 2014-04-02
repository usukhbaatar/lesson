<?php

class FileController extends Zend_Controller_Action {

	public function init() {
		$this -> _helper -> ajaxContext -> addActionContext('upload', 'json') -> initContext();
		$this -> _helper -> ajaxContext -> addActionContext('delete', 'json') -> initContext();
		
		if ($this -> getRequest() -> isXmlHttpRequest()) {
			$this -> _helper -> layout -> disableLayout();
			$this -> _helper -> viewRenderer -> setNoRender(true);
		}
	}

	public function indexAction() {
		// action body
	}
	
	public function saveImage($source, $gid, $ex) {
        $image = file_get_contents($source);		
		$dir = APPLICATION_PATH . '/../public/files/' . md5($gid . 'LessonFile') . '.' . $ex;
		file_put_contents($dir, $image);
		$data=array(
			'uri' => md5($gid . 'LessonFile')
		);
		return $data;
    }

	public function downloadAction() {
		$file = new Model_DbTable_File();
		$id = $this -> _request -> getParam('id');
		$uid = NULL;
		$uri = NULL;
		$name = NULL;
		$role = NULL;

		foreach ($file -> fetchAll('id = ' . $id) as $key => $value) {
			$name = $value -> uri;
			$uid = $value -> uid;
			$uri = $value -> uri . '.' . $value -> extention;
		}

		$model = new Model_DbTable_Users();
		foreach ($model -> fetchAll('id = ' . $uid) as $key => $value) {
			$role = $model -> role;
		}

		if ($role == 'users' && Zend_Registry::get('role') == 'users' && Zend_Registry::get('id') != $uid)
			$this -> _redirect('auth/logout');

		header('Content-Type: text/plain');
		header('Content-Disposition: attachment; filename="' . $uri . '"');
		readfile(APPLICATION_PATH . '/../public/files/' . $uri);
		$this -> view -> layout() -> disableLayout();
		$this -> _helper -> viewRenderer -> setNoRender(true);
	}

	public function listAction() {
		$file = new Model_DbTable_File();
		if (Zend_Registry::get('role') == 'superadmin') {
			$result = $file -> fetchAll($file -> select() -> where('uid > -1') -> order('id ASC'));
		} else {
			$result = $file -> fetchAll($file -> select() -> where('uid = ' . Zend_Registry::get('id')) -> order('id ASC'));
		}

		$paginator = Zend_Paginator::factory($result);
		$paginator -> setItemCountPerPage(20) -> setCurrentPageNumber($this -> _getParam('page', 1));
		$this -> view -> paginator = $paginator;
		if ($this -> _request -> getParam('page') == NULL)
			$this -> view -> page = 1;
		else
			$this -> view -> page = $this -> _request -> getParam('page');
	}

	public function deleteAction() {
		if ($this -> getRequest() -> isXmlHttpRequest()) {
			$id = $this -> _request -> getParam('id');
			$file = new Model_DbTable_File();
			if (Zend_Registry::get('role') == 'superadmin') {
				$file -> delete('id = ' . $id);
			} else {
				$file -> delete('id = ' . $id . ' AND uid = ' . Zend_Registry::get('id'));
			}
			echo Zend_Json::encode(array('status' => 1));
		}
		$this -> _redirect('file/list');
	}

	public function uploadAction() {
		$request = $this->getRequest();
		
		if ($this -> getRequest() -> isXmlHttpRequest()) {
			$from = $request -> getParam('from');
			if ($from == 'summernote') {
				if ($_FILES['file']['name']) {
	            	if (!$_FILES['file']['error']) {
						$file = new Model_DbTable_File();
	                	$extention = explode('.', $_FILES['file']['name']);
						$data = array(
	    					'uri' => "asfdf",
	    					'name' => 'Content image.',
	    					'extention' => $extention[1],
	    					'uid' => Zend_Registry::get('id')
	    				);
	        			$id = $file -> insert($data);
	                	$name = md5($id . 'LessonFile');
	                	$filename = $name . '.' . $extention[1];
						
						$file -> update(array('uri' => '/public/files/' . $filename), 'id = ' . $id);
						
	                	$destination = APPLICATION_PATH. '/../public/files/' . $filename;
	                	$location = $_FILES["file"]["tmp_name"];
	                	move_uploaded_file($location, $destination);
	                	$uri =  '/public/files/' . $filename;
						echo Zend_Json::encode(array('status' => 1, 'data' => $uri));
	            	} else {
	            		echo Zend_Json::encode(array('status' => 0, 'data' => 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error']));
	            	}
	        	}
	        } else {
			}
		} else {
			
		}
	}

}
