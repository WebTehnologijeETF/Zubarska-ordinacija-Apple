<!DOCTYPE html>
<html>
<?php 
session_start();
ini_set('display_errors','On'); ini_set('error_reporting','E_ALL | E_STRICT'); error_reporting(E_ALL);
?>
<head>
	<title>Ordinacija</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="js/opadajucimeni.js"></script>
    <script src="js/pomjeriscroll.js"></script>
    <script src="js/otvoristranicuajax.js"></script>
    <script src="js/kontaktvalidacija.js"></script>
</head>

<body >
	<div class="header">
		<div class="login">
            
            <?php 
                if(isset($_POST['logout']))
                {
                    unset($_SESSION['username']);
                    unset($_SESSION['admin']);
                    session_unset();
                }
            ?>
            
                <?php 
        if(isset($_POST['username']) && isset($_POST['password'])) :   
            $username = htmlentities($_POST['username'], ENT_QUOTES);
            $password = htmlentities($_POST['password'], ENT_QUOTES);

            include('phpval/login.php'); 

        elseif( (!isset($_POST['username'])|| !isset($_POST['password']) ) && (isset($_POST['reset']) || isset($_POST['log']) ) ):
            echo '<div class="logporuka">*Unesite username i lozinku</div>';  
           
            endif; 
            ?>
            
            <?php  if (!isset($_SESSION['username'])):?>
            
            <form action='adminpanel.php' method="POST">
            <label class="username">Username: </label>
            <input type="text" name="username" value="<?php if(isset($_POST['username'])) echo htmlentities($_POST['username'], ENT_QUOTES); else echo ""; ?>"><br/>
            <label>Password: </label>
            <input class="password" type="password" name="password" value="<?php if(isset($_POST['password'])) echo htmlentities($_POST['password'], ENT_QUOTES); else echo ""; ?>"> <br/>
                <input type="hidden" name="skrivenilog" value="da">
            <input class="send" type="submit" name ="reset" value="Resetuj lozinku"> <input class="send" type="submit" value="Loguj se" name="log">
            </form>
            <?php else:?>
           <table>
               <tr>
                <?php  echo 'Prijavljeni ste kao:  '.$_SESSION['username']; ?></tr>
                <tr><td><form action='adminpanel.php' method="POST">
                     <input class="send" type="submit" value="Dodaj korisnika" name="dodajkorisnika">
                </form></td>
                <td><form action='index.php' method="POST"> 
                    <input class="send" type="submit" value="Log out" name="logout">
                     <input class="send" type="submit" value="Nazad na stranicu" name="nazad">
                    </form></td></tr>
            </table>
            
            <?php endif; ?>
         
        </div>
		<div class="logopic"></div>
		<div class="logo"></div>
		
		<div class="headerpic"></div>
	</div>
   
    <!-- Ako smo ulogovani -->
    <?php if(isset($_SESSION['username']) && isset($_SESSION['admin']) && $_SESSION['admin'] == 'true'): ?>
    
    <?php
        header('Content-Type: text/html; charset=utf-8');
       // $veza = new PDO("mysql:dbname=appleordinacija;host=localhost;charset=utf8", "apple", "apple");
