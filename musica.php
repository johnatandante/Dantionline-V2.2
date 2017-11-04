<?php
$table = "music";
$id_alias = "id";

// actionframe
$actionframe = "index.php?page=musica";	
$target = "default";

if ($track == ""){
    $track = none;
}

$level = 0;

addline('<table class = "centered" border = 0 align = "center" width=95%>',$level);
    if ($album!="" || $gruppo!=""){
        addline('<tr><td colspan = 2 class = "menu">My Music: '.$gruppo.' - '.$album.'</td>',$level);
    }else{
        addline('<tr><td colspan = 2 class = "menu">My Music</td>',$level);
    }


    addline('<tr><td>',++$level);
    addline('<table align=center width = "80%">',++$level);

        addline('<tr><td><br></td>',$level);
        addline('<tr>',$level);
        addline('<td valign = "top">',$level);

        addline('<table width = "100%">',++$level);
        
        $query_extra = " order by gruppo asc";
        $campi=string2array("gruppo"," ");
        $nomecampi=string2array(""," ");
        $valorecampi=string2array("","*");        
        $row = select_list($table,$campi,$nomecampi,$valorecampi,$query_extra);
        $i=0;

        printspacer(1);
        
        $prev_gruppo="";
        
        while ($row[$i]!=""){
            //echo '<br>Current:'.$row[$i][0];
            $gruppo_istance = $row[$i][0];
            if ($prev_gruppo==$gruppo_istance){
                $prev_gruppo=$gruppo_istance;
                
            }else{
                $prev_gruppo=$gruppo_istance;
            
                addline('<tr><td align = "left">',$level);            
                                                    
                if (strtolower($row[$i][0]) != strtolower($gruppo)){
                    addline('<a class = "menulink" href="'.$actionframe.'&gruppo='.$gruppo_istance.'">',$level);
                }
                
                addline(ucfirst($gruppo_istance),$level);
                
                if (strtolower($row[$i][0]) != strtolower($gruppo)){
                    addline('</a>',$level);
                }
            
            
                if (strtolower($row[$i][0]) == strtolower($gruppo)){
                    // tiriam fuori tutta la siscografia                
                    
                    $query_extra = " order by anno asc";
                    $campi=string2array("album anno"," ");
                    $nomecampi=string2array("gruppo"," ");
                    $valorecampi=string2array($gruppo,"*");
                    $discografia = select_list($table,$campi,$nomecampi,$valorecampi,$query_extra);
                    
                    $j = 0;
                    while ($discografia[$j]!=""){
                        addline('<tr><td align = "rigth">',$level);
                        $album_istance = $discografia[$j][0];
                        $anno_istance = $discografia[$j][1];
                        
                        if (strtolower($discografia[$j][0]) != strtolower($album)){
                            addline('<a class = "menulink2" href="'.$actionframe.'&gruppo='.$gruppo_istance.'&album='.$album_istance.'"> * ',$level);
                        }else{
                            addline('<p class = "menu2"> * ',$level);
                        }
                        
                        addline(ucfirst($album_istance)." [".$anno_istance."]",$level);
                        
                        if (strtolower($discografia[$j][0]) != strtolower($album)){
                            addline('</a>',$level);
                        }else{
                            addline('</p>',$level);
                        }
                        addline('</td>',$level);
                        $j++;
                    }
                     
                    addline('</td></tr>',$level);
                }
                
                addline('</td>',$level);
                
            }
            $i++;
        }

    addline('</table>',--$level);
    addline('</td>',$level);
    
    addline('<td>',++$level);
    addline('<table align=left>',$level++);

        if($album!=""){
            //$table="articoli";
            $campi=string2array("file canzoni"," ");
            $nomecampi=string2array("album"," ");
            $valorecampi = string2array($album,"*");    
            $query_extra = " order by anno desc";
            
            $row = select($table,$campi,$nomecampi,$valorecampi,$query_extra);

            $foto_album = $row[0];
            $testo = $row[1];

            addline('<tr><td>',$level);
            addline('<table table align=left>',$level);
                addline('<tr><td width=150 class=centered align=center><img width=100 src="'.$foto_album.'"></td>',$level);
                addline('<td  valign=top>',$level);
                $k =0;
                
                $line=strtok($testo,"\n");
                    
                while($line!="" && $k<100){
                    $k++;
                    $table="articoli";
                    $exist = contatuple($table,"id"," where (link='".$album."' and extra='".$k."')");
                    if($exist > 0 && $k!=$track){
                        addline('<a class=link href="'.$actionframe.'&track='.$k.'&gruppo='.$gruppo.'&album='.$album.'">',$level);
                    }
                    
                    if ($k==$track){
                        $post="&lt;--";
                    }else{
                        $post="";
                    }
                    addline($k.' - '.$line.' '.$post,$level);
                    //addline($line.' '.$post,$level);
                   
                    if($exist > 0 && $k!=$track){
                        addline('</a><br>',$level);
                    }else{
                        addline('<br>',$level);
                    }
                    
                    $line=strtok("\n");        
                }
                addline('</td>',$level);
                
            addline('</table></td>',$level);

            printspacer(1);
                        
            $table = "articoli";
            
            $campi=string2array("titolo file articolo autore extra"," ");
            $nomecampi=string2array("cartella link classe extra"," ");
            $valorecampi = string2array("canzoni*".$album."*public*".$track,"*");    
            $query_extra = " order by titolo desc";

            $row = select_list($table,$campi,$nomecampi,$valorecampi,$query_extra);

            $j = 0;
            while($row[$j][0] != ""){
                $i = 0;
                //$alb = $row[$j][$i++];
                $titolo = $row[$j][$i++];
                $file = $row[$j][$i++];
                $testo = $row[$j][$i++];
                $autore = $row[$j][$i++];
                $extra = $row[$j][$i++];
                        
                addline('<tr><td>Track n°'.$extra.': '.$titolo.'</td>',$level);
                if($extra!=""){
                    addline('<tr><td>[Canzone fornita da: '.ucfirst($autore).']</td>',$level);
                }
                
                if ($file!=""){
                    addline('<tr><td><a target=download class=link href="'.$file.'">[ scarica ]</td>',$level);
                }
                printspacer(1);
                addline('<tr>',$level);
                addline('<td class= "left">'.richtext($testo),$level);    
                addline('</td>',--$level);
                printspacer(2);
                
                $j++;
            }
        }else{
            
            print_simpleMessage("disco");
            printspacer(1);
            //addline('<tr><td class=centered><img width=300 src="img/photo/Dagh maggio2001.jpg" /></td>',$level);

        }

    addline('</table></td>',++$level);
    addline('</table></td>',++$level);
addline('</table>',--$level);
?>