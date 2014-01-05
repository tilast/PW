<?php

	/**
	* class Logger
	* writes logs in required file
	*/
	class Logger {
		private static $instance;
		private $filename;
		private $file;

		public static function getInstance() {
			if(self::$instance == null)
				$instance = new Logger();
				
			return $instance;	
		}
		
		private function __construct() {
			$this->filename = "./models/log.txt";

			$this->file = fopen("./models/log.txt", "a");
		}

		function __destruct() {
			fclose($this->file);
		}

		private function canWrite() {
			return $this->file && is_writable($this->filename);
		}

		public function login($id_user, $login) {
			if($this->canWrite()) {
				$info = "User <$login> with id <$id_user> logined\n";
				fwrite($this->file, $info);
			}
		}

		public function logout($id_user, $login) {
			if($this->canWrite()) {
				$info = "User <$login> with id <$id_user> logouted\n";
				fwrite($this->file, $info);
			}
		}

		public function signup($id_user, $login) {
			if($this->canWrite()) {
				$info = "User <$login> with id <$id_user> signuped\n";
				fwrite($this->file, $info);
			}
		}

		public function getAccount($id_user, $login) {
			if($this->canWrite()) {
				$info = "User <$login> with id <$id_user> got account page\n";
				fwrite($this->file, $info);
			}
		}

		public function getMethods($id_user, $login) {
			if($this->canWrite()) {
				$info = "User <$login> with id <$id_user> got methods page\n";
				fwrite($this->file, $info);
			}
		}

		public function getPayments($id_user, $login) {
			if($this->canWrite()) {
				$info = "User <$login> with id <$id_user> got payments page\n";
				fwrite($this->file, $info);
			}
		}

		public function addMethod($id_user, $login, $id_method, $method, $comission) {
			if($this->canWrite()) {
				$info = "User <$login> with id <$id_user> added method <$method> with id <$id_method> and comission <$comission%>\n";
				fwrite($this->file, $info);
			}
		}

		public function editMethod($id_user, $login, $id_method, $method, $comission) {
			if($this->canWrite()) {
				$info = "User <$login> with id <$id_user> edited method <$method> with id <$id_method>: comission <$comission%>\n";
				fwrite($this->file, $info);
			}	
		}

		public function deleteMethod($id_user, $login, $id_method) {
			if($this->canWrite()) {
				$info = "User <$login> with id <$id_user> deleted method with id <$id_method>\n";
				fwrite($this->file, $info);
			}
		}

		public function addPayment($id_user, $login, $id_method, $method, $id_payment, $originalPrice, $price) {
			if($this->canWrite()) {
				$info = "User <$login> with id <$id_user> added payment with id <$id_payment>, price - <$price>, original price - <$originalPrice> by method <$method> with id <$id_method>\n";
				fwrite($this->file, $info);
			}
		}
	}