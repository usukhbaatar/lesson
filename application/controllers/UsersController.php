<?php

class UsersController extends Zend_Controller_Action {
	
	private function send($subject, $body, $email) {
	    $mail = new Zend_Mail();
	    $mail->setBodyHtml($body);
	    $mail->setFrom('osohoo02@gmail.com');
	    $mail->addTo($email);
	    $mail->setSubject($subject);
	    $mail->send();
	}

	public function init() {
		/* Initialize action controller here */
	}

	private function getAdapter() {
		$authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
		$authAdapter -> setTableName('users') -> setIdentityColumn('username') -> setCredentialColumn('password');
		return $authAdapter;
	}

	public function indexAction() {
		// action body
	}

	public function namageAction() {
		// action body
	}

	public function listAction() {
		// action body
	}

	public function deleteAction() {
		// action body
	}

	public function premiumAction() {
		// action body
	}

	public function registerAction() {
		$form = new Form_Register();
		$request = $this -> getRequest();

		if ($request -> isPost()) {
			if ($form -> isValid($this -> _request -> getPost())) {
				$username = $form -> getValue('username');
				$email = $form -> getValue('email');
				$password = md5($form -> getValue('password'));
				$role = trim($form -> getValue('role'));
				$fname = $form -> getValue('fname');
				$lname = $form -> getValue('lname');
				if ($role == 'users' || $role == 'admins') {
					$user = new Model_DbTable_Users();
					$id = $user -> insert(array('username' => $username, 'email' => $email, 'password' => $password, 'fname' => $fname, 'lname' => $lname, 'role' => $role));
					$code = NULL;
					$code = md5($id . "ForU$<))))()(and#%4'5&*" . rand(0, 2000));
					
					$body = '<h1>Сайн байна уу?</h1> <h2>Тавтай морил.</h2><br/>';
					$body .= 'Таны идэвхижүүлэх холбоос: <a href = "http://lesson.foru.mn/users/active/code/' . $code. '">' . 'http://lesson.foru.mn/users/active/code/' . $code. '</a>';
					
					//$mail = new Model_Mail();
					$this -> send('Бүртгэл идэвхижүүлэх', $body, $email);
					
					$model = new Model_DbTable_Activation();
					$model -> insert(array('uid' => $id, 'code' => md5($code . "ForU.Lesson"), 'date' => date('Y-m-d')));

					$this -> view -> errors = '<div class="alert alert-success alert-dismissable">
              								   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              								   <strong>Тавтай морилно уу.</strong> Хэсэг хугацааны дараа таны цахим шууданд идэвхижүүлэх холбоос очих болно.<br />
              								   </div>';
				} else
					$this -> view -> errors = '<div class="alert alert-warning alert-dismissable">
              								   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              								   Зүгээр байгаарай сугаа.</div>';
			}
		}

		$form -> setAction($this -> view -> baseUrl() . '/users/register');
		$this -> view -> form = $form;
	}

	public function cardAction() {
		// action body
	}

	public function guideAction() {
		// action body
	}

	public function activeAction() {
		$code = md5($this -> _request -> getParam('code') . "ForU.Lesson");
		$model = new Model_DbTable_Activation();
		foreach ($model -> fetchAll('code = ' . "'" . $code . "'") as $key => $value) {
			$id = $value -> uid;
			$users = new Model_DbTable_Users();
			$users -> update(array('active' => 'true'), 'id = ' . $id);
			foreach ($users -> fetchAll('id = ' . $id) as $key => $val) {
				$username = $val -> username;
				$password = $val -> password;

				$authAdapter = $this -> getAdapter();
				$authAdapter -> setIdentity($username) -> setCredential($password);

				$auth = Zend_Auth::getInstance();
				$result = $auth -> authenticate($authAdapter);

				if ($result -> isValid()) {
					$identity = $authAdapter -> getResultRowObject();
					$authStorage = $auth -> getStorage();
					$authStorage -> write($identity);
					$this -> _redirect('index/index');
				}
				$this -> _redirect('auth/login');
			}
		}
	}

}
