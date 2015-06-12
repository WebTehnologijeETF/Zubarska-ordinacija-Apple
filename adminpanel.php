<!DOCTYPE html>
<html>
<?php 
session_start();
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
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

<body  <?php if(isset($_POST['username']) && isset($_POST['password'])) :   
            $username = htmlentities($_POST['username'], ENT_QUOTES);
            $password = htmlentities($_POST['password'], ENT_QUOTES);

            include('phpval/login.php'); endif; ?> <?php if (isset($_SESSION['username']) && isset($_SESSION['admin']) && !isset($_REQUEST['dodajkorisnika'])): ?> onLoad = "ajaxgetvijesti('ispisivijesti')"<?php endif; ?>>
 
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
        

        if( (!isset($_POST['username'])|| !isset($_POST['password']) ) && (isset($_POST['reset']) || isset($_POST['log']) ) ):
            echo '<div class="logporuka">*Unesite username i lozinku</div>';  
           
            endif; 
            ?>
            
            <!-- Log in -->
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
                <tr><td>
                     <input class="send" type="submit" value="Dodaj korisnika" name="dodajkorisnika" onclick="ajaxgetkorisnik('ispisikorisnika')">
                </td>
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
    <?php 
if(isset($_SESSION['username']) && isset($_SESSION['admin']) && $_SESSION['admin'] == 'true'): ?>
    
    <?php
        header('Content-Type: text/html; charset=utf-8');
        $veza = new PDO("mysql:dbname=appleordinacija;host=localhost;charset=utf8", "apple", "apple");
        //$veza= new PDO("mysql:dbname=appleordinacija;host=127.2.117.130;charset=utf8", "adminSFSF3dw", "st6BsffknmC7");
            
        $veza->exec("set names utf8");
    ?>
    
    <div class="panel">
        <div class="content-naslov">
            Admin panel
        </div>
        
    <?php 
        // DODAJ KORISNIKA U BAZU
          /*if(isset($_POST['dodajkorisnikaubazu']) && isset($_POST['dodajkorisnikaubazuhidden']) && isset($_POST['korisnickoime']) && isset($_POST['lozinka']) && isset($_POST['emailkorisnik'])): 
            
            $conn = new PDO("mysql:dbname=appleordinacija;host=localhost;charset=utf8", "apple", "apple");

            //$conn = new PDO("mysql:dbname=appleordinacija;host=127.2.117.130;charset=utf8", "adminSFSF3dw", "st6BsffknmC7");
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
                echo $id;
                
            }
        ?>
        
        <?php 
            // CITANJE KORISNIKA IZ BAZE
             ?>
    <?php else: ?>
        
        
    <?php 
    // DODAVANJE KOMENTARA U BAZU
     if(isset($_POST['posaljikomentar']) && isset($_POST['komentar']) && strlen(preg_replace('/\s+/','',$_POST['komentar'])) > 0)
           {
            $conn = new PDO("mysql:dbname=appleordinacija;host=localhost;charset=utf8", "apple", "apple");
         //$conn = new PDO("mysql:dbname=appleordinacija;host=127.2.117.130;charset=utf8", "adminSFSF3dw", "st6BsffknmC7");
            
           
           }

        else if(isset($_POST['obrisi'])) // BRISANJE KOMENTARA IZ BAZE
        {
         
        }
        ?>
        
        
         <!--ISPIS VIJESTI-->
      
<?php
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
       
   endforeach;
 // Kraj za provjeru da li je dodavanjeKorisnika
      endif;  ?*/?>
    </div>
    
	<div class="content">
     <?php else: ?>
    
       Nemate privilegije za pristup Adminpanelu! 
	
   <?php endif; ?>
        </div>
	<div class="footer"></div>
</body>
</html>