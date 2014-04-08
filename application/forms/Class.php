<?php

class Form_Class extends Zend_Form {
	public function __construct($option = null) {
		parent :: __construct($option);
		$this -> setMethod('post');
		
        $name = new Zend_Form_Element_Text('name');
        $name -> setLabel('Ангийн нэр:') 
        	  -> addFilters(array('StringTrim', 'StripTags'))
    		  -> setRequired(TRUE) -> addErrorMessage('Уучлаарай ангийн нэр хоосон байж болохгүй!')
			  -> setAttrib('class', 'form-control');
		
		$descriptoin = new Zend_Form_Element_Textarea('description');
		$descriptoin -> setLabel('Ангийн тодорхойлолт:')
			  		 -> setAttrib('class', 'form-control summernote-small');
		
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
        
        $this -> addElements(array($name, $descriptoin, $day, $hour, $minute, $submit));
	}
}