$veza= new PDO("mysql:dbname=appleordinacija;host=127.0.0.1;charset=utf8", "adminSFSF3dw", "st6BsffknmC7");
            
        $veza->exec("set names utf8");
    ?>
    
    <div class="panel">
        <div class="content-naslov">
            Admin panel
        </div>
        
    <?php 
        // DODAJ KORISNIKA U BAZU
          if(isset($_POST['dodajkorisnikaubazu']) && isset($_POST['dodajkorisnikaubazuhidden']) && isset($_POST['korisnickoime']) && isset($_POST['lozinka']) && isset($_POST['emailkorisnik'])): 
            
            //$conn = new PDO("mysql:dbname=appleordinacija;host=localhost;charset=utf8", "apple", "apple");

            $conn = new PDO("mysql:dbname=appleordinacija;host=127.0.0.1;charset=utf8", "adminSFSF3dw", "st6BsffknmC7");
            $insertujkorisnika= $conn->prepare('INSERT INTO korisnik (username, password, email, administrator) VALUES(?, ?, ?, ?)');
            if (!$insertujkorisnika) 
             {
                  $greska = $conn->errorInfo();
                  print "SQL greška: " . $greska[2];
                  exit();
             }
         
            $korisnikusername = htmlentities($_POST['korisnickoime'], ENT_QUOTES);
            $korisnikpassword = htmlentities($_POST['lozinka'], ENT_QUOTES);
            $korisnikemail =htmlentities($_POST['emailkorisnik'],ENT_QUOTES);
            if(!isset($_POST['administratorcheck']))
                $korisnikadministrator= htmlentities('0',ENT_QUOTES);
            else
                $korisnikadministrator= htmlentities('1',ENT_QUOTES);
        

            $insertujkorisnika->bindParam(1,$korisnikusername);
            $insertujkorisnika->bindParam(2,$korisnikpassword);
            $insertujkorisnika->bindParam(3,$korisnikemail);
            $insertujkorisnika->bindParam(4,$korisnikadministrator);
            $insertujkorisnika->execute();
          endif;
    ?>
        <!-- FORMA ZA DODAVANJE KORISNIKA-->
    <?php if(isset($_POST['dodajkorisnika']) || ( isset($_POST['dodajkorisnikaubazu']) && isset($_POST['dodajkorisnikaubazuhidden']) && isset($_POST['korisnickoime']) && isset($_POST['lozinka']) && isset($_POST['emailkorisnik']) ) || ( isset($_POST['editujkorisnika']) && isset($_POST['editujkorisnika2']) || isset($_POST['obrisikorisnika']) && isset($_POST['obrisikorisnika2'] )) || (isset($_POST['spasipromjene']) && isset($_POST['spasipromjene2'])) ): ?>
            <form action="adminpanel.php" method="POST">
                <tr><td colspan="5">Forma za dodavanje korisnika</td></tr>
                <table>
                    <tr>
                        <td><label>Korisničko ime </label></td>
                        <td><label>Lozinka </label></td>
                        <td><label>Email </label></td>
                        <td><label>Administrator</label></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="korisnickoime"></td>
                        <td><input type="text" name="lozinka"></td>
                        <td><input type="text" name="emailkorisnik"></td>
                        <td><input type="checkbox" name="administratorcheck" value="Ima pristup administratorskom panelu"></td>
                        <td><input name="dodajkorisnikaubazu" type="submit" value="Dodaj novog korisnika"></td>
                        <input type="hidden" name="dodajkorisnikaubazuhidden">
                    </tr>   
             </table>
            </form>
        
        <?php 
            // BRISANJE i EDITOVANJE KORISNIKA
           if(isset($_POST['obrisikorisnika']) && isset($_POST['obrisikorisnika2']))
               {
                   //BRISANJE KORISNIKA
                    //$conn = new PDO("mysql:dbname=appleordinacija;host=localhost;charset=utf8", "apple", "apple");
               $conn = new PDO("mysql:dbname=appleordinacija;host=127.0.0.1;charset=utf8", "adminSFSF3dw", "st6BsffknmC7");
            
                    $izbrisikorisnika = $conn->prepare('DELETE from korisnik WHERE id=?');

                    $idkorisnika = htmlentities($_POST['obrisikorisnika2'], ENT_QUOTES);
                    $izbrisikorisnika->execute(array($idkorisnika));
               }
            else if(isset($_POST['spasipromjene']) && isset($_POST['spasipromjene2']))
            {
                   $user = htmlentities($_POST['korisnickoime'],ENT_QUOTES);
                   $pass = htmlentities($_POST['lozinka'],ENT_QUOTES);
                   $email = htmlentities($_POST['mail'],ENT_QUOTES);
                    if(!isset($_POST['admin']))
                        $admin= htmlentities('0',ENT_QUOTES);
                    else
                        $admin= htmlentities('1',ENT_QUOTES);
                   $id = htmlentities($_POST['spasipromjene2'],ENT_QUOTES);
                  
                   //$conn = new PDO("mysql:dbname=appleordinacija;host=localhost;charset=utf8", "apple", "apple");
                $conn = new PDO("mysql:dbname=appleordinacija;host=127.0.0.1;charset=utf8", "adminSFSF3dw", "st6BsffknmC7");
            
                   $spasipromjenekorisnika = $conn->prepare('UPDATE korisnik SET username=?, password=?, email=?, administrator=? WHERE id=?');
                     if (!$spasipromjenekorisnika) 
                     {
                          $greska = $conn->errorInfo();
                          print "SQL greška: " . $greska[2];
                          exit();
                     }
                
                  $spasipromjenekorisnika->execute(array($user,$pass,$email,$admin,$id));  
            }
        ?>
        
        <?php 
            // CITANJE KORISNIKA IZ BAZE
           // $conn = new PDO("mysql:dbname=appleordinacija;host=localhost;charset=utf8", "apple", "apple");
