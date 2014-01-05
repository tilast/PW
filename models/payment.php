<?php

	include_once('./models/db.php');

	/**
	* class Payment
	* model for interact with payments
	*/

	class Payment {
		private static $instance;
		private $db; 

		public static function getInstance() {
			if(self::$instance == null)
				$instance = new Payment();
				
			return $instance;	
		}
		
		private function __construct() {
			$this->db = DB::getInstance();
		}

		public function add($id_user, $id_method, $price) {
			$id_user = intval($id_user);
			$id_method = intval($id_method);

			$originalPrice = floatval($price);

			if(!$id_user || !$id_method || !$originalPrice) {
				return false;
			}

			$isU2MSelect = sprintf("SELECT comission FROM methods 
				LEFT JOIN user2method ON 
					user2method.id_user = '%d' AND user2method.id_method = '%d'
			WHERE methods.id_method = '%d'", $id_user, $id_method, $id_method);
			
			$isU2M = $this->db->Select($isU2MSelect);
			if(empty($isU2M)) {
				return false;
			}

			$comission = $isU2M[0]["comission"] / 100;
			$allPrice = $price + $price * $comission;

			$payment = array(
				"id_user" => $id_user,
				"id_method" => $id_method,
				"price" => $allPrice,
				"originalPrice" => $originalPrice
			);

			return $this->db->Insert("payments", $payment);
		}

		/**
		* @param id_user int
		* @param id_method int | null
		* @return mixed
		*/
		public function get($id_user, $id_method = null) {
			$select = $id_method ?
				sprintf("SELECT * FROM payments LEFT JOIN methods ON methods.id_method = '%d' WHERE payments.id_user = '%d' AND payments.id_method = '%d'", $id_method, $id_user, $id_method) :
				sprintf("SELECT * FROM payments LEFT JOIN methods ON payments.id_method = methods.id_method WHERE id_user = '%d'", $id_user);					

			return $this->db->Select($select);
		}
	}