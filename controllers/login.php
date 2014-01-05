<?php

	include_once("models/user.php");

	class Login extends Base {
		private $formLogin;

		public function __construct() {
			parent::__construct();

			$this->user = User::getInstance();
			
			if($this->user->isLogined()) {
				$this->logger->logout($this->user->getId(), $this->user->getLogin());
			}
			
			$this->user->logout();
		}

		protected function collectInfo() {
			parent::collectInfo();
			if($this->isPost() && !empty($_POST["login"])) {
				$this->formLogin = $_POST["login"];
				if($this->user->login($_POST["login"], $_POST["password"])) {
					$this->logger->login($this->user->getId(), $this->user->getLogin());
					Router::go("account");
				}
			}

			$this->title .= "Login";
		}

		protected function createPage() {
			$this->content = $this->template("login", array("formLogin" => $this->formLogin));
			parent::createPage();
		}
	}