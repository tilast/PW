<?php

	include_once('./models/db.php');

	/**
	* class Methods
	* model for interact with payment methods
	*/
	class Method {
		private static $instance;
		private $db; 

		public static function getInstance() {
			if(self::$instance == null)
				$instance = new Method();
				
			return $instance;	
		}
		
		private function __construct() {
			$this->db = DB::getInstance();
		}

		public function addMethod($id_user, $type, $name, $comission) {
			if(!$id_user) {
				return false;
			}

			list($type, $name, $comission) = array(trim($type), trim($name), trim($comission));

			if(!$type || !$name) {
				return false;
			}

			$method = array(
				"type" => $type,
				"name" => $name,
				"comission" => (int)$comission + 0
			);

			$id_method = $this->db->Insert("methods", $method);

			if(!$id_method) {
				return false;
			}

			$u2m = array(
				"id_user" => $id_user,
				"id_method" => $id_method
			);

			$u2mResult = $this->db->Insert("user2method", $u2m);

			return ($u2mResult) ? $id_method : false;
		}

		public function editMethod($id_user, $id, $type, $name, $comission) {
			if(!$id_user) {
				return false;
			}

			$u2mSelect = sprintf("SELECT * FROM user2method WHERE id_user = '%d' AND id_method = '%d'", $id_user, $id);
			$u2m = $this->db->Select($u2mSelect);

			if(empty($u2m)) {
				return false;
			}

			list($type, $name, $comission) = array(trim($type), trim($name), trim($comission));

			if(!$type || !$name) {
				return false;
			}

			$method = array(
				"type" => $type,
				"name" => $name,
				"comission" => (int)$comission + 0
			);

			$where = sprintf("id_method = '%d'", $id);

			return $this->db->Update("methods", $method, $where);
		}

		public function getById($id, $id_user) {			
			$select = sprintf("SELECT * FROM methods 
				LEFT JOIN user2method
				ON 	user2method.id_method = %d 
					AND user2method.id_user = %d WHERE methods.id_method = user2method.id_method", $id, $id_user);

			$result = $this->db->Select($select);
			
			return empty($result) ? null : $result[0];	
		}

		public function getMethods($id_user) {
			$select = sprintf("SELECT * FROM methods 
				LEFT JOIN user2method
				ON user2method.id_user = %d WHERE methods.id_method = user2method.id_method", $id_user);

			return $this->db->Select($select);	
		}

		public function delete($id_method, $id_user) {
			$u2mSelect = sprintf("SELECT * FROM user2method WHERE id_user = '%d' AND id_method = '%d'", $id_user, $id_method);
			$u2m = $this->db->Select($u2mSelect);

			if(empty($u2m)) {
				return false;
			}

			$this->db->Delete("methods", sprintf("id_method = '%d'", $id_method));
			$this->db->Delete("user2method", sprintf("id_method = '%d' AND id_user = '%d'", $id_method, $id_user));

			return true;
		}

	}