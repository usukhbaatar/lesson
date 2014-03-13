<?php

class View_Helper_User_Get extends Zend_View_Helper_Abstract {
	public function constantReturn() {
		$user = new Model_DbTable_Users();
		return $user -> fetchAll();
	}

}
