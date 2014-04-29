<?php
class Form_FileForm extends Zend_Form{

	public function __construct($option = null){
		parent::__construct($option);
		
		$filename=new Zend_Form_Element_Text('name');
		$filename ->setRequired();
				  
		$image=new Zend_Form_Element_File('file');
		$image->setLabel('Үндсэн файл:');
        $image->addValidator('Size', false, 10240000);
        $image->addValidator('Extension', false, 'jpg,png,gif,pdf,zip,rar,c,cpp,cs,doc,docx,ppt,pptx,xls,xlsx,css,php,js,html,py,rb,txt,md,in,out');
		
		$add = new Zend_Form_Element_Submit('submit');
		$add->setLabel('Файл нэмэх');
		$add->setAttrib('class', 'btn');
		
		$this->addElements(array($filename,$image, $add));
		$this->setMethod('post');		
	}
}