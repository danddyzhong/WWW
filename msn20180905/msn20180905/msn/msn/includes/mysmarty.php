<?php
include('Smarty.class.php');
class MySmarty extends Smarty{
	function __construct(){
		parent::__construct();
		$this->setTemplateDir('../templates/');
		$this->setCompileDir('../templates_c/');
		$this->setConfigDir('../configs/');
		$this->setCacheDir('../cache/');
	}
}