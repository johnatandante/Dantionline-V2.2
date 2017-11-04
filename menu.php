<?php

if(!isset($page))
    $page = "";

$index = "index.php?page=";

$pagina = array("main" => "HomePage",
				"news" => "All News",
				"io" => "Mi Presento",
				"photo" => "Album Foto",
				"blog" => "My Blog",
				"guestb" => "Guestbook",
				"goodlinks" => "Good Links",
				"contat" => "Contattami");

$pagina_utente = array("utenti" => "Lista Utenti",
        				"articoli" => "Notizie dal Mondo",
                        //"musica" => "My Music",
        				"downloads" => "Downloads",
						"mailbox" => "MailBox",
						//"sfogo" => "Sfogatoio"
						);


addline('<TABLE width="80%" align="center" class="centered">',$level);
addline('<tr> <th class="menu">Menù</th>',$level);
addline('<tr><td>',$level);
addline('<TABLE width="80%" align="center" class="centered">',$level);

$p = $page;
if($p == "in"){
	$p = "main";
}

// Inizio a scorrere l'array
while (list($url,$desc)=each($pagina)) {

	if ($url==$p) {
		// Pagina corrente
		addline('<tr><td class = "c_page"> &gt; '.$desc.'</td>',$level);
	} else {
		// Altre pagine
		addline('<tr><td class=left><a class = "link" href="'.$index.''.$url.'">'.$desc.'</a></td>',$level);
	}
}

if($utente!="anonymous" && $utente!=""){
	printspacer(1);

	$new_msg = contatuple("mail", "nuovo","where destinatario='".$utente."' and nuovo='sì'");	

	// Inizio a scorrere l'array
	while (list($url,$desc)=each($pagina_utente)) {
		if($url == "mailbox" && $new_msg > 0 && $new_msg!= ""){
			$nmsg = '<strong>('.$new_msg.')</strong>';
		}else{
			$nmsg = '';
		}

		if ($url==$page) {
			// Pagina corrente
			addline('<tr><td class=c_page> &gt; '.$desc.$nmsg.'</td>',$level);
		} else {			
			// Altre pagine
			addline('<tr><td class=left><a class = "link" href="'.$index.''.$url.'">'.$desc.$nmsg.'</a></td>',$level);
		}
	}

}
addline('</td></TABLE>',$level);
addline('</TABLE>',$level);
?>
