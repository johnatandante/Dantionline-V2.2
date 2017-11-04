<?php
$error_message = "not_autenticated";
$level = 0;
addline('<table width=100%>',$level);
addline('<tr><th class = "menu_2">Errore di autenticazione!</th>',$level);
addline('<tr><td></td>',$level);
print_errorMessage($error_message);
addline('<tr><td></td>',$level);
addline('</table>',$level);

?>