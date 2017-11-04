<?php
require "db_conf.php";


function clean_query($query){
	
	echo '<br>2'.$query;

	$i=0;
	$flag=0;

	while($query[$i]!=""){
	
		//echo '<br>'.$query[$i];		

		if($query[$i]=='\\'){
			
		
			$query[$i]=" ";
		}	
		
		$i=$i+1;
	
	}
	echo '<br>1'.$query;
	return $query;
}

$query=clean_query($query);

?>

<html>
<body>
<?php

	echo "<br>3sql: ".$query." <br><hr><br>";
$conn=open_dbconnection("default");

	if($query!=""){
		
		$res=run_sql($query,$conn);
	}
	
	
	echo '<form action="" method="post">';	
	echo 'query: <input type="text" name="query" value="" size="100"><br>';
	echo '<input type="submit" name="invia" value="invia"><br>'; 
	echo '</form>';

	echo '<br><hr><br>';
	
	$row = mysqli_fetch_assoc($res);

	$s=sizeof($row);
	echo 'sof(row): '.$s.'';

	echo '<table>';
	echo '<tr>';


	$i=0;
	while($i<$s){
		
		echo '<td>col '.$i.'</td>';
		$i=$i+1;
	}

	$j=0;
	while($row!=""){
		echo '<tr>';	

		$i=0;
		while($i<$s){
			
			echo '<td>'.$row[$i].'</td>';
			$i=$i+1;
		}
		$row = mysqli_fetch_assoc($res);
		$j=$j+1;
	}
	echo '</table>';
	

	if($query!=""){
	close_dbconnection($conn);
	}
?>
</body>
</html>