$conn = new PDO("mysql:dbname=appleordinacija;host=127.0.0.1;charset=utf8", "adminSFSF3dw", "st6BsffknmC7");
            
            $ispisikorisnika = $conn->query("SELECT id, username, password, email, administrator FROM korisnik ORDER BY id");

            if (!$ispisikorisnika) 
             {
                  $greska = $conn->errorInfo();
                  print "SQL greška: " . $greska[2];
                  exit();
             }
        $korisnici = $ispisikorisnika->fetchAll();
        ?>
                <table>
                    <tr>
                        <td>Korisničko ime</td>
                        <td>Lozinka</td>
                        <td>Email </td>
                        <td>Administrator</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
        <?php foreach($korisnici as $korisnik):?>
                    <?php if($korisnik['id'] != -1): ?>
                    <tr><form action="adminpanel.php" method="GET">
                        <td><input name="korisnickoime" type="text" value='<?php echo $korisnik['username'];?>' <?php  if(!(isset($_POST['editujkorisnika']) && isset($_POST['editujkorisnika2']) && $_POST['editujkorisnika2'] == $korisnik['id'] )):?> disabled<?php endif; ?>></td>
                        <td><input name="lozinka" type="text" value='<?php echo $korisnik['password'];?>'  <?php  if(!(isset($_POST['editujkorisnika']) && isset($_POST['editujkorisnika2']) && $_POST['editujkorisnika2'] == $korisnik['id'] )):?> disabled<?php endif; ?>></td>
                        <td><input name="mail" type="text" value='<?php echo $korisnik['email'];?>'  <?php  if(!(isset($_POST['editujkorisnika']) && isset($_POST['editujkorisnika2']) && $_POST['editujkorisnika2'] == $korisnik['id'] )):?> disabled<?php endif; ?>></td>
                        <td><input name="admin" type="checkbox" <?php if($korisnik['administrator']==1) echo "checked";?>  <?php  if(!(isset($_POST['editujkorisnika']) && isset($_POST['editujkorisnika2']) && $_POST['editujkorisnika2'] == $korisnik['id'] )):?> disabled<?php endif; ?>></td>
                        <td><input type="submit" value="Spasi promjene" name="spasipromjene" <?php  if(!(isset($_POST['editujkorisnika']) && isset($_POST['editujkorisnika2']) && $_POST['editujkorisnika2'] == $korisnik['id'] )):?> disabled<?php endif; ?>>
                            <input type="hidden" name="spasipromjene2" value="<?php echo $korisnik['id']?>">
                        </td></form>
                        <td>
                            <form action="adminpanel.php" method="POST">
                                <input type="submit" value="Edituj korisnika" name="editujkorisnika">
                                <input type="hidden" name="editujkorisnika2" value="<?php echo $korisnik['id']?>">
                            </form>
                        </td>
                        <td><form  action="adminpanel.php" method="POST"><input type="submit" value="Obriši korisnika" name="obrisikorisnika"><input type="hidden" name="obrisikorisnika2" value="<?php echo $korisnik['id']?>"></form></td>
                    </tr>
                    
        <?php endif; endforeach; ?>
                </table>
    <?php else: ?>
        
        
    <?php 
    // DODAVANJE KOMENTARA U BAZU
     if(isset($_POST['posaljikomentar']) && isset($_POST['komentar']) && strlen(preg_replace('/\s+/','',$_POST['komentar'])) > 0)
           {
            //$conn = new PDO("mysql:dbname=appleordinacija;host=localhost;charset=utf8", "apple", "apple");
         $conn = new PDO("mysql:dbname=appleordinacija;host=127.0.0.1;charset=utf8", "adminSFSF3dw", "st6BsffknmC7");
            
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
           // $conn = new PDO("mysql:dbname=appleordinacija;host=localhost;charset=utf8", "apple", "apple");
            $conn = new PDO("mysql:dbname=appleordinacija;host=127.0.0.1;charset=utf8", "adminSFSF3dw", "flocal");
            
            $izbrisikomentar = $conn->prepare('DELETE from komentar WHERE id=?');
            
            $idkomentara = htmlentities($_POST['idkomentara'], ENT_QUOTES);
            $izbrisikomentar->execute(array($idkomentara));
        }
        ?>
        
        
        
    <?php 
        // ISPIS VIJESTI
        $vijesti= $veza->query("select id, naslov, tekst, UNIX_TIMESTAMP(datum) datumvijesti, autor, detaljnije,slika from vijest order by datum desc");

        $vijesti = $vijesti->fetchAll();
         if (!$vijesti) 
         {
              $greska = $veza->errorInfo();
              print "SQL greška: " . $greska[2];
              exit();
         }


        function my_sort($a,$b)
        {
            if ($a==$b) return 0;
                return ($a<$b)?-1:1;
        }

        usort($vijesti,"my_sort");


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
                "$tekst";
