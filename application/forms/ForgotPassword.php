<?php

class Form_ForgotPassword extends Zend_Form
{
	public function __construct($option = null)
	{
		parent :: __construct($option);
		$this -> setMethod('post');
		
 		$email = new Zend_Form_Element_Text('email');
        $email -> setLabel('Бүртгүүлэхдээ ашигласан цахим шуудан:') -> setRequired(true)
			   -> addValidator(new Zend_Validate_Db_RecordExists('users', 'email'))
			   -> setRequired(TRUE) -> addErrorMessage('Уучлаарай цахим шуудан буруу байна!')
			   -> setAttrib('class', 'form-control');
		
        $submit = new Zend_Form_Element_Submit('submit');
        $submit -> setLabel('Нууц үгээ сэргээх')
				-> setAttrib('class', 'btn btn-default');
        
        $this -> addElements(array($email, $submit));
	}
}
