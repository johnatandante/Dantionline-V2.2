<?php

	if(!session_is_registered("lupdate")){		
		session_register("lupdate");
		$lupdate="";
	}

	if(!session_is_registered("lora")){		
		session_register("lora");
		$lora="";
	}


	if(!session_is_registered("fupdate")){		
		session_register("fupdate");
		$fupdate="";
	}

	if(!session_is_registered("password")){

		session_register("password");
		$password="";
	}

	if(!session_is_registered("logged")){

		session_register("logged");
		$logged=0;
	}

	if(!session_is_registered("foto")){

		session_register("foto");
		$foto="";
	}

	if(!session_is_registered("messaggio")){

		session_register("messaggio");		
		$messaggio="";	
	}

	if(!session_is_registered("commento_utente")){

		session_register("commento_utente");
		$commento_utente="";
	}

	if(!session_is_registered("mail")){

		session_register("mail");		
		$mail="";	
	}

	if(!session_is_registered("webmaster_mail")){

		session_register("webmaster_mail");		
		$webmaster_mail="";	
	}

	if(!session_is_registered("sito")){

		session_register("sito");		
		$sito="";	
	}

	if(!session_is_registered("classe")){

		session_register("classe");		
		$classe="";
	}

	if(!session_is_registered("last_login")){

		session_register("last_login");
		$last_login="";
	}

	if(!session_is_registered("n_visitatori")){

		session_register("n_visitatori");
		$n_visitatori="";		
	}


	if(!session_is_registered("error_message")){

		session_register("error_message");
		$error_message="";		
	}

	if(!session_is_registered("utente")){

		session_register("utente");
		$utente="anonymous";
	}

	if(!session_is_registered("id_accesso")){
		
		session_register("id_accesso");
		$id_accesso="";	
	}

	if ($id_accesso == ""){
		$id_accesso = log_accesso($_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT']);
	
	}

	if ($utente == "anonymous" || $utente == ""){
		$utente = "anonymous";
		$classe="public";
		
		// info del sito:
		// last update
		$row=select("news",string2array("data"," "), string2array(""," "), string2array(""," ")," order by data desc");
		$lupdate=$row["data"];

		// last ora
		$row=select("accessi",string2array("ora"," "), string2array(""," "), string2array(""," ")," order by id desc");
		$lora=$row["ora"];

		// first update
		$row=select("news",string2array("data"," "), string2array(""," "), string2array(""," ")," order by data asc");
		$fupdate=$row["data"];
		
		$row=select("utenti",string2array("mail foto commento"," "), string2array("nome"," "), string2array("webmaster"," "),"");

		// carico parte del profilo dell'amministratore
		$webmaster_mail=$row["mail"];
		$mail = $row["mail"];
		$foto_main = $row["foto"];
		$commento_utente=$row["commento"];
		$messaggio="";			

	}


?>