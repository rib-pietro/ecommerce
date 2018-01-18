<?php

namespace Hcode;

use Rain\Tpl;

class Page {

	private $tpl;
	private $options = []; //esse array será utilizado para definições de variáveis usadas no tpl
	private $defaults = [
		"data"=>[]
	];

	public function __construct($opts = array()){

		$this->options = array_merge($this->defaults, $opts); //atribui às opções os valores padrão (array $defaults), caso estas não tenham sido passadas

		$config = array(
			"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/",
			"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
			"debug"         => false
	   	);

		Tpl::configure( $config );

		$this->tpl = new Tpl;

		$this->setData($this->options['data']);

		$this->tpl->draw("header");

	}

	private function setData($data = array())
	{

		foreach($data as $key => $value){
			$this->tpl->assign($key, $value);
		}

	}

	public function setTpl($name, $data = array(), $returnHTML = false)
	{
		$this->setData($data);

		return $this->tpl->draw($name, $returnHTML);

	}

	public function __destruct(){

		$this->tpl->draw("footer");

	}

}


?>