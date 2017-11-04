<?php

function session_register($key_name){
    $_SESSION[$key_name] = '';
}

function session_is_registered($key_name) {
    return $_SESSION[$key_name];
}

function find_nextIndex($table){
    
	//echo('<br>Next index for: '.$table);
	$zero_padding = 8;
	
    $field_id = "id";
    
	$row = select($table,string2array($field_id, " "), "", "", " order by ".$field_id." desc");
	
	$s = 0;
    
    $string_read =  $row[$field_id];
    $i = 0;
    $intvalue = 0;
    
	if (isset($row) && isset($row[$field_id])){
        while($i < strlen($string_read) ) {
            $intvalue =str2int($row[$field_id][$i]);
            $i++;
            if($intvalue >= 0 || $s > 0){
                $s = $s + pow(10, strlen($string_read) - $i) 
                        * $intvalue;
                
            }
            
        }
	}
    
	$s++;
    
	$nextIndex = int2str($s, $zero_padding);
    
	$nextIndex=get_radiceid($table).$nextIndex;
    
	//echo('<br>nextIndex: '.$nextIndex);
    
	return $nextIndex;
}

function int2str($num, $zeros){
	
	$ten = 1;
	$i=0;
	$str= "".$num;
    
	while ($ten <= $num && $i<$zeros){
		$i++;
		$ten=$ten*10;		
	}
	

	while($zeros>$i){
		$str = "0".$str;
		$i++;
	}

	return $str;
}

function str2int($char){
	$num = 0;

	switch($char){
		case "1":
			$num = 1;
			break;
		
		case "2":
			$num = 2;
			break;

		case "3":
			$num = 3;
			break;
		
		case "4":
			$num = 4;
			break;
		
		case "5":
			$num = 5;
			break;
		
		case "6":
			$num = 6;
			break;
		
		case "7":
			$num = 7;
			break;
		
		case "8":
			$num = 8;
			break;

		case "9":
			$num = 9;
			break;
					
		case "0":
			$num = 0;
			break;
            
		default:
			$num = 0;
			break;
	}
	return $num;

}

function getextension($file_name){
	
	$extension="";
	
	$i=dim($file_name)-1;

	//addline('sizeof ".$i;
	while($i>0 && $file_name[$i]!='.'){
		
		$extension=$file_name[$i]."".$extension;
		$i=$i-1;
	}
	
	// caso eccezzionale
	if($i==0){
		
		// no extension
		$extension="";
	}
	
	//addline('filename: ".$file_name." extension: ".$extension;
	return ".".$extension;
}

function dim($stringa){
	
	$i=0;
	while($stringa[$i]!=""){
		$i=$i+1;
	}
	return $i;
}

/*

	da una lista di parametri in formato stringa ho un array di stringhe

*/
function string2array($stringa,$marker){

	$i=0;
	$j=0;
    $array = [];
	while(isset($stringa[$i]) && $stringa[$i]!=""){
        if($stringa[$i]==$marker){
            $array[] = '';
			$j=$j+1;
		}else{
            // nuovo elemento
            if(!isset($array[$j]))
                $array[] = '';
            
			$array[$j]=$array[$j]."".$stringa[$i];
		}
		$i=$i+1;
	}

	return $array;	
}


/*
	
	chiama la funzione getdate() e ne estrae la data in modo più umano
	sottoforma di stringa

*/
function estrai_data(){
	
	$data=date("Y-m-d");
	return $data; 
}

function estrai_ora(){
	
	$ora=date("H:i:s a");
	return $ora; 
}

function getMyTime($tempo){
	//addline('devo stampare questa ora: ".$tempo."<br>";	

	return $tempo;
}

function getWDMY($d,$m,$y){
	//int mktime (int hour, int minute, int second, int month, int day, int year [, int is_dst])
	$w = strftime("%w", mktime (0,0,0,$m,$d,$y));
	$mesi=string2array("Gen,Feb,Mar,Apr,Mag,Giu,Lug,Ago,Set,Ott,Nov,Dic", ",");
	$giorni=string2array("Domenica,Lunedì,Martedì,Mercoledì,Giovedì,Venerdì,Sabato", ",");
	
	return "".$giorni[$w].", ".$d." ".$mesi[$m-1]." ".$y."";
}

