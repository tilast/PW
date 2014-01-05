<?php


	class Main extends Base {
		public function __construct() {
			parent::__construct();
		}

		protected function collectInfo() {
			parent::collectInfo();

			if($this->user->isLogined()) {
				Router::go("account");
			}

			$this->title .= "Main";
		}

		protected function createPage() {
			$this->content = $this->template("main");
			parent::createPage();
		}

	}