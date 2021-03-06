<?php

class Form_Class extends Zend_Form {
	public function __construct($id = NULL) {
		parent :: __construct(NULL);
		$this -> setMethod('post');
		
		$lesson = new Zend_Form_Element_Select('lesson');
		$lesson -> setLabel('Хичээл:')
				-> setAttrib('class', 'form-control');
		
		$model = new Model_DbTable_Lesson();
		foreach ($model -> fetchAll('uid = ' . Zend_Registry::get('id')) as $key => $value) {
			$lesson -> addMultiOption($value -> id, $value -> name);
		}
		
		if ($id != NULL) {
			$lesson -> setValue($id);
		}
		
		$day = new Zend_Form_Element_Select('day');
		$day -> setLabel('Өдөр:') -> setAttrib('class', 'form-control');
		$day -> addMultiOption('0', 'Даваа')
			 -> addMultiOption('1', 'Мягмар')
			 -> addMultiOption('2', 'Лхагва')
			 -> addMultiOption('3', 'Пүрэв')
			 -> addMultiOption('4', 'Баасан')
			 -> addMultiOption('5', 'Бямба')
			 -> addMultiOption('6', 'Ням');
		
		$hour = new Zend_Form_Element_Select('hour');
		$hour -> setLabel('Цаг:')  -> setAttrib('class', 'form-control');
		for ($i = 0; $i < 23; $i++)
		$hour -> addMultiOption($i, $i);
		
		$minute = new Zend_Form_Element_Select('minute');
		$minute -> setLabel('Минут:')  -> setAttrib('class', 'form-control');
		for ($i = 0; $i < 60; $i+=5)
		$minute -> addMultiOption($i, $i);
		
        $submit = new Zend_Form_Element_Submit('submit');
        $submit -> setLabel('Хадгалах')
				-> setAttrib('class', 'btn btn-default');
        
        $this -> addElements(array($lesson, $day, $hour, $minute, $submit));
	}
}
