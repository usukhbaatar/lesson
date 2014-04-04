<?php

class Form_Lesson extends Zend_Form
{
	public function __construct($option = null)
	{
		parent :: __construct($option);
		$this -> setMethod('post');
		
        $name = new Zend_Form_Element_Text('name');
        $name -> setLabel('Хичээлийн нэр:') 
        	  -> addFilters(array('StringTrim', 'StripTags'))
    		  -> setRequired(TRUE) -> addErrorMessage('Уучлаарай хичээлийн нэр хоосон байж болохгүй!')
			  -> setAttrib('class', 'form-control');
		
		$descriptoin = new Zend_Form_Element_Textarea('description');
		$descriptoin -> setLabel('Хичээлийн тодорхойлолт:')
			  		 -> setAttrib('class', 'form-control summernote-small');
		
        $submit = new Zend_Form_Element_Submit('submit');
        $submit -> setLabel('Хадгалах')
				-> setAttrib('class', 'btn btn-default');
        
        $this -> addElements(array($name, $descriptoin, $submit));
		
	}
}
