<?php
	class Model_DbTable_Activation extends Zend_Db_Table_Abstract{
		protected $_name = 'activation';
		/*public function __construct($option = null) {
			$this -> delete('date < ' . (date('Y-m-d', time() - 24*10*60*60)));
		}*/
	}
