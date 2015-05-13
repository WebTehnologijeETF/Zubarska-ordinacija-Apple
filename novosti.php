<?php
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
           if($datoteka[$index] == "--\r\n") 
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
        
        $detaljnije = "'" .str_replace( "\r\n", '<br />', $detaljnije )."'";
        $datum = "'" .str_replace( "\r\n", '<br />', $datum )."'";
        $naslov ="'" . str_replace( "\r\n", '<br />', $naslov )."'";
        $slika = "'" .str_replace( "\r\n", '<br />', $slika )."'";
        $tekst = "'" .str_replace( "\r\n", '<br />', $tekst )."'";
        $autor = "'" .str_replace( "\r\n", '<br />', $autor )."'";
        
        
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
                "$tekst"; ?>
         <?php if($otvoriDalje): ?>

         <?php echo '<input class="detaljnije" value="Detaljnije" onclick="novostiajax('.$datum.','.$autor.','.$naslov.','.$slika.','.$tekst.','.$detaljnije.'); return false;" type="button">'; ?> 

        <?php endif;?>
           <?php echo '</div>'.
            '<div class="border-bottom"></div>'.
       '</div><br><br><br><br>';


    }
    ?>
    
     <!--   <br><br><br><br>
		<div class="novost">
            <div class="naslov">
                  <div>
                      <div class="datum">
                          <div class="date-icon">▦</div>
                          28.03.2015
                      </div>                                   <div class="autor">Dr. Apple</div>
                  </div>
                Započeli smo koristiti Piezo tehnologiju
            </div>
            <div class="tekst">
                <div class="picture1"></div>
                Započeli smo u kirurgiji koristiti piezo tehnologiju.  PIEZOSURGERY® tehnika pomoću specijalnih ultrazvučnih vibracija omogućava vrlo precizan rad u kirurgiji te smanjuje potoperativne neugodnosti kod pacijenta.
            <div class="detaljnije"><a>Detaljnije</a></div>
            </div>
            <div class="border-bottom"></div>
        </div>
        
        <br><br><br><br><br>
		<div class="novost">
            <div class="naslov">                 
                  <div>
                      <div class="datum">
                          <div class="date-icon">▦</div>
                          26.03.2015
                      </div>                                   
                      <div class="autor">Dr. Apple</div>
                  </div>
                TruKlear - samoligirajuće keramičke bravice
            </div>
            <div class="tekst">
                <div class="picture2"></div>
Od januara 2015. godine radimo s potpuno keramičkim samoligirajućim bravicama – TruKlear koje su u kombinaciji s bijelim žicama potpuno nevidljive.

TruKlear su prve samoligirajuće bravice napravljene u potpunosti bez metala. Takve bravice su vrlo diskretne, brzo se skidaju i mogu ih nositi sve dobne skupine.
            <div class="detaljnije"><a>Detaljnije</a></div>
            </div>
            <div class="border-bottom"></div>
        </div>
        <br><br><br><br><br>
        
		<div class="novost">
            <div class="naslov">
                  <div>
                      <div class="datum">
                          <div class="date-icon">▦</div>
                          24.03.2015
                      </div>                                   <div class="autor">Dr. Apple</div>
                  </div>
                TruKlear - samoligirajuće keramičke bravice
            </div>
            <div class="tekst">
                <div class="picture3"></div>
Osim 2D ortodontske ligvalne tehnike koju sada radimo, od maja 2014. god. počet ćemo koristiti Incognito sustav lingvalne terapije kojim se mogu rješavati kompleksniji ortodontski slučajevi.

Također, incognito bravice su praktički 'nevidljive' jer se ugrađuju sa unutarnje strane zuba te zbog niskog profila ne smetaju govoru.
            <div class="detaljnije"><a>Detaljnije</a></div>
            </div>
            <div class="border-bottom"></div>
        </div>
        <br><br><br><br><br>
-->
