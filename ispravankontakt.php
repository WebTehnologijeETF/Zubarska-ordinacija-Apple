<!DOCTYPE html>
<html>
<head>
	<title>Ordinacija</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="js/opadajucimeni.js"></script>
    <script src="js/pomjeriscroll.js"></script>
    <script src="js/otvoristranicuajax.js"></script>
    <script src="js/kontaktvalidacija.js"></script>
</head>
<body>
	<div class="header">
		<div class="number">+387 33 555 555</div>
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
            
			<li class="li-1"><a href="" onclick="otvoriajax('novosti'); return false;">Novosti</a></li>
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

	<div class="content">

  <div class="content-naslov">
                Kontakt
         </div>
        <br>
    
    <?php include("phpval/kontaktvalidacija.php"); ?>
    <?php $prikaziFormu = true; ?>
        
    <!-- Sve je ispravno -->
    <?php if( !isset($_POST['hidden']) && isset($_POST['ime']) && isset($_POST['email']) && isset($_POST['telefon']) && isset($_POST['message']) && validacijaIme($_POST['ime']) && validacijaEmail($_POST['email']) && validacijaTelefon($_POST['telefon']) && validacijaPoruka($_POST['message'])) : ?>
    
    <?php 
        echo "<div class='poslano'>Provjerite da li ste ispravno popunili kontakt formu!<br/><br/>";
        echo "Uneseni podaci: <br/>";
        echo '<table class=\'poslanotabela\'><tr><td>Ime: </td><td class="desno">'.$_POST['ime'].'</td>';
        echo '<tr><td>Email: </td><td class="desno">'.$_POST['email'].'</td>';
        echo '<tr><td>Telefon: </td><td class="desno">'.$_POST['telefon'].'</td>';
        echo '<tr><td>Poruka: </td><td class="desno">'.$_POST['message'].'</td>';
        echo '<tr><td>Godina: </td><td class="desno">'.$_POST['quantity'].'</td>';
        echo '<tr><td>Hitnost: </td><td class="desno">'.$_POST['points'].'</td></table></div>';
    ?>
        <form class="kontakt-forma" action='ispravankontakt.php' method="POST">
            <input class="send" type="submit" value="Siguran sam">
            <input type="hidden" value="Da" name="sakriven">
            <input type="hidden" value="<?php echo $_POST['ime']?>" name="ime2">
            <input type="hidden" value="<?php echo $_POST['email']?>" name="email2">
            <input type="hidden" value="<?php echo $_POST['telefon']?>" name="telefon2">
            <input type="hidden" value="<?php echo $_POST['message']?>" name="porukasubmit2">
            <input type="hidden" value="<?php echo $_POST['quantity']?>" name="godina2">
            <input type="hidden" value="<?php echo $_POST['points']?>" name="hitno2">
        </form>
        <?php echo "<br/><br/><div class='poslano'>Ako ste pogrešno popunili formu, možete ispod prepraviti unesene podatke<br/><div>"; ?>
        
