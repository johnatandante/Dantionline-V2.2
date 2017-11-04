<?
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	session_start();
	require "util/db_conf.php";
	require "util/utility.php";
	require "util/db_tools.php";

	if(isset( $page) && $page == "in"){
		if($new==1){
			
			$table="utenti";
			$id_alias="nome";
			
			// actionframe
			$actionframe="gestioneutenti.php";

			if($inserisci="inserisci"){
				
				// controllo se ha un id valido
				if(validid($campo[0],$id_alias,$table)){
				
					add_record($table,$campo);
					$nome_utente=$campo[0];
					$password_utente=$campo[5];			
				}else{

					$nome_utente="";
					$error_message="invalid_name";
				}
			}
			
		}
		$found=0;
		$nome_utente=htmlspecialchars($nome_utente);

		//$utente è variabile di sessione
		//$password è variabile di sessione
		if($nome_utente!="" && $nome_utente!="anonymous"){
			
			$table="utenti";
			$conn=open_dbconnection("default");
			$sql="select nome,descrizione,classe,mail,sitoweb,password,foto,commento,last_login from ".$table." order by nome";
			$res=run_sql($sql,$conn);
			$row = mysqli_fetch_assoc($res);			

			while($row[0]!="" && $found!=1){
				if($row[0]==$nome_utente){
					if($row[5]==$password_utente){
						$found=1;
						$mail=$row[3];
						$sito=$row[4];
						$foto=$row[6];
						$commento_utente=$row[7];
						$last_login=$row[8];
						$classe=$row[2];
						$utente=$nome_utente;
						$password=$password_utente;
					}else{
						$found=2;
					}
				}
				$row = mysqli_fetch_assoc($res);
			}
			close_dbconnection($conn);
			
		}

	}

	if(isset($page) && $page == "out"){
		$logged=2;
		$utente="";		
	}

	require "util/show.php";
	require "util/doc_tools.php";
	
	require "util/startup_variabili.php";

    $is_admin = isadmin_sec($utente, $password);
    $is_user = isuser_sec($utente, $password);

?>

<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title> DantiOnLine </title>
<meta name="Generator" content="EditPlus">
<meta name="Author" content="Dantiii">
<meta name="Keywords" content="">
<meta name="Description" content="A little personal site made in PHP&MySql">

<link rel="stylesheet" type="text/css" href="stile_dagh.css" />
</head>
<body class="darkside" >

<?php
    if(!isset($level))
        $level = 0;
    
    addline('<table width=100%>',$level);
    addline('<tr><td>',$level);
        require "banner.php";
    addline('</td></table>',$level);

    addline('<table width=100%>',$level);
    addline('<tr>',$level);
    addline('<td valign="top" width=200>',$level);
        require "menu.php";
    addline('</td>',$level);
    addline('<td valign="top">',$level);
	
	switch($page){
		
		case "main":
			require "main.php";
			break;
		
		case "io":
			require "mipresento.php";
			break;

		case "blog":
			require "myblog.php";
			break;
		
		case "news":
			require "news.php";
			break;
		
		case "photo":
			require "photoalbum.php";
			break;
		
		case "articoli":
			if (!$is_user){
                require "no_autentication.php";
            }else{
    			require "articoli.php";
            }
			break;
        
        case "musica":
			if (!$is_user){
                require "no_autentication.php";
            }else{
    			require "musica.php";
            }
			break;            
		
		case "contat":
			require "contattami.php";
			break;
		
		case "utenti":
            if (!$is_user){
                require "no_autentication.php";
            }else{
    			require "utenti.php";
            }
			break;
		
		case "mailbox":
            if (!$is_user){
                require "no_autentication.php";
            }else{
    			require "mailbox.php";
            }
			break;
		
		case "sfogo":
            if (!$is_user){
                require "no_autentication.php";
            }else{
    			require "sfogatoio.php";
            }
			break;
		
		case "guestb":
			require "guestbook.php";
			break;

		case "gprofilo":
            if (!$is_user){
                require "no_autentication.php";
            }else{
    			require "gestioneprofilo.php";            
            }
			break;
					
		case "gaccessi":
            if (!$is_admin){
                require "no_autentication.php";
            }else{
			    require "gestioneaccessi.php";
            }
			break;
			
		case "gutenti":
            if (!$is_admin){
                require "no_autentication.php";
            }else{
			    require "gestioneutenti.php";
            }
			break;

		case "gclassi":
            if (!$is_admin){
                require "no_autentication.php";
            }else{
			    require "gestioneclassi.php";
            }
			break;
			
		case "gnews":
            if (!$is_user){
                require "no_autentication.php";
            }else{
			    require "gestionenews.php";
            }
			break;
			
		case "garticoli":
            if (!$is_user){
                require "no_autentication.php";
            }else{
    			require "gestionearticoli.php";
            }
			break;
            
        case "gmusic":
            if (!$is_user){
                require "no_autentication.php";
            }else{
    			require "gestionemusica.php";
            }
			break;

        case "gdownloads":
            if (!$is_user){
                require "no_autentication.php";
            }else{
    			require "gestionedownloads.php";
            }
			break;
			
		case "gphoto":
            if (!$is_user){
                require "no_autentication.php";
            }else{
    			require "gestionephoto.php";
            }
			break;
		
		case "newutente":
			require "newaccount.php";
			break;

		case "goodlinks":
			require "goodlinks.php";
			break;

		case "downloads":
			require "downloads.php";
			break;
		
		case "out":
			require "out.php";
			break;
		
		case "in":
			if($found==1){
				// bisogna fare l'update nella tabella degli utenti per 
				// aggiornare il campo ultimo login
				$data=estrai_data();
				$conn=open_dbconnection("default");
				$sql='update '.$table.' SET last_login= "'.$data.'" WHERE nome="'.$nome_utente.'"';
				$res=run_sql($sql,$conn);
				close_dbconnection($conn);

				$id_accesso=log_accesso($_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT']);

				$table="accessi";
				$sql='update '.$table.' SET nome= "'.$nome_utente.'" WHERE id="'.$id_accesso.'"';
				$conn=open_dbconnection("default");
				$res=run_sql($sql,$conn);			
				close_dbconnection($conn);			
				//$logged=1;
				require "main.php";
				
			}else{

				if($new!=1){
					
					$error_message="access_denied";
				}

				require "login_failure.php";
			}
			break;

		default:
			require "main.php";
			break;
	}
    addline('</td>',$level);
    addline('<td valign="top" width=200>',$level);
        require "menu_utente.php";
    addline('</td>',$level);
    addline('</table>',$level);
?>
</body>
</HTML>
