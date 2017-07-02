<?php

class Db extends Singleton {
	private $dbh;

	public function __construct (){
		try {
			$this->dbh = new PDO("mysql:dbname=liken;host=127.0.0.1",'root','mysql');
		}
		catch(Exception $e) {
			trigger_error('DB: '.$e->getMessage(), E_USER_ERROR);
		}
		$this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	}
	public function select($sql,array $bind =[]){
		try {
			$stmt = $this->dbh->prepare($sql);
			foreach ($bind as $key => $value) {
				$stmt->bindValue(':'.$key, $value,$this->bind($value));
			}
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);	
		} catch (Exception $e) {
			trigger_error('DB: '.$e->getMessage(), E_USER_ERROR);
		}
		
		return $results;
	}
	public function insert($sql,array $bind =[]){
		try {
			$stmt = $this->dbh->prepare($sql);
			foreach ($bind as $key => $value) {
				$stmt->bindValue(':'.$key, $value, $this->bind($value));
			}
			$stmt->execute();
			return $this->dbh->lastInsertId();
		} catch (Exception $e) {
			trigger_error('DB: '.$e->getMessage(), E_USER_ERROR);
		}		
	}
	public function update($sql,array $bind =[]){
		try {
			$stmt = $this->dbh->prepare($sql);
			foreach ($bind as $key => $value) {
				$stmt->bindValue(':'.$key, $value, $this->bind($value));
			}
			$stmt->execute();
			return $stmt->rowCount();
		} catch (Exception $e) {
			trigger_error('DB: '.$e->getMessage(), E_USER_ERROR);
		}		
	}
	public function beginTransaction(){
		return $this->dbh->beginTransaction();
	}
	
	public function endTransaction(){
		return $this->dbh->commit();
	}
	
	public function cancelTransaction(){
		return $this->dbh->rollBack();
	}
	private function bind($value = null){
		if (is_int($value)) {
			$type = PDO::PARAM_INT;
		} elseif (is_bool($value)) {
			$type = PDO::PARAM_BOOL;
		} elseif (is_null($value)) {
			$type = PDO::PARAM_NULL;
		} else {
			$type = PDO::PARAM_STR;
		}
		return $type;
	}
}
