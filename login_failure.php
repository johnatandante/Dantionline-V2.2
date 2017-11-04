<?php
	addline('<table>',$level);
	addline('<tr><th class="menu_2">Attenzione!</th>',$level);
	
	print_errorMessage($error_message);
	$error_message="";

	addline('<tr><td align =center>Per chiarimenti contattare l\'amministratore del sito seguendo questo <a class=link href=mailto:'.$webmaster_mail.'>link</a>.</td>',$level);

	addline('<tr> <td><br></td>',$level);

	printspacer(1);
	addline('<tr> ',$level);
	addline('<td align="center">',$level);
	addline('<table width="80%">',$level);
	addline('<tr><th class="menu_2">Avviso</th>',$level);
	addline('<tr> <td class="low_warning">Vuoi essere anche tu del gruppo? <br> ',$level);
	addline('Allora compila il form che ti verrà presentato seguento questo <a class="link" href="index.php?page=newutente">link</a>.</td></table></td>',$level);
	
	printspacer(1);

	addline('<tr><th class="menu_2" align="center"><a class="link" href="index.php">ritorna al sito</a></td>',$level);
	addline('</td></table>',$level);
?>