function getMyData($data){
	//addline('devo stampare questa data: ".$data."<br>";
	$i=0;
	$year = 0;

	while ($i<4){
		$year = $year * 10;
		$year = $year + str2int($data[$i]);
		$i++;
	}

	$i++;
	$month = 0;

	while ($i<(4+3)){
		$month = $month * 10;
		$month = $month + str2int($data[$i]);
		$i++;
	}

	$i++;
	$day = 0;

	while ($i<(4+3+3)){
		$day = $day * 10;
		$day = $day + str2int($data[$i]);
		$i++;
	}
	
	//addline('data corretta: ".$day."gg ".$month."mm ".$year."aa";

	$data = getWDMY($day,$month,$year);

	return $data;

}

/*
	
	funzione inversa di string 2 array

*/
function array2string($array,$marker){
	
	$stringa=$array[0][0];
	$i=1;
	while($array[$i][0]!=""){
		
		$stringa=$stringa."".$marker."".$array[$i][0];
		$i=$i+1;
	}

	return $stringa;

}

// controlla se una variabile è elemento di un array
// nota: la stringa non può essere null!!!
function ismemberof($stringa,$array){

	$bool=0;
	
	$i=0;
	while($array[$i]!="" && $array[$i]!=$stringa){
		//echo $i.':finding: '.$array[$i].' - '.$stringa ;
		$i=$i+1;
	}

	if($i<sizeof($array)){

		//addline('<br>'.$i.':trovato: '.$array[$i].' - '.$stringa ;
		$bool=1;
	}

	return $bool;

}


function get_radiceid($table){
	
	$r="";

	switch($table){
		
		case "guestbook":
			$r="gbuk";
			break;
        
        case "downloads":
			$r="dnwl";
			break;

		case "news":
			$r="news";
			break;

		case "articoli":
			$r="arts";
			break;

		case "docs":
			$r="docs";
			break;

		case "accessi":
			$r="accs";
			break;

		case "mail":
			$r="mail";
			break;
            
        case "music":
			$r="song";
			break;
	}
	return $r;
}

function preview($stringa,$num){
	
	$s="";
	$i=0;
	while($stringa[$i]!="" && $i<$num){
		
		$s=$s.''.$stringa[$i];
		$i=$i+1;
	}
	
	if($i==$num){
		$s=$s.'...';
	}
	return $s;
}


/*

	vede se l'utente ha il diritto di modificare un documento di un certo autore

*/
function canEdit($user, $autore){
	
	$bool=0;

	if($user==$autore || isadmin($user)==1){
		
		$bool=1;
	}

	return $bool;
}

/*

	controlla se una variabile è inizializzata

*/
function notnull($var){
	
	return $var!="";
}

/*

	per i messaggi d'errore

*/
function print_errorMessage($err_code){

	switch($err_code){
	
		case "invalid_entry_guestbook":
			addline('<tr><td colspan=5 class=warning>Hai inserito dei dati non validi: controlla che i campi "visitatore" e "messaggio" non siano vuoti.</td>',0);
			break;

        case "internal_error":
			addline('<tr><td colspan=5 class=warning>Si è verificato un errore interno al database: l\'azione sarà annullatta</td>',0);
			break;
		
		case "access_denied":
			addline('<tr><td class=warning>Si è verificato un errore nell\'autenticazione: il nome utente e/o la password non sono state accettate dal sistema.</td>',0);
			printspacer(0);
			addline('<tr><td class=warning>Prego controllare l\'esattezza dei dati immessi e riprovare.</td>',0);
			break;
		
		case "invalid_name":
			addline('<tr><td colspan=5 class=warning>Hai inserito dei dati non validi: hai inserito un nome utente già esistente nel sistema. <br>Ti consiglio di sceglierne un\'altro, mantenendo la stessa radice e completandolo con numeri o sigle varie.</td>',0);
			break;
		
		case "file_not_uploaded":
			addline('<tr><td colspan=5 class=warning>Non sono riuscito a caricare il file che hai fornito come input: controlla che la sua dimensione sia inferiore ad 1 MB e riprova.</td>',0);
			break;
		
		case "wrong_password":
			addline('<tr><td colspan=5 class=warning>Hai inserito dei dati non validi: controlla che tu abbia inserito effettivamente la password corretta e/o di aver sbagliato di digitare la nuova password nel campo \"Re-Type New Password\".</td>',0);
			break;
		
		case "no_data":
			addline('<tr><td colspan=5 class=warning>Non hai inserito nessun dato nella textarea, dato che è rimasta vuota. Per inserire con successo i dati occorre che sia compilato almeno quel campo.</td>',0);
			break;		
       
        case "not_autenticated":
            addline('<tr><td class="warning">Attenzione: si è verificato un errore di autenticazione: il sistema non ti ha riconosciuto come utente abilitato a vedere il contenuto di questa pagina.<br><br>Molto probabilmente è "scaduta" la sessione, quindi ti prego di re-inserire nome-utente e password per l\'autenticazione.</td>',$level);
			break;

	
	}

	printspacer(1);

}

