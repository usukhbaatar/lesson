<?php

class Form_Register extends Zend_Form
{
	public $title = null;
	
	public function __construct($option = null)
	{
		parent :: __construct($option);
		$this -> setMethod('post');
		
        $fname = new Zend_Form_Element('fname');
        $fname -> setLabel('Нэр:') -> setRequired(true)
			   -> addErrorMessage('Уучлаарай та нэрээ заавал бүртгүүлэх шаардлагатай.')
			   -> setAttrib('class', 'form-control');
		
        $lname = new Zend_Form_Element_Text('lname');
        $lname -> setLabel('Овог:') -> setRequired(true)
			   -> addErrorMessage('Уучлаарай та овгоо заавал бүртгүүлэх шаардлагатай.')
			   -> setAttrib('class', 'form-control');
		
		$role = new Zend_Form_Element_Select('role');
		$role -> addMultiOption('users', 'Оюутан');
		//$role -> addMultiOption('admins', 'Багш');
		$role -> setLabel('Хэрэглэгчийн төрөл:')
			  -> setAttrib('class', 'form-control');
		
		$username = new Zend_Form_Element_Text('username');
		$username -> setLabel('Нэвтрэх нэр:')
			   	  -> addFilters(array('StringTrim', 'StripTags'))
			   	  -> setRequired(TRUE)
			   	  -> addValidator(new Zend_Validate_Db_NoRecordExists('users', 'username'))
				  -> setAttrib('class', 'form-control');
			   
		$email = new Zend_Form_Element_Text('email');
		$email -> setLabel('Цахим шуудан:')
			   -> addFilters(array('StringTrim', 'StripTags'))
    		   -> addValidator('EmailAddress', TRUE)
			   -> setRequired(TRUE)
			   -> addValidator(new Zend_Validate_Db_NoRecordExists('users', 'email'))
			   -> setAttrib('class', 'form-control')
			   -> setDescription('Та цахим шуудангаа ашиглаж бүртгэлээ идэвхижүүлэх тул заавал зөв бөглөөрэй.');
		
		$password = new Zend_Form_Element_Password('password');
		$password -> setLabel('Нууц үг:')
				  -> setRequired(TRUE)
				  -> addValidator('stringLength', false, array(3, 100)) -> addErrorMessage('Уучлаарай нууц үг хамгийн багадаа 3 тэмлэгтийн урттай байна!')
				  -> setAttrib('class', 'form-control');
				  
	  	$confirm = new Zend_Form_Element_Password('confirm_password');
		$token = Zend_Controller_Front::getInstance()->getRequest()->getPost('password');
        $confirm -> setLabel('Нууц үгээ давтна уу:')
                 -> setRequired(true)
				 -> addFilter(new Zend_Filter_StringTrim())
				 -> addValidator(new Zend_Validate_Identical(trim($token))) -> addErrorMessage('Уучлаарай нууц үгээ шалгана уу!')
				 -> setAttrib('class', 'form-control');
		
        $submit = new Zend_Form_Element_Submit('submit');
        $submit -> setLabel('Бүртгүүлэх')
				-> setAttrib('class', 'btn btn-default');
        
        $this -> addElements(array($lname, $fname, $role, $email, $username, $password, $confirm, $submit));
	}
}
