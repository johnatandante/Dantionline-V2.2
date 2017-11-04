<?php
	$level = 0;
	$pagina = "index.php?page=";
	$n_visitatori=contatuple("accessi","id","");
	$admn=isadmin_sec($utente, $password);
	$pagina_utente = array(
							"gnews" => "Gestione News",
							"garticoli" => "Gestione Articoli",
							"gphoto" => "Gestione PhotoAlbum",
							"gdownloads" => "Gestione Downloads");
    
    $pagina_musica = array ("ggroup" => "Gestione Album",
                            "galbum" => "Gestione Album");

	$pagina_admin = array("gaccessi" => "Gestione Accessi",
							"gutenti" => "Gestione Utenti",
							"gclassi" => "Gestione Classi");

                            

	addline('<TABLE width=80% align="center">',$level);

	if($utente!="anonymous" && $utente!=""){
		
		// gestione profilo
		addline('<tr> <th class="menu">Utente: '.$utente.'</th>',$level);
        addline('<tr><td>',$level);
        addline('<TABLE width="80%" align="center" class="centered">',$level);

		if ($page=="gprofilo") {
			// Pagina corrente
			addline('<tr><td class = "c_page"> &gt;Gestione Profilo</td>',$level);
		} else {
			// Altre pagine
			addline('<tr><td class = "left"><a class = "link" href="'.$index.'gprofilo">Gestione Profilo</a></td>',$level);
		}
		
		if($admn==1){

			// Inizio a scorrere l'array
			while (list($url,$desc)=each($pagina_admin)) {
				if ($url==$page) {
					// Pagina corrente
					addline('<tr><td class = "c_page"> &gt; '.$desc.'</td>',$level);
				} else {
					// Altre pagine
					addline('<tr><td class = "left"><a class = "link" href="'.$index.''.$url.'">'.$desc.'</a></td>',$level);
				}
			}

		}
				
		// Inizio a scorrere l'array
		while (list($url,$desc)=each($pagina_utente)) {
			if ($url==$page) {
				// Pagina corrente
				addline('<tr><td class = "c_page"> &gt; '.$desc.'</td>',$level);
			} else {
				// Altre pagine
				addline('<tr><td class = "left"><a class = "link" href="'.$index.''.$url.'">'.$desc.'</a></td>',$level);
			}
		}

		addline('<tr>',$level);
		// form logout
		addline('<form action="'.$pagina.'out" method="post">',$level);
		addline('<tr><td class="centered"><input type="submit" name="b_send" value="logout"></td>',$level);	
	 }else{
		addline('<tr> <th class="menu">AreaPrivata</th>',$level);
        
        addline('<tr><td>',$level);
        addline('<TABLE width="80%" align="center" class="centered">',$level);
		// form login
		addline('<form action="'.$pagina.'in" method="post">',$level);
		addline('<tr><td><table border=0 align="center"></td>',$level);
		addline('<tr><td class="centered">utente</td><td><input type="text" name="nome_utente" size="10"></td>',$level);
		addline('<tr><td class="centered">password</td><td><input type="password" name="password_utente" size="10"></td>',$level);
		addline('</table></td>',$level);
		addline('<tr><td class="centered"><input type="reset" name="b_reset" value="reset"><input type="submit" name="b_send" value="login"></td>',$level);
		
		printspacer(1);
		addline('<tr> ',$level);
		addline('<td align="center">',$level);
		addline('<table>',$level);
		addline('<tr><th class="menu_2">Iscriviti al sito</th>',$level);
		addline('<tr> <td class="low_warning">',$level);
		addline('Compila il form seguendo questo <a class="link" href="'.$pagina.'newutente">link</a>.</td></table></td>',$level);

	 }

	addline('</form>',$level);
    addline('</td></table>',$level);
 
	printspacer(1);
	addline('<tr> <th class="menu">QuestoSito</th>',$level);
	addline('<tr> <td class="left"># Visitatori dal <br>'.getMyData($fupdate).'</td>',$level);
	addline('<tr> <td class="centered"><strong>',$level);
	echo $n_visitatori;
	addline('</strong></td>',$level);
	addline('<tr> <td class="left"># Last Update on: </td>',$level);
	addline('<tr> <td class="centered">',$level);
	
	echo getMyData($lupdate);

	addline('</td>',$level);	
    printspacer(1);
	addline('<tr> <td class="left"><img src="img/icone manu/icon_php.png"></td>',$level);
    addline('<tr> <td class="left"><img src="img/icone manu/icon_mysql.png"></td>',$level);
    addline('<tr> <td class="left"><img src="img/icone manu/icon_firefox.gif"></td>',$level);
	addline('<tr> <td class="left"><img height=33 width=133 src="img/icone manu/icon_notepadplusplus.gif"></td>',$level);
    
	addline('</table>',$level);
?>