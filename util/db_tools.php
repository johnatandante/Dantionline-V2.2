<?php

function add_record($table,$values){
	
	$conn=open_dbconnection("default");

	//insert
	$sql="INSERT INTO ".$table." VALUES (";
	
	$i=0;

	while($i<sizeof($values)){
	
		$sql=$sql."'".htmlspecialchars($values[$i])."'";
		$i=$i+1;
		if ($i<sizeof($values)){
			$sql=$sql.",";
		}
	} 

	$sql=$sql.")";
	
	//Esecuzione comando
	$res=mysqli_query($conn,$sql)
	or die($sql."Errore! Non ho potuto eseqguire l'istruzione SQL (insert): " . mysqli_error($conn));

	close_dbconnection($conn);
}

function update($table,$nome_campi,$valore_campi){

	$conn=open_dbconnection("default");

	$settaggi="".$nome_campi[0]."= '".$valore_campi[0]."'";
	$i=1;
	while($nome_campi[$i]!=""){
		
		$settaggi=$settaggi.", ".$nome_campi[$i]."= '".htmlspecialchars($valore_campi[$i])."'";
		$i=$i+1;
	}

	$sql="update ".$table." set ".$settaggi." where ".$nome_campi[0]."='".htmlspecialchars($valore_campi[0])."'";
	//echo "<br>$sql";
	$res=run_sql($sql,$conn);
	
	close_dbconnection($conn);
}


function contatuple($table,$id,$query_extra){

	$campiselect=string2array("count(".$id.") as conta","  ");
	$nomecampi=string2array(""," ");
	$valorecampi=string2array(""," ");
	
	$tupla=select($table,$campiselect,$nomecampi,$valorecampi,$query_extra);
	return $tupla["conta"];
}

function select($table,$campiselect,$nomecampi,$valorecampi,$query_extra){

	$conn=open_dbconnection("default");

	$sql="select ".$campiselect[0];
	
	$i=1;
	while(isset($campiselect[$i]) && $campiselect[$i]!=""){
		
		$sql=$sql.",".$campiselect[$i];
		$i=$i+1;
	}
	
	$sql=$sql." from ".$table;
	
	if(isset($nomecampi) && isset($nomecampi[0]) && isset($valorecampi[0])  ){
		$sql=$sql." where ".$nomecampi[0]."='".$valorecampi[0]."'";

		$i=1;
		while(isset($nomecampi[$i]) && $nomecampi[$i]!=""){
			
			$sql=$sql." and ".$nomecampi[$i]."='".$valorecampi[$i]."'";
			$i=$i+1;
		}
	}
	
	$sql=$sql." ".$query_extra;

	//echo "<br>$sql";
	$res=mysqli_query($conn,$sql)
	or die("Errore! Non ho potuto eseguire l'istruzione SQL (select): " . $sql . " per " . mysqli_error($conn));

	$row = mysqli_fetch_assoc($res);
	close_dbconnection($conn);

	return $row;
}


function select_list($table,$campiselect,$nomecampi,$valorecampi,$query_extra){

	$conn=open_dbconnection("default");

	$sql="select ".$campiselect[0];
	
	$i=1;
	while($campiselect[$i]!=""){
		
		$sql=$sql.",".$campiselect[$i];
		$i=$i+1;
	}
	
	$sql=$sql." from ".$table;
	
	if($nomecampi!=""){
		$sql=$sql." where ".$nomecampi[0]."='".$valorecampi[0]."'";

		$i=1;
		while($nomecampi[$i]!=""){
			
			$sql=$sql." and ".$nomecampi[$i]."='".$valorecampi[$i]."'";
			$i=$i+1;
		}
	}
	
	$sql=$sql." ".$query_extra;

	//echo "<br>$sql";
	$res=mysqli_query($conn,$sql)
	or die("Errore! Non ho potuto eseguire l'istruzione SQL (select): " . $sql . " per " . mysqli_error($conn));
	
	$i=0;
	$row[$i] = mysqli_fetch_assoc($res);

	while($row[$i]!=""){
		//echo '-'.$row[$i][0];
		$i++;
		$row[$i] = mysqli_fetch_assoc($res);
	}

	close_dbconnection($conn);

	return $row;
}


