<?php

class connection 
{
	static public $con;
	static public $db;
	
	function __construct() 
	{
		
	}
	
	/*
	
		Connects to server and initiates database sequence
	
	*/
	static public function connect($site = "") 
	{
		$siteTxt = "";
		//var_dump($site); die();
		switch($site) {
			default:
				break;
			case 1:
				$siteTxt = "websites";
				break;
			case 2:
				$siteTxt = "caregiver";
				break;
			case 3:
				$siteTxt = "customizer";
				break;
			case 4:
				$siteTxt = "blog";
				break;
			case 5:
				$siteTxt = "faq";
				break;
			case 6:
				$siteTxt = "music";
				break;
			case 7:
				$siteTxt = "magicflower";
				break;
			case 8:
				$siteTxt = "rusticharmonycandles";
				break;
			case 9:
			    $siteTxt = "pvp";
			    break;
			case 10:
			    $siteTxt = "pve";
			    break;
			case 11:
			    $siteTxt = "freetunez";
			    break;
		}
		//var_dump("127.0.0.1","alf_$siteTxt","Bluesky50","alf_$siteTxt",3306);
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		if($site !== 11) {		
		    self::$con = new mysqli("localhost","id15075313_czgamesuser",']rSdC!v$uJ8#_=G)',"id15075313_czgames",3306);
		    self::$db = "id15075313_czgames";
		} else {
		    self::$con = new mysqli("localhost","id9500615_id9500615_alf_arkascension","bluesky50","id9500615_freetunez",3306);
		    self::$db = "id9500615_freetunez";
		}
		if (self::$con->connect_errno) {
			printf("Connect failed: %s\n", self::$con->connect_error);
			exit();
		}
		return true;
	}
	
	/*

		Takes given data and returns an SQL object
		Allows for override query 
	
		array(
			"selectType" => "*",
			"tableName"=>"",
			"identifier"=>""
		)
	*/
	
	static public function updateData($input = array())
	{
		$options = array_merge( array(
			"tableName"=>"",
			"columnName"=>"",
			"updatedInfo"=>"",
			"rowID"=>"",
			"override"=>array(
				"query"=>false
			)
		), $input);
		
		extract($options);
		
		if(!$override['query']) {
			$query = "UPDATE " . $tableName . " SET " . $columnName . "='" . $updatedInfo . "' WHERE id='" . $rowID . "'";
		} else {
			$query = $override['query'];
		}
		//var_dump($query); die();
		if(self::$con) {
			if(!mysqli_query(self::$con, $query)) {
				die("ERROR <br />\n" . mysqli_error(self::$con));
				return false;
			} else {
				return true;
			}
		}
	}
	
	static public function getData($input = array(), $json = false)
	{	
		$options = array_merge( array(
			"selectType" => "*",
			"tableName"=>"",
			"identifier"=>""
		), $input);
		
		extract($options);
		
		$query = "SELECT " . $selectType . " FROM " . $tableName;
		if($identifier !== "") {
			$query .= " " . $identifier;
		}
		
	    //var_dump($query); die();
		
		if(self::$con) {
			$results = mysqli_query(self::$con, $query, MYSQLI_STORE_RESULT);
			if($results) {
				$items = array();
				
				while($row = $results->fetch_array(MYSQLI_ASSOC)) {
					//var_dump($row); die();
					
					if(isset($row['rate_name'])) {
					    $items[$row['rate_name']] = $row;
					} elseif(isset($row['name'])) {
					    $items[$row['name']] = $row;
					} elseif(isset($row['title'])) {
					    $items[$row['title']] = $row;
					} elseif(isset($row['item_name'])) {
					    $items[$row['item_name']] = $row;
					} elseif(isset($row['mod_name'])) {
					    $items[$row['mod_name']] = $row;
					} elseif(isset($row['tool_name'])) {
						$items[$row['tool_name']] = $row;
					}
				}
				if($json) {
					return json_encode($items,JSON_FORCE_OBJECT);
				} else {
					//var_dump($items); die();
					return $items;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}

?>