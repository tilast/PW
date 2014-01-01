<?php
	include_once('./DB.php');

	/**
	 * class User
	 * class which describes user's issue
	*/
	class User {
		// DB handler
		private $dbh;

		// identifier and name of user
		private $id;
		private $name;

		/**
		 * @param $id
		 * @param $dbh
		 */
		function __construct($id, DB $dbh) {
			list($this->dbh, $this->id) = array($dbh, $id);
		}

		/**
		 * @return int Identifier of user
		*/

		public function getId() {
			return $this->id;
		}

		/**
		 * @return int|null Identifier of user
		 */
		public function getName() {
			if(!$this->name) {
				if(!$this->id) {
					$result = null;
				} else {
					$this->dbh->select(sprintf("SELECT name FROM users WHERE id = %d", $this->id));
				}
			}

			return $result;
		}

		public function pay() {

		}
	}