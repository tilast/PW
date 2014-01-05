<?php

	class Payments extends Base {
		private $method;
		private $payment;

		private $methods;
		private $payments;
		private $formPrice;
		private $formId;

		public function __construct() {
			parent::__construct();
			$this->getModel("method");
			$this->getModel("payment");

			$this->user = User::getInstance();
			$this->method = Method::getInstance();
			$this->payment = Payment::getInstance();

			$this->methods = array();
		}

		protected function collectInfo() {
			parent::collectInfo();

			if(!$this->user->isLogined()) {
				Router::go("login");
			}

			$this->methods = $this->method->getMethods($this->user->getId());

			if($this->isPost() && isset($_POST["add"])) {
				if($id_payment = $this->payment->add($this->user->getId(), $_POST["method"], $_POST["price"])) {
					$method = $this->method->getById($_POST["method"], $this->user->getId());
					$price = $_POST["price"] + $_POST["price"] * $method["comission"] / 100;
					$this->logger->addPayment($this->user->getId(), $this->user->getLogin(), $_POST["method"], $method["name"], $id_payment, $_POST["price"], $price);
					Router::go("payments");
				} else {
					$this->formPrice = $_POST["price"];
					$this->formId = $_POST["method"];
				}
			}

			if(isset($_GET["type"])) {
				$this->payments = $this->payment->get($this->user->getId(), $_GET["type"]);
			} else {
				$this->payments = $this->payment->get($this->user->getId());
			}

			$this->title .= "Payments";
		}

		protected function createPage() {
			$template = array(
				"methods" => $this->methods,
				"formPrice" => $this->formPrice,
				"formId" => $this->formId,
				"payments" => $this->payments,
			);

			$this->content = $this->template("payments", $template);
			parent::createPage();
		}
	}