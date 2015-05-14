<!DOCTYPE html>
<html>
<header>
    
</header>
    
<body>

    <?php
header('Content-Type: text/html; charset=utf-8');
echo '<div class="content-naslov">Novosti</div>';
$nizdatoteka= array();
foreach (new DirectoryIterator('./novosti') as $file) {
    if($file->isDot()) continue;
    array_push($nizdatoteka,$file->getFilename());
   // echo $file->getFilename() . '<br>';
}

    for ($i=0; $i<count($nizdatoteka)-1; $i++) 
    {
        $datoteka = file('./novosti/'.$nizdatoteka[$i]);
        $datum1 = $datoteka[0];
        $datoteka = file('./novosti/'.$nizdatoteka[$i+1]);
        $datum2 = $datoteka[0];
        if (new DateTime($datum1) < new DateTime($datum2))
        {
            $temp = $nizdatoteka[$i];
            $nizdatoteka[$i] = $nizdatoteka[$i+1];
            $nizdatoteka[$i+1] = $temp;
        }
    }
        
    for ($i=0; $i<count($nizdatoteka); $i++) 
    {
        $datoteka = file('./novosti/'.$nizdatoteka[$i]);
        $datum = $datoteka[0];
        $autor = $datoteka[1];
        $naslov = ucfirst(strtolower($datoteka[2]));
        $slika = $datoteka[3];
        $tekst = " ";
        $detaljnije = " ";
        $veldatoteke = sizeof($datoteka);
        $index  = 4;
        $otvoriDalje = false;
        
       while($index < $veldatoteke)
        {
           if($datoteka[$index] == "--" . PHP_EOL) 
           {
               $otvoriDalje = true;
               $index = $index + 1;
               break;
           }
            $tekst = $tekst . $datoteka[$index];
            $index = $index + 1;
        }
        
       while($otvoriDalje && $index < $veldatoteke)
        {
            $detaljnije = $detaljnije . $datoteka[$index];
            $index = $index + 1;
        }
        
        $detaljnije = str_replace( PHP_EOL, '<br/>', $detaljnije );
        $datum = str_replace( PHP_EOL, '<br/>', $datum );
        $naslov = str_replace( PHP_EOL, '<br/>', $naslov );
        $tekst = str_replace( PHP_EOL, '<br/>', $tekst );
        $autor = str_replace( PHP_EOL, '<br/>', $autor );

         echo '<div class="novost">'.
            '<div class="naslov">'.
                 '<div>'.
                     '<div class="datum">'.
                         '<div class="date-icon">▦</div>'.
                          "$datum".
                      '</div>'.              
            ' <div class="autor">'.$autor.'</div>'.
                  '</div>'.
                $naslov.
            '</div>'.
            '<div class="tekst">'.
                "<div class='pic'><img height='300' width='600' src='$slika'></img></div>".
                "$tekst"; ?>
    
          <style type="text/css">
            .pic
            {
                height:300px;
                width:600px;
                margin:0 auto;
                background-repeat:no-repeat;
                background-size: contain;
            }
        </style>
    <input type="hidden" name="stil" value='<?php echo $slika; ?>'>
                 <?php if($otvoriDalje): 
                    $detaljnije = "'" .str_replace( PHP_EOL, '<br/>', $detaljnije )."'";
                    $datum = "'" .str_replace( PHP_EOL, '<br/>', $datum )."'";
                    $naslov ="'" . str_replace( PHP_EOL, '<br/>', $naslov )."'";
                    $slika = "'" .str_replace( PHP_EOL, '<br/>', $slika )."'";
                    $tekst = "'" .str_replace( PHP_EOL, '<br/>', $tekst )."'";
                    $autor = "'" .str_replace( PHP_EOL, '<br/>', $autor )."'";

                ?>

         <?php echo '<input class="detaljnije" value="Detaljnije" onclick="novostiajax('.$datum.','.$autor.','.$naslov.','.$slika.','.$tekst.','.$detaljnije.'); return false;" type="button">'; 
   
    ?> 
 
        <?php endif;?>
           <?php echo '</div>'.
            '<div class="border-bottom"></div>'.
       '</div><br><br><br><br>';


    }
    ?>
    </body>
</html>
