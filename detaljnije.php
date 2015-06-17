<!DOCTYPE html>
<html>

<header>
</header>
<body>

    <?php
        $autor = $_GET['autor'];
        $detaljnije = $_GET['det'];
        $datum = $_GET['datum'];
        $slika = $_GET['slika'];
        $naslov = $_GET['naslov'];
        $tekst = $_GET['tekst'];

        
        $slika = str_replace("'", "", $slika);
        $slika = str_replace("<br/>", "", $slika);
        $autor = str_replace("'", "", $autor);
        $datum = str_replace("'", "", $datum);
        $naslov = str_replace("'", "", $naslov);
        $detaljnije = str_replace("'", "", $detaljnije);
        $tekst = str_replace("'", "", $tekst);

        echo '<div class="content-naslov">Novosti</div>';
    
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
                "<div class='pic'><img height='300' width='600' src='$slika'></img></div>"?>
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
            <?php echo $tekst.'</div>'.'<div class="tekst">'.$detaljnije.'</div>'.
            '<div class="border-bottom"></div>'.
       '</div>';
    ?> 
    
</body>
</html>
    