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
    
    <!-- Sve je ispravno -->
    <?php if(!isset($_POST['hidden']) && isset($_POST['ime']) && isset($_POST['email']) && isset($_POST['telefon']) && isset($_POST['message']) && validacijaIme($_POST['ime']) && validacijaEmail($_POST['email']) && validacijaTelefon($_POST['telefon']) && validacijaPoruka($_POST['message'])) : ?>
    
    <?php 
        echo "Provjerite da li ste ispravno popunili kontakt formu!<br/><br/>";
        echo "Uneseni podaci: ";
        echo $_POST['ime'];
        echo $_POST['email'];
        echo $_POST['telefon'];
        echo $_POST['message'];
    ?>
        <form action="ispravankontakt.php" method="POST">
            <input class="send" type="submit" value="Siguran sam">
            <input type="hidden" value="Da" name="sakriven">
        </form>
        <?php echo "<br/><br/>Ako ste pogrešno popunili formu, možete ispod prepraviti unesene podatke\n"; ?>
        
<?php endif; ?>
        
        <?php 
        if(isset($_POST['sakriven']) && $_POST['sakriven']=="Da")
                { 

                    ini_set("SMTP","webmail.etf.unsa.ba");
                    ini_set("smtp_port","25");
                    ini_set('sendmail_from','egazetic1@etf.unsa.ba');
                    $to = "egazetic1@etf.unsa.ba";
                    $naslov = "Zubarska ordinacija Apple";
                    $cc = "vljubovic1@etf.unsa.ba";	
                    $email = "egazetic1@gmail.com";

                    $header = "From: ".$to."\r\n"."Cc: ".$cc."\r\n"."Reply-To: ".$naslov."\r\n"."Content-Type: text/html; charset=\"UTF-8\""."\r\n";
                    $poruka = "poruka";

                    $dodatno = "CC: " . $cc . "\r\n" . "Reply-To: " . $email;
                    $poslanMail = mail($to, $naslov, $poruka, $dodatno);
                    echo ($poslanMail == 1) ? "Zahvaljujemo vam sto ste nas kontaktirali." : "Došlo je do greške pri slanju maila.";
    
          }
        ?>
        
            <form class="kontakt-forma" action='ispravankontakt.php' method="POST" onSubmit="return validate();">
           <div id="testopcina"><label>Općina:</label><br>
            <input type="text" class="opcina" onChange="enablebutton()">
            <label>Mjesto:</label>
            <input type="text" class="mjesto" onChange="enablebutton()">
            <input class="send" type="button" value="Provjeri" onclick="provjeriajax()" disabled>
            <div id="tekst"></div>
            <div id="tekst2">
            Za provjeru potrebno unijeti i općinu i mjesto.</div>
             </div> <br><br><br><br><br>
            
            <!-- Ime i prezime -->
                <label class="zvjezdica">*&nbsp;</label><label>Ime i prezime:&nbsp;</label><div class="prikazime" ></div>
            
			<input class="name" type="text" name="ime" value="<?php if(isset($_POST['ime'])) echo $_POST['ime']; else echo ""; ?>"><br><br>
                <div class="greskaime"><?php if(isset($_POST['ime'])) { if(validacijaIme($_POST['ime'])) { echo ""; } else { echo "Greska";} }  ?> </div>
            <br>
            
            <!-- Email -->
			<label class="zvjezdica">*&nbsp;</label><label>Email:&nbsp;</label><div class="prikazemail"></div>
			<input class="email" type="email" onChange="enableUnosPoruke()" name="email" value="<?php if(isset($_REQUEST['email'])) echo $_REQUEST['email']; else echo ""; ?>" novalidate><br><br>
            <div class="greskaemail"><?php if(isset($_POST['email'])) { if(validacijaEmail($_POST['email'])) { echo ""; } else { echo "Greska";} }  ?></div>	
            <br>
            
            <!-- Telefon -->
            <label class="zvjezdica">*&nbsp;</label><label>Telefon:&nbsp;</label><div class="prikaztelefon"></div>
            <input class="telefon" type="text" name="telefon" value="<?php if(isset($_REQUEST['telefon'])) echo $_REQUEST['telefon']; else echo ""; ?>"><br><br>
            <div class="greskatelefon"><?php if(isset($_POST['telefon'])) { if(validacijaTelefon($_POST['telefon'])) { echo ""; } else { echo "Greska";} }  ?></div>
            <br>
            
            <!-- Godiste -->
            <label>Godiste:</label><br>
            <input type="number" name="quantity" min="1960" max="2000" class="godiste"><br>
            <br>
            
            <!-- Hitno -->
            <label>Hitno:</label><br>
            <input type="range" name="points" min="0" max="10"><br>
            <br>
            
            <!-- Poruka -->
			<label class="zvjezdica">*&nbsp;</label><label>Poruka:&nbsp;</label><div class="prikazporuka"></div>
            <textarea class="message"  name="message" > <?php if(isset($_REQUEST['message'])) echo $_REQUEST['message']; else echo ""; ?> </textarea><br>
            <div class="greskaporuka"><?php if(isset($_POST['message'])) { if(validacijaPoruka($_POST['message'])) { echo ""; } else { echo "Greska";} } ?></div>
            <br>
            <br>
             
			<input class="send" type="reset" value="Resetuj">
			<input class="send" type="submit" value="Pošalji">
             <div><label class="zvjezdica">*&nbsp;</label> ~ Obavezno polje za popunjavanje.</div>
		</form>

</body>
</html>