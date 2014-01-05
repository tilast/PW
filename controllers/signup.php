<?php

	class Signup extends Base {
		private $formLogin;

		public function __construct() {
			parent::__construct();

			$this->user = User::getInstance();
		}

		protected function collectInfo() {
			parent::collectInfo();
			
			if($this->user->isLogined()) {
				Router::go("account");
			}

			if($this->isPost()) {
				if(!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['passwordAgain'])) {
					if(
						$this->user->signup(
							array("login" => $_POST['login'], "password" => $_POST['password'], "passwordAgain" => $_POST['passwordAgain'])
						) ) {
						Router::go("account");
					} else {
						$this->formLogin = $_POST['login'];
					}
				}
			}

			$this->title .= "Signup";
		}

		protected function createPage() {
			$this->content = $this->template("signup", array("formLogin" => $this->formLogin));
			parent::createPage();
		}
	}