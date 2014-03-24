<?php

class AuthController extends Zend_Controller_Action {

	public function init() {
		/* Initialize action controller here */
	}

	private function getAdapter() {
		$authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
		$authAdapter -> setTableName('users') -> setIdentityColumn('username') -> setCredentialColumn('password');
		return $authAdapter;
	}

	public function indexAction() {

	}

	public function loginAction() {
		if (Zend_Auth::getInstance() -> hasIdentity()) {
			$this -> _redirect('users/profile');
		}
		$thefor = $this -> _request -> getParam('thefor');
		$this -> view -> thefor = $thefor;

		$form = new Form_Login();
		$request = $this -> getRequest();
		if ($request -> isPost()) {
			if ($form -> isValid($this -> _request -> getPost())) {
				$authAdapter = $this -> getAdapter();
				$username = $form -> getValue('username');
				$password = md5($form -> getValue('password'));

				$authAdapter -> setIdentity($username) -> setCredential($password);

				$auth = Zend_Auth::getInstance();
				$result = $auth -> authenticate($authAdapter);

				if ($result -> isValid()) {
					$identity = $authAdapter -> getResultRowObject();
					$authStorage = $auth -> getStorage();
					$authStorage -> write($identity);
					if ($authStorage -> read() -> active == 'false' || $thefor == 'code') {
						if ($thefor == 'code')
							$this -> view -> errors = '<div class="alert alert-success alert-dismissable">
              								   	   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              								       Таны цахим шуудангаар идэвхижүүлэх холбоос илгээлээ.
              								       </div>';
						else {
							$this -> view -> errors = '<div class="alert alert-warning alert-dismissable">
              								   	   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              								       Уучлаарай таны бүртрэл идэвхигүй байна. Таны цахим шууданруу идэвхижүүлэх холбоос илгээлээ.
              								       </div>';
						}
						$id = $authStorage -> read() -> id;
						$code = md5($id . "Lesson.ForU$<()()()()(%%%)and#%4'5&*" . ($id + 1) . rand(0, 2000));

						$model = new Model_DbTable_Activation();
						$model -> insert(array('uid' => $id, 'code' => md5($code . "lesson.foru.mn"), 'date' => date('Y-m-d')));

						$name = "ForU.MN";
						$sender = Zend_Registry::get('service');
						$to = array('0' => array('name' => $authStorage -> read() -> fname . " " . $authStorage -> read() -> lname, 'email' => $authStorage -> read() -> email));
						$subject = "Lesson.ForU.MN";
						$body = '<h1>Сайн байна уу?</h1> <br/> <h2> Тавтай морил </h2> <br/> Та дараах холбоос дээр дарснаар өөрийн бүртгэлээ идэвхижүүлэх боломжтой. <br /> Холбоос: <a href = "http://lesson.foru.mn/users/active/code/' . $code . '">' . 'http://lesson.foru.mn/users/active/code/' . $code . '</a>';

						$model = new Model_DbTable_Email();
						$email_id = $model -> insert(array('name' => $name, 'sender' => $sender, 'to_name' => $to[0]['name'], 'to_email' => $to[0]['email'], 'subject' => $subject, 'body' => $body));

						exec("php " . APPLICATION_PATH . "/../scripts/email.php " . $email_id . " GGT  > " . APPLICATION_PATH . "/../scripts/log.log 2>&1 &");

						Zend_Auth::getInstance() -> clearIdentity();
					} else {
						$this -> _redirect('users/profile');
					}
				} else {
					$this -> view -> errors = '<div class="alert alert-warning alert-dismissable">
              								   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              								   Уучлаарай нэвтрэх нэр эсвэл нууц үг буруу байна.</div>';
				}
			}
		}
		if ($thefor == 'code') {
			$form -> setAction($this -> view -> baseUrl() . '/auth/login/thefor/code');
			$form -> getElement('submit') -> setLabel('Код авах');
		} else
			$form -> setAction($this -> view -> baseUrl() . '/auth/login');
		$this -> view -> form = $form;
	}

	public function logoutAction() {
		Zend_Auth::getInstance() -> clearIdentity();
		$this -> _redirect('auth/login');
	}

	public function forgotAction() {
		$form = new Form_ForgotPassword();
		$request = $this -> getRequest();

		if ($request -> isPost()) {
			if ($form -> isValid($this -> _request -> getPost())) {
				$email = $form -> getValue('email');
				$user = new Model_DbTable_Users();
				foreach ($user -> fetchAll('email = \'' . $email . '\'') as $key => $value) {
					$id = $value -> id;
					$email = $value -> email;
					$fname = $value -> fname;
					$lname = $value -> lname;
				}

				$code = hash('haval224,5', md5(hash('sha512', md5($id . "ForReset$<$or#***4'5&*" . ($id + 7) . rand(0, 2000)))));

				$model = new Model_DbTable_Reset();
				$model -> insert(array('uid' => $id, 'code' => md5($code . "lesson.foru.mn"), 'date' => date('Y-m-d')));

				$name = "ForU.MN";
				$sender = Zend_Registry::get('service');
				$to = array('0' => array('name' => $fname . " " . $lname, 'email' => $email));
				$subject = "Lesson.ForU.MN";
				$body = '<h1>Сайн байна уу?</h1> <br/> Та дараах холбоос дээр дарснаар өөрийн нууц үгээ сэргээх боломжтой. <br /> Холбоос: <a href = "http://lesson.foru.mn/auth/reset/code/' . $code . '">' . 'http://lesson.foru.mn/auth/reset/code/' . $code . '</a>';

				$model = new Model_DbTable_Email();
				$email_id = $model -> insert(array('name' => $name, 'sender' => $sender, 'to_name' => $to[0]['name'], 'to_email' => $to[0]['email'], 'subject' => $subject, 'body' => $body));

				exec("php " . APPLICATION_PATH . "/../scripts/email.php " . $email_id . " GGT  > " . APPLICATION_PATH . "/../scripts/log.log 2>&1 &");

				$this -> view -> errors = '<div class="alert alert-success alert-dismissable">
              								   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              								   Хэсэг хугацааны дараа таны цахим шууданд нууц үгээ сэргээх холбоос очих болно.
              								   </div>';
			}
		}

		$form -> setAction($this -> view -> baseUrl() . '/auth/forgot');
		$this -> view -> form = $form;
	}

	public function resetAction() {
		$code = $this -> _request -> getParam('code');
		$model = new Model_DbTable_Reset();
		$id = NULL;
		foreach ($model -> fetchAll('code = \'' .md5($code . "lesson.foru.mn") . '\'') as $key => $value) {
			$id = $value -> uid;
		}
		if ($id == NULL) {
			$this -> view -> errors = '<div class="alert alert-warning alert-dismissable">
      								   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      								   <strong>Уучлаарай</strong> Таны код буруу байна. Та дахиж код авах бол <a class = "label label-primary" href = "' . $this -> view -> baseUrl() . '/auth/forgot">энд</a> дарна уу.
      								   </div>';
		} else {
			$form = new Form_Reset();
			$request = $this -> getRequest();

			if ($request -> isPost()) {
				if ($form -> isValid($this -> _request -> getPost())) {
					$password = md5($form -> getValue('password'));
					$user = new Model_DbTable_Users();
					$user -> update(array('password' => $password), 'id = ' . $id);
					$this -> redirect('auth/login');
				}
			}

			$form -> setAction($this -> view -> baseUrl() . '/auth/reset/code/' . $code);
			$this -> view -> form = $form;
		}
	}

}
