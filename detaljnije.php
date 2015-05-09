  <?php

        $autor = $_GET['autor'];
        $detaljnije = $_GET['det'];
        $datum = $_GET['datum'];
        $slika = $_GET['slika'];
        $naslov = $_GET['naslov'];
        $tekst = $_GET['tekst'];

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
                '<div class="picture1"></div>'.
                "$tekst".'</div>'.'<div class="tekst">'.$detaljnije.'</div>'.
            '<div class="border-bottom"></div>'.
       '</div>';
    ?>
    