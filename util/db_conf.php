<?php

function open_dbconnection($mode){

	if ($mode=="default"){

		//nome host
		//$dbhost="62.149.150.48";
		$host="localhost";
        
        $port = "8889";

		//nome database
		//$dbname="Sql91967_1";
		$dbname="Db_sitov2";

		//nome utente
		//$dbuser="Sql91967";
		$user='root';

		//password
		//$dbpass="d3249269";		
        $password='root';
	}

	//connessione al db PHP 4.4
	// $conn = mysql_connect($dbhost,$dbuser,$dbpass);

	//selezione database PHp 4.4
	// mysql_select_db($dbname,$conn);
    
    $conn = mysqli_init();
    $success = mysqli_real_connect(
       $conn, 
       $host, 
       $user, 
       $password, 
       $dbname,
       $port
    );

	return $conn;
}

function close_dbconnection($conn){

	//chiusura
	mysqli_close($conn);
}

function run_sql($sql,$conn){

	//echo $sql;
	//Esecuzione comando
	$result = mysqli_query($conn, $sql)
	or die("Errore: " . mysqli_error($conn));

	return $result;
}

?>
