<?php

/**
* abstract class Controller
* base class which organize work of all controllers
*/

abstract class Controller {

	/**
	* @brief  method collects all required info for views
	* @return void
	*/
	protected function collectInfo() {
	}
	
	/**
	* @brief  method creates a views into a page
	* @return void
	*/
	protected function createPage() {
	}

	/**
	* @brief  method starts work of required controller
	* @return void
	*/
	public function request() {
		$this->collectInfo();
		$this->createPage();
	}

	/**
	* @brief  method checks get query
	* @return bool
	*/
	public function isGet() {
		return $_SERVER['REQUEST_METHOD'] == "GET";
	}

	/**
	* @brief  method checks post query
	* @return bool
	*/
	public function isPost() {
		return $_SERVER['REQUEST_METHOD'] == "POST";
	}
	
	/**
	* @brief  method create html from views and required variables
	* @return string
	*/
	protected function template($filename, $t_vars = array()) {
		foreach($t_vars as $k => $v) {
			$$k = $v;	
		}

		ob_start();
			include("./views/" . $filename . ".php");
		return ob_get_clean();
	}

	/**
	* @brief  method includes required model
	* @return void
	*/
	protected function getModel($name) {
		include_once("models/" . strtolower($name) . ".php");
	}
}