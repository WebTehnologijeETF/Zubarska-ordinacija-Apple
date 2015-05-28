<!DOCTYPE html>
<html>
<header>
    
</header>
    
<body>
    
    <?php 
        header('Content-Type: text/html; charset=utf-8');
        echo '<div class="content-naslov">Novosti</div>';
?>
    
     <?php 
    // DODAVANJE KOMENTARA U BAZU
     if(isset($_POST['posaljikomentar']) && isset($_POST['komentar']) && strlen(preg_replace('/\s+/','',$_POST['komentar'])) > 0)
           {
            $conn = new PDO("mysql:dbname=appleordinacija;host=localhost;charset=utf8", "apple", "apple");
            $insertujkomentar= $conn->prepare('INSERT INTO komentar (vijest, autor, tekst, email) VALUES(?, ?, ?, ?)');
            if (!$insertujkomentar) 
             {
                  $greska = $conn->errorInfo();
                  print "SQL greška: " . $greska[2];
                  exit();
             }
         
            $vijestikomentar = htmlentities($_POST['vijestik'], ENT_QUOTES);
            $komentarkorisnika = htmlentities($_POST['komentar'], ENT_QUOTES);
            $korisnik="Gost";
            $email = htmlentities('',ENT_QUOTES);
            if(isset($_POST['email']) || empty($_POST['ime']))
                $email = htmlentities($_POST['email'], ENT_QUOTES);
            
         
            if($_POST['ime']!=null)
                $korisnik = htmlentities($_POST['ime'], ENT_QUOTES);
        
            $insertujkomentar->bindParam(1,$vijestikomentar);
            $insertujkomentar->bindParam(2,$korisnik);
           // $danas = date('d.m.Y. (h:i)', mktime(date("H"),date("i"),date("s"), date("m"), date("d"), date("Y")));
           // $veza2->bindParam(3,$danas);
            $insertujkomentar->bindParam(3,$komentarkorisnika);
            $insertujkomentar->bindParam(4,$email);
            $insertujkomentar->execute();
           }

        else if(isset($_POST['obrisi'])) // BRISANJE KOMENTARA IZ BAZE
        {
            $conn = new PDO("mysql:dbname=appleordinacija;host=localhost;charset=utf8", "apple", "apple");
            $izbrisikomentar = $conn->prepare('DELETE from komentar WHERE id=?');
            
            $idkomentara = htmlentities($_POST['idkomentara'], ENT_QUOTES);
            $izbrisikomentar->execute(array($idkomentara));
        }
        ?>
        
        
        
    <?php 
        // ISPIS VIJESTI
$veza = new PDO("mysql:dbname=appleordinacija;host=localhost;charset=utf8", "apple", "apple");
        $veza = new PDO("mysql:dbname=appleordinacija;host=localhost;charset=utf8", "apple", "apple");
            
        $vijesti= $veza->query("select id, naslov, tekst, UNIX_TIMESTAMP(datum) datumvijesti, autor, detaljnije,slika from vijest order by datum desc");

        $vijesti = $vijesti->fetchAll();
         if (!$vijesti) 
         {
              $greska = $veza->errorInfo();
              print "SQL greška: " . $greska[2];
              exit();
         }


        function my_sort2($a,$b)
        {
            if ($a==$b) return 0;
                return ($a<$b)?-1:1;
        }

        usort($vijesti,"my_sort2");


        foreach ($vijesti as $vijest): 
    
        $naslov = $vijest['naslov'];
        $tekst = $vijest['tekst'];
        $detaljnije = $vijest['detaljnije'];
        $autor = $vijest['autor'];
        $datum = date('d.m.Y   H:i', $vijest['datumvijesti']);
        $slika = $vijest['slika'];
        $vijestiId = $vijest['id'];
        
            // ISPRAVITI U PREPARE!!!!
          $komentari = $veza->query('select id, vijest, autor, UNIX_TIMESTAMP(datum) datumkomentara, tekst, email from komentar where vijest='.$vijestiId.' order by datumkomentara desc');
        
        // ISPIS NOVOSTI
             echo '<div class="novost">'.
            '<div class="naslov">'.
                 '<div>'.
                     '<div class="datum">'.
                         '<div class="date-icon">▦</div>'.$datum.
                      '</div>'.              
            ' <div class="autor">'.$autor.'</div>'.
                  '</div>'.
                $naslov.
            '</div>'.
            '<div class="tekst">'.
               // "<div class='pic'><img height='300' width='600' src='$slika'></img></div>".
                "$tekst".
                 '<input class="detaljnije" value="Detaljnije" onclick="novostiajax('.$datum.','.$autor.','.$naslov.','.$slika.','.$tekst.','.$detaljnije.'); return false;" type="button"><br><br><br>';
   
            //BROJ KOMENTARA NEKE VIJESTI
            $broj = $veza->query('select count(*) broj from komentar where vijest='.$vijestiId);

            $brojKomentara = $broj->fetch();
