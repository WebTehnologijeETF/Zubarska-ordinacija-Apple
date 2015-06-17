<!DOCTYPE html>
<html>
<head>
	<title>Ordinacija</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body >
    <div class="header">
		<div class="login">
            
            <?php 
                if(isset($_REQUEST['logout']))
                {
                    unset($_SESSION['username']);
                    session_unset();
                }
                
            ?>
         
            <?php  if (!isset($_SESSION['username'])): ;?>
            
            <form action='adminpanel.php' method="POST">
            <label class="username">Username: </label>
            <input type="text" name="username" value="<?php if(isset($_REQUEST['username'])) echo htmlentities($_REQUEST['username']); else echo ""; ?>"><br/>
            <label>Password: </label>
            <input class="password" type="password" name="password" value="<?php if(isset($_REQUEST['password'])) echo htmlentities($_REQUEST['password']); else echo ""; ?>"> <br/>
                <input type="hidden" name="skrivenilog" value="da">
                <input class="send" type="submit" value="Loguj se" name="log">
            </form>
             <form action='index.php' method="POST">
            <input style="margin-top:-55px; margin-right:150px;" class="send" type="submit" name ="reset" value="Resetuj lozinku">
            </form>
            
            
            <?php else: echo 'Ulogovan kao:  '.$_SESSION['username'];?>
           
            <form action='index.php' method="POST">
                 <input class="send" type="submit" value="Izađi" name="logout">
            </form>
            <form style="margin-top:-55px; margin-right:150px;" action='adminpanel.php' method="POST">
                 <input class="send" type="submit" value="Adminpanel" name="adminpanel">
            </form>
            <?php endif; ?>
         
        </div>
		<div class="logopic"></div>
		<div class="logo"></div>
		<ul class="meni">
            <li class="li-1" onmouseover="novosti(true,1)" onmouseout="novosti(false,1)">
			     <a href="" onclick="otvoriajax('pocetna'); return false;">Početna</a>
                <ul id="usluge-meni1" class="usluge-zatvoreno1">
                    <li class="li-2-a"><a href="" onclick="pomjeriscroll('table1','pocetna'); return false;">Zašto baš mi?</a></li>
                    <li class="li-2-b"><a href="" onclick="pomjeriscroll('table2','pocetna'); return false;">Naši partneri</a></li>
                    <li class="li-2-c"><a href="" onclick="pomjeriscroll('table3','pocetna'); return false;">Pacijenti o nama</a></li>
                    <li class="li-2-d"><a href="" onclick="pomjeriscroll('table4','pocetna'); return false;">Naši doktori</a></li>
                </ul>
            </li>
            
			<li class="li-1"><a href="" onclick="ajaxgetvijesti('ispisivijesti'); return false;">Novosti</a></li>
			<li class="li-1"><a href="" onclick="otvoriajax('o_nama'); return false;">O nama</a></li>
        
			<li class="li-1" onmouseover="novosti(true,2)" onmouseout="novosti(false,2)">
                <a href="" onclick="otvoriajax('usluge'); return false;">Usluge</a>
                <ul id="usluge-meni2" class="usluge-zatvoreno2">
                    <li class="li-2-e"><a href="" onclick="pomjeriscroll('tabela1','usluge'); return false;">Implatati</a></li>
                    <li class="li-2-f"><a href="" onclick="pomjeriscroll('tabela2','usluge'); return false;">Izbjeljivanje zubi</a></li>
                    <li class="li-2-g"><a href="" onclick="pomjeriscroll('tabela3','usluge'); return false;">Ispuni i liječenja</a></li>
                    <li class="li-2-h"><a href="" onclick="pomjeriscroll('tabela4','usluge'); return false;">Navlake i mostovi</a></li>
                </ul>
            </li>
			<li class="li-1"><a href="" onclick="otvoriajax('kontakt'); return false;">Kontakt</a></li>
			<li class="li-1"><a href="" onclick="otvoriajax('lokacija'); return false;">Lokacija</a></li>
		</ul>
		<div class="headerpic"></div>
	</div>
    
    <div class='content'> 
  <div class="content-naslov">
                Kontakt
         </div>
        <br>
    
    <?php include("phpval/kontaktvalidacija.php"); ?>
    
    <!-- Sve je ispravno -->
    <?php if(isset($_POST['ime']) && isset($_POST['email']) && isset($_POST['telefon']) && isset($_POST['message']) && validacijaIme($_POST['ime']) && validacijaEmail($_POST['email']) && validacijaTelefon($_POST['telefon']) && validacijaPoruka($_POST['message'])) : ?>
      <?php 
        echo "<div class='poslano'>Provjerite da li ste ispravno popunili kontakt formu!<br/><br/>";
        echo "Uneseni podaci: <br/>";
        echo '<table class=\'poslanotabela\'><tr><td>Ime: </td><td class="desno">'.$_POST['ime'].'</td>';
        echo '<tr><td>Email: </td><td class="desno">'.$_POST['email'].'</td>';
        echo '<tr><td>Telefon: </td><td class="desno">'.$_POST['telefon'].'</td>';
        echo '<tr><td>Poruka: </td><td class="desno">'.$_POST['message'].'</td>';
    ?>
        <?php echo "<tr><td>";?>
            <input class="send" type="submit" value="Pošalji poruku" onclick="ajaxpostporuke('<?php echo $_POST['ime']?>','<?php echo $_POST['email']?>','<?php echo $_POST['telefon']?>','<?php echo $_POST['message']?>',0)" >
        <?php echo "</td></tr></table>";?>
    
        <?php else: ?>
		<form class="kontakt-forma" action='ispravankontakt.php' method="POST" onSubmit="return validate();">
            
            <!-- Ime i prezime -->
			<label class="zvjezdica">*&nbsp;</label><label>Ime i prezime:&nbsp;</label><div class="prikazime"></div>
            
			<input class="name" type="text" name="ime" value="<?php if(isset($_POST['ime'])) echo $_POST['ime']; else echo ""; ?>"><br><br>
                <div class="greskaime"><?php if(isset($_POST['ime'])) { if(validacijaIme($_POST['ime'])) { echo ""; } else { echo "greska";} }  ?> </div>
            <br>
            
            <!-- Email -->
			<label class="zvjezdica">*&nbsp;</label><label>Email:&nbsp;</label><div class="prikazemail"></div>
			<input class="email" type="text"  name="email" value="<?php if(isset($_REQUEST['email'])) echo $_REQUEST['email']; else echo ""; ?>"><br><br>
            <div class="greskaemail"><?php if(isset($_POST['email'])) { if(validacijaEmail($_POST['email'])) { echo ""; } else { echo "greska";} }  ?></div>	
            <br>
            
            <!-- Telefon -->
            <label class="zvjezdica">*&nbsp;</label><label>Telefon:&nbsp;</label><div class="prikaztelefon"></div>
            <input class="telefon" type="text" name="telefon" value="<?php if(isset($_REQUEST['telefon'])) echo $_REQUEST['telefon']; else echo ""; ?>"><br><br>
            <div class="greskatelefon"><?php if(isset($_POST['telefon'])) { if(validacijaTelefon($_POST['telefon'])) { echo ""; } else { echo "greska";} }  ?></div>
            <br>
            
            <!-- Poruka -->
			<label class="zvjezdica">*&nbsp;</label><label>Poruka:&nbsp;</label><div class="prikazporuka"></div>
            <textarea class="message"  name="message"> <?php if(isset($_REQUEST['message'])) echo $_REQUEST['message']; else echo ""; ?> </textarea><br>
            <div class="greskaporuka"><?php if(isset($_POST['message'])) { if(validacijaPoruka($_POST['message'])) { echo ""; } else { echo "greska";} } ?></div>
            <br>
            <br>
            
			<input class="send" type="submit" value="Pošalji">
             <div><label class="zvjezdica">*&nbsp;</label> ~ Obavezno polje za popunjavanje.</div>
		</form>
         <?php endif; ?>
    </div>
     <script src="js/opadajucimeni.js"></script>
    <script src="js/pomjeriscroll.js"></script>
    <script src="js/otvoristranicuajax.js"></script>
    <script src="js/kontaktvalidacija.js"></script>
    <script src="js/ajax_komentar.js"></script>
    <script src="js/ajax_korisnik.js"></script>
    <script src="js/ajax_vijesti.js"></script>
    <script src="js/ajax_poruke.js"></script>
    <script src="js/kontakt.js"></script>
</body>
</html>