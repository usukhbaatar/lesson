<?php

class StudentController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function lessonsAction()
    {		
		$db = Zend_Registry::get('db');
		$sql = "SELECT l.id as id, l.name as name, l.description as description FROM lesson as l, class as c, learn as ll ";
		$sql .= "WHERE ll.uid = " . Zend_Registry::get('id') . " AND ll.lid = l.id AND c.id = ll.cid AND (c.status = 0 OR c.ispublic = 1) ORDER BY l.name;";
		$this -> view -> list = $db -> fetchAll($sql);
    }

    public function tasksAction()
    {
        $lid = $this -> _request -> getParam('id');
    	$model = new Model_DbTable_Learn();
		$model1 = new Model_DbTable_Class();
		$ok = FALSE;
		foreach ($model -> fetchAll('lid = ' . $lid . ' AND uid = ' . Zend_Registry::get('id')) as $key => $value) {
			foreach ($model1 -> fetchAll('lid = ' . $value -> lid) as $key1 => $value1) {
				if ($value1 -> status == 0 || $value1 -> ispublic = 1) {
					$ok = TRUE;
				}
			}
		}
		if ($ok) {
			$model = new Model_DbTable_Task();
			$this -> view -> list = $model -> fetchAll('lid = ' . $lid);
			$model = new Model_DbTable_Lesson();
			foreach ($model -> fetchAll('id = ' . $lid) as $key => $value) {
				$this -> view -> lid = $lid;
				$this -> view -> lessonName = $value -> name;
			}
		}
		$this -> view -> ok = $ok;
    }

    public function topicsAction()
    {
    	$lid = $this -> _request -> getParam('id');
    	$model = new Model_DbTable_Learn();
		$model1 = new Model_DbTable_Class();
		$ok = FALSE;
		foreach ($model -> fetchAll('lid = ' . $lid . ' AND uid = ' . Zend_Registry::get('id')) as $key => $value) {
			foreach ($model1 -> fetchAll('lid = ' . $value -> lid) as $key1 => $value1) {
				if ($value1 -> status == 0 || $value1 -> ispublic = 1) {
					$ok = TRUE;
				}
			}
		}
		if ($ok) {
			$model = new Model_DbTable_Topic();
			$this -> view -> list = $model -> fetchAll('lid = ' . $lid);
			$model = new Model_DbTable_Lesson();
			foreach ($model -> fetchAll('id = ' . $lid) as $key => $value) {
				$this -> view -> lid = $lid;
				$this -> view -> lessonName = $value -> name;
			}
		}
		$this -> view -> ok = $ok;
    }

    public function taskAction()
    {
        $tid = $this -> _request -> getParam('id');
		$model = new Model_DbTable_Task();
		foreach ($model -> fetchAll('id = ' . $tid) as $key => $value) {
			$this -> view -> topicName = $value -> name;
			$this -> view -> tid = $tid;
			$lid = $value -> lid;
		}
		
		$model = new Model_DbTable_Learn();
		$model1 = new Model_DbTable_Class();
		$ok = FALSE;
		foreach ($model -> fetchAll('lid = ' . $lid . ' AND uid = ' . Zend_Registry::get('id')) as $key => $value) {
			foreach ($model1 -> fetchAll('lid = ' . $value -> lid) as $key1 => $value1) {
				if ($value1 -> status == 0 || $value1 -> ispublic = 1) {
					$ok = TRUE;
				}
			}
		}
		if ($ok) {
			$model = new Model_DbTable_Content();
			$result = $model -> fetchAll($model -> select() -> where('tid = ' . $tid . ' AND category = \'task\'') -> order('order') -> order('id'));
			$this -> view -> list = $result;
			
			$model = new Model_DbTable_File();
			$result = $model -> fetchAll($model -> select() -> where('tid = ' . $tid . ' AND category =\'task\''));
			$this -> view -> files = $result;
		}
		$this -> view -> ok = $ok;
    }

    public function topicAction()
    {
        $tid = $this -> _request -> getParam('id');
		$model = new Model_DbTable_Topic();
		foreach ($model -> fetchAll('id = ' . $tid) as $key => $value) {
			$this -> view -> topicName = $value -> name;
			$this -> view -> tid = $tid;
			$lid = $value -> lid;
		}
		
		$model = new Model_DbTable_Learn();
		$model1 = new Model_DbTable_Class();
		$ok = FALSE;
		foreach ($model -> fetchAll('lid = ' . $lid . ' AND uid = ' . Zend_Registry::get('id')) as $key => $value) {
			foreach ($model1 -> fetchAll('lid = ' . $value -> lid) as $key1 => $value1) {
				if ($value1 -> status == 0 || $value1 -> ispublic = 1) {
					$ok = TRUE;
				}
			}
		}
		if ($ok) {
			$model = new Model_DbTable_Content();
			$result = $model -> fetchAll($model -> select() -> where('tid = ' . $tid . ' AND category = \'topic\'') -> order('order') -> order('id'));
			$this -> view -> list = $result;
			
			$model = new Model_DbTable_File();
			$result = $model -> fetchAll($model -> select() -> where('tid = ' . $tid . ' AND category =\'topic\''));
			$this -> view -> files = $result;
		}
		$this -> view -> ok = $ok;
    }


}