function delete($table,$id,$id_alias){

	$conn=open_dbconnection("default");

	$sql='delete from '.$table.' where '.$id_alias.'="'.$id.'"';
	$res=run_sql($sql,$conn);	
	
	close_dbconnection($conn);	
}

function changePicture($newimg,$oldphoto,$user){

	$table="utenti";

	$conn=open_dbconnection("default");

	$sql='update '.$table.' set foto= "'.$newimg.'" where nome="'.$user.'"';
	$res=run_sql($sql,$conn);

	close_dbconnection($conn);
	
	return $newimg;
	
}

function isadmin($user){
	
	$bool=0;
	$table="utenti";

	$conn=open_dbconnection("default");
	$sql='select nome,password from '.$table.' where classe="administrator" and nome="'.$user.'"';
	$res=run_sql($sql,$conn);
	$row = mysqli_fetch_assoc($res);

	if ($row[0]!=""){
		$bool=1;
	}
	
	close_dbconnection($conn);

	return $bool;
}


function isadmin_sec($user, $pass){
	
	$bool=0;
	$table="utenti";

	$conn=open_dbconnection("default");
	$sql='select nome,password from '.$table.' where classe="administrator" and nome="'.$user.'"';
	$res=run_sql($sql,$conn);
	$row = mysqli_fetch_assoc($res);
	close_dbconnection($conn);    
    //echo 'user: '.$row[0].' - pass: '.$row[1];

	if ($row[0]!="" && $pass==$row[1]){
		$bool=1;
	}
	
	return $bool;
}


function isuser_sec($user, $pass){
    $bool=0;
	$table="utenti";

	$conn=open_dbconnection("default");
	$sql='select nome,password from '.$table.' where password="'.$pass.'" and nome="'.$user.'"';
	$res=run_sql($sql,$conn);
	$row = mysqli_fetch_assoc($res);
	close_dbconnection($conn);
    
    //echo 'user: '.$row[0].' - pass: '.$row[1];

	if ($row[0]!="" && $pass == $row[1]){
		$bool=1;
	}
	
	return $bool;
}

/*
	
	effettua la registrazione nel database e nelle variabili di sessione
	dei dati relativi alla connessione

*/

function log_accesso($ip,$browser){		

	// visitatore		
	$utente="anonymous";

	// data
	$table="accessi";
	$data=estrai_data();

	// finding an index for entry
	$query_adds="default";
	//$radice=get_radiceid($table);
	$id=find_nextIndex($table);
	$ora = estrai_ora();

	$values=string2array($id."+".$ip."+".$browser."+".date("Y-m-d")."+".$ora."+".$utente,"+");

	add_record($table,$values);

	return $id;
}

function select2array($table,$campiselect,$nomecampi,$valorecampi,$query_extra){
	
	$conn=open_dbconnection("default");

	$sql="select ".$campiselect[0];
	
	$i=1;
	while($campiselect[$i]!=""){
		
		$sql=$sql.",".$campiselect[$i];
		$i=$i+1;
	}
	
	$sql=$sql." from ".$table;
	
	if($nomecampi!=""){
		$sql=$sql." where ".$nomecampi[0]."='".$valorecampi[0]."'";

		$i=1;
		while($nomecampi[$i]!=""){
			
			$sql=$sql." and ".$nomecampi[$i]."='".$valorecampi[$i]."'";
			$i=$i+1;
		}
	}
	
	$sql=$sql." ".$query_extra;
	$res=mysqli_query($conn,$sql)
	or die("Errore! Non ho potuto eseguire l'istruzione SQL (select): " . mysqli_error($conn));
	
	$i=0;
	$array[$i] = mysqli_fetch_assoc($res);
	
	while($array[$i]!=""){
		
		$i=$i+1;
		$array[$i] = mysqli_fetch_assoc($res);
	}
	
	close_dbconnection($conn);

	return $array;
}

/*

	Gestione primitiva delle classi di utente

*/