?>
    
        <form action="novosti.php" method="POST">
             <input name="prikazikomentar" type="submit" value=' Broj komentara: <?php echo $brojKomentara["broj"]; ?>'>
             <input name="vijesti" type="hidden" value='<?php echo htmlentities($vijest['id'], ENT_QUOTES);?>'>
        </form>

        <?php
                echo '</div><br/>';


            // Kada kliknemo na broj komentara
        if((isset($_POST['vijesti']) && htmlentities($_POST['vijesti'], ENT_QUOTES) == $vijestiId) || ((isset($_POST['vijestik']) && htmlentities($_POST['vijestik'], ENT_QUOTES) == $vijestiId)) || ((isset($_POST['idvijesti']) && htmlentities($_POST['idvijesti'], ENT_QUOTES) == $vijestiId)) || ( isset($_POST['obrisi']) && (isset($_POST['vijesti']) && htmlentities($_POST['vijesti'], ENT_QUOTES) == $vijestiId) || ((isset($_POST['vijestik']) && htmlentities($_POST['vijestik'], ENT_QUOTES) == $vijestiId)) || ((isset($_POST['idvijesti']) && htmlentities($_POST['idvijesti'], ENT_QUOTES) == $vijestiId)) ) ):
            // TO DO : validacija imena, komentara na serverskoj strani! 
            // VELICINA NEKA ZAVISI OD VELICINE VARCHARA-a u phpmyadmin
?>

            <form class="formaadmin" action="novosti.php" method="POST">
                    <div class="naslovforme">Postavite komentar na vijest:</div><br>
                    <label>Ime</label><br>
                    <input name="ime" class="ime" value='<?php if(isset($_POST['ime'])) echo htmlentities($_POST['ime'],ENT_QUOTES);?>'><br>
                    <label>Email</label><br>
                    <input name="email" class="email" value='<?php if(isset($_POST['email'])) echo htmlentities($_POST['email'],ENT_QUOTES); ?>'><br>
                    <label>Komentar</label><br>
                    <textarea name="komentar" class="komentar" value='<?php if(isset($_POST['komentar'])) echo htmlentities($_POST['komentar'],ENT_QUOTES); ?>'></textarea><br>
                    <input type="submit" name="posaljikomentar" class="posalji" value="Postavi komentar"><br>
                <?php 
                    //Validacija forme za unos komentara
                    if(isset($_POST['posaljikomentar']) && (!isset($_POST['komentar']) || strlen(preg_replace('/\s+/','',$_POST['komentar'])) == 0))
                    {
                        echo '<div>Unos komentara je obavezan.</div>';
                    }

                ?>
                    <input name="vijestik" type="hidden" value='<?php if(isset($_POST['vijesti'])) {echo htmlentities($_POST['vijesti'], ENT_QUOTES);} else if(isset($_POST['idvijesti'])) echo htmlentities($_POST['idvijesti'], ENT_QUOTES); else {echo htmlentities($_POST['vijestik'], ENT_QUOTES);} ?>'><br>
                </form><br><br><br>

       <?php     
        // Ispis svih komentara neke vijesti
        foreach ($komentari as $komentar):
            $komentarId = $komentar['id'];
            $komentarVijest = $komentar['vijest'];
            $komentarAutor = $komentar['autor'];
            $komentarDatum = date('d.m.Y. (h:i)',$komentar['datumkomentara']);
            $komentarText = $komentar['tekst'];
            $komentarEmail = $komentar['email']; 
         ?>
            
                <table class="tabelaadmin">
                    <tr><td class="lijevo"><?php echo $komentarDatum;?> </td><td rowspan="2" class="desno">
                        <?php  if(!empty($komentarEmail)):?> <a href="<?php echo 'mailto:'.$komentarEmail; ?>" target="_top" > <?php echo $komentarAutor;?></a> <?php  else: echo $komentarAutor; endif;?> </td></tr>
                    <tr><td class="centaremail">Email: <?php echo $komentarEmail;?> </td></tr>
                    <tr><td colspan="2" class="centarlabela">Komentar:</td></tr>
                    <tr><td colspan="2" class="centar"> <?php echo $komentarText;?> </td></tr>
                    <tr></tr>
                </table><br><br>
        <?php
        endforeach;
        endif;
    endforeach;
        ?>

    <?php

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