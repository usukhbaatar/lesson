<?php

class Form_File extends Zend_Form
{
	public $title = null;
	
	public function __construct($option = null)
	{
		parent :: __construct($option);
		$this -> setMethod('post');
		
        $name = new Zend_Form_Element_Text('name');
        $name -> setLabel('Нэр:') 
  			  -> setRequired(true)
	   		  -> addFilters(array('StringTrim', 'StripTags'));

 		$file = new Zend_Form_Element_File('file');
        $file -> setLabel('Файл:') -> setRequired(true)
			  -> addValidator('Size', false, 10240000)
        	  -> addValidator('Extension', false, 'jpg')
			  -> addValidator('Extension', false, 'gif')
			  -> addValidator('Extension', false, 'png')
			  -> addValidator('Extension', false, 'txt')
			  -> addValidator('Extension', false, 'doc')
			  -> addValidator('Extension', false, 'docx')
			  -> addValidator('Extension', false, 'xls')
			  -> addValidator('Extension', false, 'xlsx')
			  -> addValidator('Extension', false, 'ppt')
			  -> addValidator('Extension', false, 'pptx')
			  -> addValidator('Extension', false, 'pdf')
			  -> addValidator('Extension', false, 'rar')
			  -> addValidator('Extension', false, 'zip')
			  -> addValidator('Extension', false, 'c')
			  -> addValidator('Extension', false, 'cpp')
			  -> addValidator('Extension', false, 'java')
			  -> addValidator('Extension', false, 'in')
			  -> addValidator('Extension', false, 'out')
			  -> addValidator('Extension', false, 'php')
			  -> addValidator('Extension', false, 'css')
			  -> addValidator('Extension', false, 'js')
			  -> addValidator('Extension', false, 'html')
			  -> addValidator('Extension', false, 'htm')
			  -> addValidator('Extension', false, 'sql')
			  -> addValidator('Extension', false, 'py')
			  -> addValidator('Extension', false, 'rb')
			  -> addValidator('Extension', false, 'xml')
			  -> addValidator('Extension', false, 'mp3')
			  -> addValidator('Extension', false, 'mp4')
			  -> addValidator('Extension', false, 'iso')
			  -> addValidator('Extension', false, 'asm');
		
        $submit = new Zend_Form_Element_Submit('submit');
        $submit -> setLabel('Нэмэх');
        
        $this -> addElements(array($description, $file, $submit));
		
		
        $submit -> setDecorators(array('ViewHelper',
            array(array('data' => 'HtmlTag'),  array('tag' =>'div', 'class'=> 'form-footer'))
        ));
        
        
        $this -> setDecorators(array(
            'FormElements',
            array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form-body')),
            'Form',
        ));
		
	}
}
