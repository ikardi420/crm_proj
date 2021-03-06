<?php

namespace Blab\Mvc\Models;

use Blab\Libs\Database;
use Blab\Libs\Configuration;

class Blab_Model
{
	protected $_db=null;
	private static $_instance=null;

	public function __construct(){

		$configuration = new Configuration(array(
				"type" => "ini"
			));
		$path = ROOT.DS.'App'.DS.'Config'.DS.'database';
		$configuration = $configuration->initialize();
		$parsed = $configuration->parse($path);
			//print_r($parsed);
		$dbType = $parsed->default->database->type;
		$hostName = $parsed->default->database->host;
		$username = $parsed->default->database->username;
		$password = $parsed->default->database->password;
		$dbName = $parsed->default->database->dbName;
		$port = $parsed->default->database->port;
		$engine = $parsed->default->database->engine;

		$database = new Database(array(
				"type" =>$dbType,
				"options" =>array(
				"host" =>$hostName,
				"username" =>$username,
				"password" =>$password,
				"dbName" =>$dbName,
				"port" =>$port,
				"engine"=>$engine
			)
		));
		$this->_db = $database->initialize()->connect();
/*
		// Get All Data

		$all = $this->_db->query()
			->from("users")
			->where(array(
				"last"=>"Basir"
			))
			->order("first", "desc")
			->limit(100)
			->all();

		$print = print_r($all, true);
		echo "all = >{$print}";
*/
	}

	public static function getDBInstance(){

		if (!isset(self::$_instance)) {
				
			self::$_instance = new BLAB_Model();
			return self::$_instance->_db;
		}

		return false;
	}
}