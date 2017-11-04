<?php

	//session_start();
	//$table="";

	addline('<table class="centered" width="100%"  valign="top">',$level);
	addline('<tr> <th class="menu">Contattami</th>',$level);
	addline('<tr><td><br></td>',$level);
	addline('<tr>	<td><table align="center" width="95%">',$level);
	addline('		<td class="left">Ecco come puoi contattarmi:<br>',$level);
	addline('		<ul>',$level);
	addline('		<li>mail: <a class="link" href="mailto:'.$webmaster_mail.'">'.$webmaster_mail.'</a></li>',$level);
	addline('		<li>IRC: se ci sono, ho il nick <b>dantiii</b></li>',$level);
	addline('		</ul>',$level);
	addline('		</td>',$level);
	addline('		</table></td>',$level);

	if ($utente=="anonymous"){
		addline('<tr> <td><br></td>',$level);
		addline('<tr> ',$level);

		addline('<td align="center">',$level);
		addline('<table width="80%">',$level);
		addline('<tr><th class="menu_2">Avviso</th>',$level);
		addline('<tr> <td class="low_warning">Vuoi essere anche tu del gruppo? <br> ',$level);
		addline('	Allora compila il form che ti verrà presentato seguendo questo <a class="link" href="index.php?page=newutente">link</a>.</td>',$level);
		addline('</table>',$level);
		addline('</td>',$level);

	}
		addline('</table>',$level);
?>

