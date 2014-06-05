<?php

class UsersController extends Zend_Controller_Action {

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

					$model = new Model_DbTable_Activation();
					$model -> insert(array('uid' => $id, 'code' => md5($code . "lesson.foru.mn"), 'date' => date('Y-m-d')));

					$name = "ForU.MN";
					$sender = Zend_Registry::get('service');
					$to = array('0' => array('name' => $fname . " " . $lname, 'email' => $email));
					$subject = "Lesson.ForU.MN";
					$body = '<h1>Сайн байна уу?</h1> <br/> <h2> Тавтай морил </h2> <br/> Та дараах холбоос дээр дарснаар өөрийн бүртгэлээ идэвхижүүлэх боломжтой. <br /> Холбоос: <a href = "http://lesson.foru.mn/users/active/code/' . $code . '">' . 'http://lesson.foru.mn/users/active/code/' . $code . '</a>';

					$model = new Model_DbTable_Email();
					$email_id = $model -> insert(array('name' => $name, 'sender' => $sender, 'to_name' => $to[0]['name'], 'to_email' => $to[0]['email'], 'subject' => $subject, 'body' => $body));

					exec("php " . APPLICATION_PATH . "/../scripts/email.php " . $email_id . " GGT  > " . APPLICATION_PATH . "/../scripts/log.log 2>&1 &");

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
		$code = md5($this -> _request -> getParam('code') . "lesson.foru.mn");
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
	
	public function manageAction() {
		$val = $this -> _request -> getParam('val');
		$id = Zend_Registry::get('id');
		$request = $this -> getRequest();

		if ($val == 'profile') {
			$form = new Form_Register();
			$form -> removeElement('email');
			$form -> removeElement('password');
			$form -> removeElement('confirm_password');
			$form -> removeElement('confirm_password');
			$form -> removeElement('role');
			$form -> removeElement('username');
			$form -> removeElement('submit');

			$element = new Zend_Form_Element_Textarea('bio');
			$element -> setLabel('Миний тухай:') -> setAttrib('class', 'form-control summernote-small');
			$form -> addElement($element);

			$element = new Zend_Form_Element_Text('ide_username');
			$element -> setLabel('ideone.com - ийн нэвтрэх нэр:') -> setAttrib('class', 'form-control');
			$form -> addElement($element);

			$element = new Zend_Form_Element_Password('ide_password');
			$element -> setLabel('ideone.com - ийн нууц үг:') -> setAttrib('class', 'form-control');
			$form -> addElement($element);

			$submit = new Zend_Form_Element_Submit('submit');
			$submit -> setLabel('Хадгалах') -> setAttrib('class', 'btn btn-default');
			$form -> addElement($submit);

			$model = new Model_DbTable_Users();

			if ($request -> isPost()) {
				if ($form -> isValid($this -> _request -> getPost())) {
					$model = new Model_DbTable_Users();
					$fname = $form -> getValue('fname');
					$lname = $form -> getValue('lname');
					$bio = base64_encode(($form -> getValue('bio')));
					$iuser = $form -> getValue('ide_username');
					$ipass = $form -> getValue('ide_password');
					if ($ipass == NULL) {
						$model -> update(array('fname' => $fname, 'lname' => $lname, 'bio' => $bio, 'iuser' => $iuser), 'id = ' . $id);
					} else {
						$model -> update(array('fname' => $fname, 'lname' => $lname, 'bio' => $bio, 'iuser' => $iuser, 'ipass' => $ipass), 'id = ' . $id);
					}
					$this -> _redirect('users/profile');
				}
			}

			$result = $model -> fetchAll('id = ' . $id);

			foreach ($result as $key => $value) {
				$form -> getElement('fname') -> setValue($value -> fname);
				$form -> getElement('lname') -> setValue($value -> lname);
				$form -> getElement('bio') -> setValue(base64_decode($value -> bio));
				$form -> getElement('ide_username') -> setValue($value -> iuser);
				$form -> getElement('ide_password') -> setValue($value -> ipass);
			}

			$form -> setAction($this -> view -> baseUrl() . '/users/manage/val/profile');

		} else if ($val == 'password') {
			$form = new Form_ChangePassword();
			if ($request -> isPost()) {
				if ($form -> isValid($this -> _request -> getPost())) {
					$model = new Model_DbTable_Users();
					$result = $model -> fetchAll('id = ' . $id);

					$old = md5($form -> getvalue('old'));
					$new = md5($form -> getValue('password'));

					foreach ($result as $key => $value) {
						if ($value -> password == $old) {
							$model -> update(array('password' => $new), 'id = ' . $id);
							$this -> _redirect('users/profile');
						} else {
							$this -> view -> errors = '<div class="alert alert-success alert-dismissable">
		              								   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		              								   <strong>Уучлаарай.</strong> Таны хуучин нууц үг уруу байна.<br />
		              								   </div>';
						}
					}
				}
			}
			$form -> setAction($this -> view -> baseUrl() . '/users/manage/val/password');
		}

		$this -> view -> form = $form;
	}
	
	public function profileAction() {
		$role = Zend_Registry::get('role');
	}

}