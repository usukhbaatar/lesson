<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	private $_acl = null;

	protected function _initAutoload() {
		$modelLoader = new Zend_Application_Module_Autoloader( array('namespace' => '', 'basePath' => APPLICATION_PATH));

		if (Zend_Auth::getInstance() -> hasIdentity()) {
			Zend_Registry::set('role', Zend_Auth::getInstance() -> getStorage() -> read() -> role);
			Zend_Registry::set('id', Zend_Auth::getInstance() -> getStorage() -> read() -> id);
		} else {
			Zend_Registry::set('role', 'guests');
			Zend_Registry::set('id', 0);
		}

		$this -> _acl = new Model_LibraryAcl();
		$plugin = new Plugin_AccessCheck($this -> _acl);

		Zend_Controller_Front::getInstance() -> registerPlugin($plugin);

		return $modelLoader;
	}

	protected function _initDatabase() {
		$config = $this -> getOptions();
		$db = Zend_Db::factory($config['resources']['db']['adapter'], $config['resources']['db']['params']);
		Zend_Db_Table::setDefaultAdapter($db);
		Zend_Registry::set("db", $db);
	}

	public function _initViewHelper() {
		$this -> bootstrap('layout');
		$layout = $this -> getResource('layout');

		$view = $layout -> getView();

		$view -> headMeta() -> appendHttpEquiv('Content-type', 'text/html;charset=UTF-8') -> appendName('description', 'Миний хичээлүүд');
		$view -> headTitle("Хичээл");
		$view -> headTitle() -> setSeparator(' - ');

		ZendX_JQuery::enableView($view);
	}
	
	protected function _initMailsetup() {
		$aConfig = $this -> getOptions();
		$this -> _aMailConfig = array('auth' => 'login', 'username' => $aConfig['email']['username'], 'password' => $aConfig['email']['password'], 'ssl' => $aConfig['email']['ssl'], 'port' => $aConfig['email']['port']);
		$this -> _strSmtp = $aConfig['email']['server'];
		Zend_Mail::setDefaultTransport(new Zend_Mail_Transport_Smtp($this -> _strSmtp, $this -> _aMailConfig));
	}
	
}
