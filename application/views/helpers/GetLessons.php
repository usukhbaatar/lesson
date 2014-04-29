<?php

class View_Helper_GetLessons extends Zend_View_Helper_Abstract {
	
	public function __construct() {}
	
	public function getLessons() {
		return 'Хичээл тун удахгүй дуусах нь. Үлдсэн хэдхэн өдөр хичээлдээ шамдаад дүнгээ сайн гаргацгаагаарай. Энд цаашдаа хичээлийн жагсаалт байна.';
	}
	
	public function getTasks() {
		return 'Энд цаашдаа даалгаварын жагсаалт байна.';
	}
	
}