function print_simpleMessage($msg_code){
    addline('<tr><td><table>', 0);
    switch($msg_code){
        case "new_user":
			addline('<tr><td width = 50 /><td class="low_warning">Compilando questo form ti sarà concesso l\'accesso all\'area privata del sito. <br><br> Devi fornire alcuni dati personali validi che saranno usati esclusivamente ai fini della sicurezza della gestione del sito.<br><br> In qualunque momento ti potrà essere revocato l\'accesso come conseguenza di una condotta che infrange la Nettiquette, quindi fai buon uso di questo account.<br><br>L\'account è PERSONALE e quindi sarai responsabile di tutte le azioni a te imputabili mediante l\'uso di questo account.</td><td width = 50 />',$level);
			break;
            
		case "password_changed":
			addline('<tr><td colspan=5 class=low_warning>Password cambiata con successo!</td>',0);
			break;
        case "data_updated":
            addline('<tr><td colspan=5 class=low_warning>Dati aggiornati con successo!</td>',0);
			break;
    }
    addline('</table></td></tr>', 0);
    
    printspacer(1);
    
}


/*

	funzione che effettua un print di una riga di una tabella vuota alta
	$nrows

*/
function printspacer($nrows){
	
	$brs="";
	$i=0;
	while($i<$nrows){
		
		$brs=$brs."<br>";
		$i=$i+1;
	}
	addline('<tr><td>'.$brs.'</td>',0);
}

function addline($string, $livello){
	$i = 0;
	$tab = "\t";
	while($i<$livello){
		$tab = $tab."\t";
		$i++;
	}
	$line = "\n".$tab.$string;

	echo $line;
}

function multiline($stringa){
	
	return str_replace("\n","<br>",$stringa);
}

function sstrongest($stringa){
	
	return str_replace("#sb","<strong>",$stringa);
}

function estrongest($stringa){
	
	return str_replace("#eb","</strong>",$stringa);
}

function strongest($stringa){
	
	return sstrongest(estrongest($stringa));
}

function semph($stringa){
	
	return str_replace("#sem","<em>",$stringa);
}

function eemph($stringa){
	
	return str_replace("#eem","</em>",$stringa);
}

function emph($stringa){
	
	return semph(eemph($stringa));
}

function animoticons($stringa){    
    $stringa = str_replace("#stu","<img src='img/animoticons/stu.gif' />",$stringa);    
    $stringa = str_replace("#headbang","<img src='img/animoticons/headbang.gif' />",$stringa);
    $stringa = str_replace("#;)","<img src='img/animoticons/sorriso.gif' />",$stringa);    
    $stringa = str_replace("#bart","<img src='img/animoticons/bart.gif' />",$stringa);
    $stringa = str_replace("#angelo1","<img src='img/animoticons/angelo_1.gif' />",$stringa);
    $stringa = str_replace("#devil1","<img src='img/animoticons/devil_1.gif' />",$stringa);
    $stringa = str_replace("#uniud","<img src='img/animoticons/uniud.gif' />",$stringa);
    $stringa = str_replace("#wip1","<img src='img/animoticons/wip_1.gif' />",$stringa);
    $stringa = str_replace("#wip2","<img src='img/animoticons/wip_2.gif' />",$stringa);
    $stringa = str_replace("#warrior","<img src='img/animoticons/warrior.gif' />",$stringa);
    $stringa = str_replace("#tv","<img src='img/animoticons/tv.gif' />",$stringa);
    $stringa = str_replace("#ciak","<img src='img/animoticons/ciak.gif' />",$stringa);
	return $stringa;
}


function richtext($stringa){
    
    $stringa = animoticons($stringa);
    $stringa = multiline($stringa);
    $stringa = emph($stringa);
    $stringa = strongest($stringa);

    return $stringa;
}


function getRigthUrl($stringa){

	if($stringa!=""){
			
		if(strtolower($stringa[0]) == "w" && strtolower($stringa[1]) == "w" && strtolower($stringa[2]) == "w" && $stringa[3] == "."){
			$stringa = "http://".$stringa;
		}
	}
	return $stringa;
}
?>