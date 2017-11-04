<?php
$level = 0;
$banner_mozilla = string2array("Dantiionline_01_01.png,Dantiionline_01_02.png,Dantiionline_01_03.png,firma.png", ",");
$banner_ie = string2array("Dantiionline_01_01b.jpg,Dantiionline_01_02b.jpg,Dantiionline_01_03b.jpg,firmab.jpg",",");

$banner = $banner_ie;
$i = 0;

addline('<table align="center" id="Table_01" width="399" height="70" border="0" cellpadding="0" cellspacing="0">',$level);
addline('<tr>',++$level);
addline('<td>',++$level);
addline('<img src="img/banner/'.$banner[$i++].'" width="289" height="55" alt=""></td>',$level);
addline('<td>',--$level);
addline('<img src=img/banner/'.$banner[$i++].' width="110" height="55" alt=""></td>',$level);
addline('</tr>',--$level);
addline('<tr>',$level);
addline('<td>',++$level);
addline('<img src=img/banner/'.$banner[$i++].' width="289" height="15" alt=""></td>',$level);
addline('<td>',--$level);
addline('<!--a href="http://www.emanuela-pitassi.tk" target = "ManuTheArtist" onmouseover="window.status=\'logo by emanuela pitassi\';  return true; onmouseout="window.status=\'\';  return true;"-->',--$level);
addline('<img src=img/banner/'.$banner[$i++].' width="110" height="15" border="0" alt="logo by emanuela pitassi"><!--/a--></td>',++$level);
addline('</tr>',--$level);
addline('</table>',--$level);
?>