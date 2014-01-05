<?php
	
	/**
	* abstract class Base
	* base class which prepare controllers work
	*/

	abstract class Base extends Controller {
		protected $title;
		protected $content;
		protected $logger;

		protected $user;

		function __construct() {
			$this->getModel("user");
			$this->getModel("logger");

			$this->user = User::getInstance();
			$this->logger = Logger::getInstance();

			$this->title = "Payments site. ";
		}

		protected function collectInfo() {
		}
		
		protected function createPage() {
			$template = array("title" => $this->title, "content" => $this->content, "logined" => $this->user->isLogined());

			echo $this->template("index", $template);
		}
	}