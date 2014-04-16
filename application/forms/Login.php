<?php

class Form_Login extends Zend_Form
{
	public function __construct($option = null)
	{
		parent :: __construct($option);
		$this -> setMethod('post');
		
        $username = new Zend_Form_Element_Text('username');
        $username -> setLabel('Нэвтрэх нэр:') 
        	   	  -> addFilters(array('StringTrim', 'StripTags'))
    		   	  -> setRequired(TRUE) -> addErrorMessage('Уучлаарай нэвтрэх нэр хоосон байж болохгүй!')
				  -> setAttrib('class', 'form-control');
		
		$fc = Zend_Controller_Front :: getInstance();
		
 		$password = new Zend_Form_Element_Password('password');
        $password -> setLabel('Нууц үг:') -> setRequired(true)
				  -> setRequired(TRUE) -> addErrorMessage('Уучлаарай нууц үг хоосон байж болохгүй!')
				  -> setAttrib('class', 'form-control')
				  -> setDescription('<a href = "'. $fc -> getBaseUrl(). '/auth/forgot">Нууц үгээ мартсан</a>');
		$password->getDecorator('Description')->setEscape(false);
		
		$redirect = new Zend_Form_Element_Hidden('redirect');
		
        $submit = new Zend_Form_Element_Submit('submit');
        $submit -> setLabel('Нэвтрэх')
				-> setAttrib('class', 'btn btn-default');
        
        $this -> addElements(array($username, $password, $redirect, $submit));
		
	}
}
