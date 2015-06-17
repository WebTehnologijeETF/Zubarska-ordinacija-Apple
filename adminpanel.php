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
    <script src="js/ajax_komentar.js"></script>
    <script src="js/ajax_korisnik.js"></script>
    <script src="js/ajax_vijesti.js"></script>
    <script src="js/ajax_poruke.js"></script>
    <script src="js/kontakt.js"></script>
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
            <input class="send" type="submit" value="Loguj se" name="log">
            </form>
            <?php else:?>
           <table class="meniadmin">
               <tr>
                <?php  echo 'Prijavljeni ste kao:  '.$_SESSION['username']; ?></tr>
                <tr>
                      <td><form action='index.php' method="POST"> 
                     <input class="send" type="submit" value="Nazad na početnu" name="nazad">
                    </form></td>
                <td>
                     <input class="send" type="submit" value="Poruke" name="dodajporuku" onclick="ajaxgetporuke()">
                </td>
                    <td>
                     <input class="send" type="submit" value="Korisnici" name="dodajkorisnika" onclick="ajaxgetkorisnik('ispisikorisnika')">
                </td>
                    <td>
                     <input class="send" type="submit" value="Novosti"  onclick="ajaxgetvijesti('ispisivijesti')">
                </td>
                <td><form action='index.php' method="POST"> 
                    <input class="send" type="submit" value="Izađi" name="logout">
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
     //   $veza= new PDO("mysql:dbname=appleordinacija;host=127.2.117.130;charset=utf8", "adminSFSF3dw", "st6BsffknmC7");
            
        $veza->exec("set names utf8");
    ?>
    
    <div class="panel">
        <div class="content-naslov">
            Admin panel
        </div>
    </div>
    
	<div class="content">
     <?php else: ?>
    
       Nemate privilegije za pristup Adminpanelu! 
	
   <?php endif; ?>
        </div>
	<div class="footer"></div>
</body>
</html>