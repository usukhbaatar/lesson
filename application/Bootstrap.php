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
	
	public function _initMail() {
		$config = $this -> getOptions();
		Zend_Registry :: set('service', $config['resources']['mail']['service']);
		Zend_Registry :: set('info', $config['resources']['mail']['info']);
		Zend_Registry :: set('contact', $config['resources']['mail']['contact']);
		Zend_Registry :: set('usukhbaatar', $config['resources']['mail']['usukhbaatar']);
		
	}
	
}
