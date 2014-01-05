<?php
	include_once("./models/config.php");

	class Router {
		static function go($where = null) {
			if($where) {
				switch($where) {
					case "login" :
						$go = "login";
						break;
					case "account" :
						$go = "account";
						break;
					case "methods" :
						$go = "methods";
						break;
					case "payments" :
						$go = "payments";
						break;
					case "main" :
					default :
						$go = "";
				}

				header("Location: " . Config::SITE_PREFIX . "/" . $go);
			} else {
				$go = isset($_GET["go"]) ? $_GET["go"] : "";

				switch($go) {
					case "login" :
						$page = new Login();
						break;
					case "account" :
						$page = new Account();
						break;
					case "signup" :
						$page = new Signup();
						break;
					case "methods" :
						$page = new Methods();
						break;
					case "payments" :
						$page = new Payments();
						break;
					case "main" :
					default :
						$page = new Main();
				}

				$page->request();
			}
		}
	}