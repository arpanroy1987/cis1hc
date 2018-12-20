<?php

	$db_host = "10.173.34.126";
	$db_user = "postgres";
	$db_port="5432";
	$db_password = "";
	$db_dbname= "wbchca_db";
	try 
	{  
		$conn = new PDO("pgsql:host=$db_host;dbname=$db_dbname", $db_user, $db_password, array(PDO::ATTR_PERSISTENT => true));	
		//$conn= pg_connect($db_host,$db_port,$db_user,$db_password,$db_dbname);
		//echo "aaa";
	}
	catch(PDOException $e) 
	{  
		 $e='Connection Failed';
		 $conn=$e;
	}  
	