function get_classiConsentite($user){
	if($user!="" && $user!="anonymous"){

		$string="";
		$classe_utente=getPesoClasse($user);

		$conn=open_dbconnection("default");
		$sql="select classe,livello from classi order by livello asc";
		$res=mysqli_query($conn,$sql)
		or die("Errore! Non ho potuto eseguire l'istruzione SQL (select): " . mysqli_error($conn));
		$row = mysqli_fetch_assoc($res);

		while($row!=""){

			if($row[1]>$classe_utente){
				
				$string=$row[0]." ".$string;
			}else if($row[1]==$classe_utente){
                $classeutente=$row[0];                
            }            
			$row = mysqli_fetch_assoc($res);
		}
        $string = $classeutente." ".$string;

		close_dbconnection($conn);
	}else{
		
		$string="public";
	}
	return $string;
		
}


function get_classiUtente($classe){
    
    if ($classe!="" && $classe != "public"){
        $string="$classe public";
    }else{
        $string="public";
    }

	$conn=open_dbconnection("default");
	$sql="select distinct classe from classi order by livello desc";
	$res=mysqli_query($conn,$sql)
	or die("Errore! Non ho potuto eseguire l'istruzione SQL (select): " . mysqli_error($conn));
	$row = mysqli_fetch_assoc($res);

	while($row!=""){
		if($classe == $row[0] || $row[0] == "public"){
            $row = mysqli_fetch_assoc($res);
        }else{
            $string=$string." ".$row[0];
            $row = mysqli_fetch_assoc($res);
        }
	}

	close_dbconnection($conn);

	return $string;
		
}

/*

	ritorna il peso della classe di un utente

*/

function getPesoClasse($user){
	
	$conn=open_dbconnection("default");
	$sql="select livello from utenti natural join classi where utenti.nome='".$user."'";
	$res=mysqli_query($conn,$sql)
	or die("Errore! Non ho potuto eseguire l'istruzione SQL (select): " . mysqli_error($conn));
	$peso = mysqli_fetch_assoc($res);
	close_dbconnection($conn);
	
	return $peso[0];
}

/*

	ritorna la lista degli utenti

*/
function get_listaUtenti(){

	$string="";

	$conn=open_dbconnection("default");
	$sql="select nome from utenti order by nome desc";
	$res=mysqli_query($conn,$sql)
	or die("Errore! Non ho potuto eseguire l'istruzione SQL (select): " . mysqli_error($conn));
	$row = mysqli_fetch_assoc($res);

	while($row!=""){
		
		$string=$row[0]."+".$string;
		$row = mysqli_fetch_assoc($res);
	}

	close_dbconnection($conn);

	return $string;
		
}

function get_listaCartelle($tabella,$cartella){
    
    if ($cartella!=""){
        $string="$cartella+-home-";
    }else{
        $string="-home-";
    }

	$conn=open_dbconnection("default");
	$sql="select distinct cartella from $tabella order by cartella asc";
	$res=mysqli_query($conn,$sql)
	or die("Errore! Non ho potuto eseguire l'istruzione SQL (select): " . mysqli_error($conn));
	$row = mysqli_fetch_assoc($res);

	while($row!=""){
		if($cartella == $row[0] || $row[0] == "-home-"){
            $row = mysqli_fetch_assoc($res);
        }else{
            $string=$string."+".$row[0];
            $row = mysqli_fetch_assoc($res);
        }
	}

	close_dbconnection($conn);

	return $string;
		
}



function get_lista($campo){

    switch($campo){
        case "supporto":
            $string="Mp3+Cd+Mc+DvD+Avi";
            break;
            
        case "genere":
            $string="Rock+Hard Rock+Metal+Heavy Metal+Power+Progressive+Altro";
            break;
            
        case "destinatario":
            $string=get_listaUtenti();
            break;
            
        default:
            $string = "-";
            break;                
    }
	

	return $string;
		
}



/*
	
	controlla se è un id valido per la tabella

*/
function validid($id,$id_alias,$table){

	$conn=open_dbconnection("default");
	$sql="select ".$id_alias." from ".$table." where ".$id_alias."='".$id."'";
	$res=mysqli_query($conn,$sql)
	or die("Errore! Non ho potuto eseguire l'istruzione SQL (select): " . mysqli_error($conn));
	$row = mysqli_fetch_assoc($res);	
	close_dbconnection($conn);

	return ($row[0]=="" && $id!="" && $id[0]!=" ");
}

?>