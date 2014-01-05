<?php

	class Account extends Base {
		private $currentUser;

		public function __construct() {
			parent::__construct();

			$this->user = User::getInstance();
		}

		protected function collectInfo() {
			parent::collectInfo();

			if(!$this->user->isLogined()) {
				Router::go("login");
			}

			$this->currentUser = $this->user->getUserInfo();
			
			$this->logger->getAccount($this->currentUser["id_user"], $this->currentUser["login"]);

			$this->title .= "Account";
		}

		protected function createPage() {
			$this->content = $this->template("account", array("user" => $this->currentUser));
			parent::createPage();
		}
	}