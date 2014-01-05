<?php
	include_once('./models/db.php');
	/**
	 * class User
	 * class which describes interaction with users
	*/
	class User {
		private static $instance;
		private $db;
		
		public static function getInstance() {
			if(self::$instance == null)
				$instance = new User();
				
			return $instance;	
		}
		
		private function __construct() {
			$this->db = DB::getInstance();
		}

		public function login($login, $password) {
			$login = trim($login);
			$password = trim($password);

			$user = $this->getByLogin($login);
			
			if(!$user)
				return null;
			
			$user_id = $user['id_user'];

			if($user['password'] != md5($password))
				return null;

			$_SESSION["login"] = $login;

			return $user_id;
		}

		public function logout() {
			unset($_SESSION["login"]);
		}

		public function isLogined() {
			if( !empty ($_SESSION["login"]) ) {
				return (bool)$this->getByLogin($_SESSION["login"]);
			}
		}

		public function getByLogin($login) {
			$t = "SELECT * FROM users WHERE login = '%s' LIMIT 1";
			$query = sprintf($t, $login);
			$user = $this->db->Select($query);
			
			return !empty($user) ? $user[0] : null;	
		}

		public function getUserInfo() {
			return $this->isLogined() ? $this->getByLogin($_SESSION["login"]) : null;
		}

		public function getId() {
			if($this->isLogined()) {
				$user = $this->getByLogin($_SESSION["login"]);
				if($user) {
					$result = $user["id_user"];
				} else {
					$result = null;
				}
			} else {
				$result = null;
			}

			return $result;
		}

		public function getLogin() {
			if($this->isLogined()) {
				$user = $this->getByLogin($_SESSION["login"]);
				if($user) {
					$result = $user["login"];
				} else {
					$result = null;
				}
			} else {
				$result = null;
			}

			return $result;
		}

		public function signup($params) {
			$login = isset($params["login"]) && !empty($params["login"]) ? trim($params["login"]) : "";
			$password = isset($params["password"]) && !empty($params["password"]) ? trim($params["password"]) : "";
			$passwordAgain = isset($params["passwordAgain"]) && !empty($params["passwordAgain"]) ? trim($params["passwordAgain"]) : "";

			if(!$login)
				return false;

			if($password != $passwordAgain)
				return false;

			if($this->getByLogin($login))
				return false;

			$signup = array();
			$signup["login"] = $login;
			$signup["password"] = md5($password);

			$id = $this->db->Insert("users", $signup);

			if($id)
				$_SESSION["login"] = $login;

			return $id;
		}
	}