<?php endif; ?>
        
        <?php 
        if(isset($_POST['sakriven']) && $_POST['sakriven']=="Da")
                { 
                    $ime =  $_POST['ime2'];
                    $emailsubm =  $_POST['email2'];
                    $telefon =  $_POST['telefon2'];
                    $porukasubmit =  $_POST['porukasubmit2'];
                    $hitno = $_POST['hitno2'];
                    $godina = $_POST['godina2'];
            
                    ini_set("SMTP","webmail.etf.unsa.ba");
                    ini_set("smtp_port","25");
                    ini_set('sendmail_from','egazetic1@etf.unsa.ba');
            
                    $from = "egazetic1@etf.unsa.ba";
                    $cc = "vljubovic1@etf.unsa.ba";	
                    $subject = "Zubarska ordinacija Apple";
	
                    $header = "From: ".$from."\r\n"."Cc: ".$cc."\r\n"."Subject: ".$subject."\r\n"."Content-Type: text/html; charset=\"UTF-8\""."\r\n";
                    $porukasubmit = 'Ime: '.$ime.' Email: '.$emailsubm.' Telefon: '.$telefon.' Poruka '.$porukasubmit.' Godina: '.$godina.' Hitnost '.$hitno;

                    $dodatno = "CC: " . $cc . "\r\n" . "Reply-To: " . $emailsubm;
                    $poslanMail = mail($emailsubm, $subject, $porukasubmit, $dodatno);
                    if($poslanMail == 1) 
                           echo "<div class='poslano'>Zahvaljujemo vam što ste nas kontaktirali.</div>";
        
                    $prikaziFormu = false;
                }
        ?>
        
    <?php if($prikaziFormu): ?>
        
            <form class="kontakt-forma" action='ispravankontakt.php' method="POST" onSubmit="return validate();">
           
            <!-- Ime i prezime -->
                <label class="zvjezdica">*&nbsp;</label><label>Ime i prezime:&nbsp;</label>
                <?php if(isset($_POST['ime'])) { if(validacijaIme($_POST['ime'])) { echo '<div class="prikazime2"></div>'; } else { echo '<div class="prikazime1"></div>';} } elseif(empty($_POST['ime'])){ echo '<div class="prikazime1"></div>';}  ?>
                <div class="greskaime"><?php if(isset($_POST['ime'])) { if(validacijaIme($_POST['ime'])) { echo ""; } else { echo 'Greska';} }  ?> </div>
                
			<input class="name" type="text" name="ime" value="<?php if(isset($_POST['ime'])) echo $_POST['ime']; else echo ""; ?>"><br><br>
            <br>
            
            <!-- Email -->
			<label class="zvjezdica">*&nbsp;</label><label>Email:&nbsp;</label>
                <?php if(isset($_POST['email'])) { if(validacijaEmail($_POST['email'])) { echo '<div class="prikazemail2"></div>'; } else { echo '<div class="prikazemail1"></div>';} }  elseif(empty($_POST['email'])){ echo '<div class="prikazemail1"></div>';}  ?>
            <div class="greskaemail"><?php if(isset($_POST['email'])) { if(validacijaEmail($_POST['email'])) { echo ""; } else { echo "Greska";} }  ?></div>
			<input class="email" type="email" onChange="enableUnosPoruke()" name="email" value="<?php if(isset($_REQUEST['email'])) echo $_REQUEST['email']; else echo ""; ?>" novalidate><br><br>	
            <br>
            
            <!-- Telefon -->
            <label class="zvjezdica">*&nbsp;</label><label>Telefon:&nbsp;</label>
                 <?php if(isset($_POST['telefon'])) { if(validacijaTelefon($_POST['telefon'])) { echo '<div class="prikaztelefon2"></div>'; } else { echo '<div class="prikaztelefon1"></div>';} } else if(empty($_POST['telefon'])){ echo '<div class="prikaztelefon1"></div>';}  ?>
            <div class="greskatelefon"><?php if(isset($_POST['telefon'])) { if(validacijaTelefon($_POST['telefon'])) { echo ""; } else { echo "Greska";} }  ?></div>
            <input class="telefon" type="text" name="telefon" value="<?php if(isset($_REQUEST['telefon'])) echo $_REQUEST['telefon']; else echo ""; ?>"><br><br>
            <br>
            
            <!-- Godiste -->
            <label>Godiste:</label><br>
            <input type="number" name="quantity" min="1960" max="2000" class="godiste" value="<?php if(isset($_REQUEST['quantity'])) echo $_REQUEST['quantity']; else echo ""; ?>" ><br>
            <br>
            
            <!-- Hitno -->
            <label>Hitno:</label><br>
            <input type="range" name="points" min="0" max="10" value="<?php if(isset($_REQUEST['points'])) echo $_REQUEST['points']; else echo ""; ?>" ><br>
            <br>
            
            <!-- Poruka -->
			<label class="zvjezdica">*&nbsp;</label><label>Poruka:&nbsp;</label>
                 <?php if(isset($_POST['message'])) { if(validacijaIme($_POST['message'])) { echo '<div class="prikazporuka2"></div>'; } else { echo '<div class="prikazporuka1"></div>';} } elseif(empty($_POST['message'])){ echo '<div class="prikazporuka1"></div>';}  ?>
                
            <div class="greskaporuka"><?php if(isset($_POST['message'])) { if(validacijaPoruka($_POST['message'])) { echo ""; } else { echo "Greska";} } ?></div>
            <textarea class="message"  name="message" > <?php if(isset($_REQUEST['message'])) echo $_REQUEST['message']; else echo ""; ?> </textarea><br>
            <br>
            <br>
             
			<input class="send" type="reset" value="Resetuj">
			<input class="send" type="submit" value="Pošalji">
             <div><label class="zvjezdica">*&nbsp;</label> ~ Obavezno polje za popunjavanje.</div>
		</form>
        <?php endif; ?>
    </div>
</body>
</html>