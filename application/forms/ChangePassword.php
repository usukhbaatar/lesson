<?php

class Form_ChangePassword extends Zend_Form
{
	public $title = null;
	
	public function __construct($option = null)
	{
		parent :: __construct($option);
		$this -> setMethod('post');
		
		$old = new Zend_Form_Element_Password('old');
		$old -> setLabel('Хуучин нууц үг:')
			 -> setAttrib('class', 'form-control');
		
		$password = new Zend_Form_Element_Password('password');
		$password -> setLabel('Шинэ нууц үг:')
				  -> setRequired(TRUE)
				  -> addValidator('stringLength', false, array(3, 100)) -> addErrorMessage('Уучлаарай нууц үг хамгийн багадаа 3 тэмлэгтийн урттай байна!')
				  -> setAttrib('class', 'form-control');
				  
	  	$confirm = new Zend_Form_Element_Password('confirm_password');
		$token = Zend_Controller_Front::getInstance()->getRequest()->getPost('password');
        $confirm -> setLabel('Шинэ нууц үгээ давтна уу:')
                 -> setRequired(true)
				 -> addFilter(new Zend_Filter_StringTrim())
				 -> addValidator(new Zend_Validate_Identical(trim($token))) -> addErrorMessage('Уучлаарай нууц үгээ шалгана уу!')
				 -> setAttrib('class', 'form-control');
		
        $submit = new Zend_Form_Element_Submit('submit');
        $submit -> setLabel('Хадгалах')
				-> setAttrib('class', 'btn btn-default');
        
        $this -> addElements(array($old, $password, $confirm, $submit));
	}
}