if(isset($detaljnije))
{
    echo '<input class="detaljnije" value="Detaljnije" onclick="novostiajax('.$datum.','.$autor.','.$naslov.','.$slika.','.$tekst.','.$detaljnije.'); return false;" type="button">';
}
            //BROJ KOMENTARA NEKE VIJESTI
            $broj = $veza->query('select count(*) broj from komentar where vijest='.$vijestiId);

            $brojKomentara = $broj->fetch();
?>
        <form action="adminpanel.php" method="POST">
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

            <form class="formaadmin" action="adminpanel.php" method="POST">
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
                    <tr><td colspan="2" >
                        <form action="adminpanel.php" method="POST">
                           <input type="submit" value="Obrisi" name="obrisi">
                           <input type="hidden" name="idkomentara" value='<?php echo $komentarId;?>'>
                           <input type="hidden" name="idvijesti" value='<?php if(isset($_POST['vijesti'])) echo htmlentities($_POST['vijesti'], ENT_QUOTES); else if(isset($_POST['vijestik'])) echo htmlentities($_POST['vijestik'], ENT_QUOTES); else echo htmlentities($_POST['idvijesti'], ENT_QUOTES); ?>' >
                        </form>
                   </td></tr>
                </table><br><br>
        <?php
        endforeach;
        endif;
    endforeach;
endif; // Kraj za provjeru da li je dodavanjeKorisnika
        ?>
    </div>
    
     <?php else: ?>
    
	<div class="content">
       Nemate privilegije za pristup Adminpanelu! 
	</div>
   <?php endif; ?>
	<div class="footer"></div>
</body>
</html>