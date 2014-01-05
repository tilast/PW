<?php

/**
* class DB
* organize an interaction with database throught PDO
* also, here it creates db-file and required tables
*/

class DB
{
	private $dbh;
	function __construct()
	{
		try
		{
			if(!file_exists("models/test.db")) {
				touch("models/test.db");
				$this->dbh = new PDO("sqlite:models/test.db");
				$this->createTables();
			} else {
				$this->dbh = new PDO("sqlite:models/test.db");
			}
		}
		catch(PDOException $ex)
		{
			echo "PDO says: <br>";
			echo $ex->getMessage();
		}
		catch(Exception $ex)
		{
			$ex->getMessage();
		}
	}
	private static $instance;
	public static function getInstance()
	{
		if(self::$instance == null)
			self::$instance = new DB();

		return self::$instance;
	}
	public function Select($query)
	{
		try
		{
			$stmt = $this->dbh->prepare($query);
			if(!$stmt) {
				return false;
			}
			$stmt->execute();
			$arr = array();
			if($stmt) {
				while($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$arr[] = $row;
				}
			} else {
				$arr = array();
			}

			return $arr;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
		catch(Exception $ex)
		{
			$ex->getMessage();
		}
	}
	public function Insert($table, $obj)
	{
		try
		{
			$columns = array();
			$values = array();

			foreach($obj as $key => $value)
			{
				$key = $this->dbh->quote($key) . '';
				$columns[] = $key;

				if($value === null)
					$values[] = null;
				else
				{
					$value = ($value) . '';
					$values[] = '"'.$value.'"';
				}
			}

			$columns_s = implode(", ", $columns);
			$values_s = implode(", ", $values);


			$this->dbh->exec("INSERT INTO $table ($columns_s) VALUES ($values_s)");
			return $this->dbh->lastInsertId();
		}
		catch(PDOException $ex)
		{
			$ex->getMessage();
		}
		catch(Exception $ex)
		{
			$ex->getMessage();
		}
	}
	public function Update($table, $object, $where)
	{
		try
		{
			$columns = array();
			$set = array();
			foreach($object as $key => $value)
			{
				$key = $key . '';
				if($value === NULL)
					$set[] = "$key=NULL";
				else
				{
					$value = $value . '';
					$set[] = "$key=\"$value\"";
				}
				$set_s = implode(",", $set);
			}

			return $this->dbh->exec("UPDATE $table SET $set_s WHERE $where");
		}
		catch(PDOException $ex)
		{
			$ex->getMessage();
		}
		catch(Exception $ex)
		{
			$ex->getMessage();
		}
	}
	public function Delete($table, $where)
	{
		try
		{
			$this->dbh->exec("DELETE FROM $table WHERE $where");
			return true;
		}
		catch(PDOException $ex)
		{
			$ex->getMessage();
		}
		catch(Exception $ex)
		{
			$ex->getMessage();
		}
	}

	private function createTables() {
		$this->dbh->beginTransaction();
		$this->dbh->exec("
			CREATE TABLE users(
				id_user INTEGER PRIMARY KEY,
				password VARCHAR,
				login VARCHAR
			)
		");
		$this->dbh->exec("
			CREATE TABLE methods(
				id_method INTEGER PRIMARY KEY,
				name VARCHAR,
				comission VARCHAR,
				type INTEGER
			)
		");
		$this->dbh->exec("
			CREATE TABLE payments(
				id_payment INTEGER PRIMARY KEY,
				price VARCHAR,
				originalPrice VARCHAR,
				currency VARCHAR,
				id_user INTEGER,
				id_method INTEGER
			)
		");
		$this->dbh->exec("
			CREATE TABLE user2method(
				id_user INTEGER,
				id_method INTEGER
			)
		");
		$this->dbh->commit();
	}
} 