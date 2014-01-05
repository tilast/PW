<?php

abstract class Controller {

	protected function collectInfo() {
	}
	
	protected function createPage() {
	}

	public function request() {
		$this->collectInfo();
		$this->createPage();
	}

	public function isGet() {
		return $_SERVER['REQUEST_METHOD'] == "GET";
	}

	public function isPost() {
		return $_SERVER['REQUEST_METHOD'] == "POST";
	}
	
	protected function template($filename, $t_vars = array()) {
		foreach($t_vars as $k => $v) {
			$$k = $v;	
		}

		ob_start();
			include("./views/" . $filename . ".php");
		return ob_get_clean();
	}

	protected function getModel($name) {
		include_once("models/" . strtolower($name) . ".php");
	}
}