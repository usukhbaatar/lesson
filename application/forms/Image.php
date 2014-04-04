<?php

class Form_Image extends Zend_Form
{
	public function __construct($option = null)
	{
		parent :: __construct($option);
		$this -> setMethod('post');
		
       	$image = new Zend_Form_Element_File('image');
        $image -> addValidator('Size', false, 10240000);
        $image -> addValidator('Extension', false, 'jpg,png,gif');
        
        $this -> addElements(array($image));
		
	}
}
