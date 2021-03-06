<?php


class DBconnection extends PDO {
	private $_user;
	private $_pass;
	private $_dsn;


	
	function __construct() { 

		require_once("../includes/db.inc.php");
		$this->_user = $config['dbuser'];
		$this->_pass = $config['dbpass'];
		$this->_dsn = $config['dbdsn'];
		
		try {
			parent::__construct($this->_dsn,$this->_user,$this->_pass);
		}
		catch (Exception $e) {
			die($e->getMessage());
		}
		$this->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$schema = ($config['dbschema'])?$config['dbschema'].',':'';
		$this->exec("SET search_path TO $schema app; SET client_encoding TO 'UTF8';");
	}
	
   

}


?>
