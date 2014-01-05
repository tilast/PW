<?php

	class Methods extends Base {
		private $formId;
		private $formType;
		private $formComission;
		private $formName;
		private $methods;
		private $showMethods;

		private $method;

		public function __construct() {
			parent::__construct();
			$this->getModel("method");

			$this->user = User::getInstance();
			$this->method = Method::getInstance();

			$this->methods = array();
			$this->showMethods = true;
		}

		protected function collectInfo() {
			parent::collectInfo();

			if(!$this->user->isLogined()) {
				Router::go("login");
			} else {
				$this->logger->getMethods($this->user->getId(), $this->user->getLogin());
			}

			if($this->isPost()) {
				if(isset($_POST["method"])) {
					if($_POST["id"]) {
						$result = $this->method->editMethod($this->user->getId(), $_POST["id"], $_POST["type"], $_POST["name"], $_POST["comission"]);
						$type = 1;
					} else {
						$type = 2;
						$result = $this->method->addMethod($this->user->getId(), $_POST["type"], $_POST["name"], $_POST["comission"]);
					}

					if($result) {

						switch($type) {
							case 1 :
								$this->logger->editMethod($this->user->getId(), $this->user->getLogin(), $_POST["id"], $_POST["name"], $_POST["comission"]);
								break;
							case 2 :
								$this->logger->addMethod($this->user->getId(), $this->user->getLogin(), $result, $_POST["name"], $_POST["comission"]);
						}

						Router::go("methods");
					} else {
						$this->formId = $_POST["id"];
						$this->formType = $_POST["type"];
						$this->formComission = $_POST["comission"];
						$this->formName = $_POST["name"];
					}
				} else if(isset($_POST["delete"])) {
					$this->method->delete($_POST["id"], $this->user->getId());
					$this->logger->deleteMethod($this->user->getId(), $this->user->getLogin(), $_POST["id"]);
				}
			}

			if(isset($_GET["id"])) {
				if($method = $this->method->getById($_GET["id"], $this->user->getId())) {
					$this->formId = $_GET["id"];
					$this->formType = $method["type"];
					$this->formComission = $method["comission"];
					$this->formName = $method["name"];
					$this->showMethods = false;
				} else {
					Router::go("account");
				}
			} else {
				$this->methods = $this->method->getMethods($this->user->getId());
			}

			$this->title .= "Methods";
		}

		protected function createPage() {
			$template = array(
				"formType" => $this->formType,
				"formComission" => $this->formComission,
				"formName" => $this->formName,
				"formId" => $this->formId,
				"methods" => $this->methods,
				"showMethods" => $this->showMethods
			);

			$this->content = $this->template("methods", $template);
			parent::createPage();
		}
	}