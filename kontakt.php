<!DOCTYPE html>
<html>
<head>
	<title>Ordinacija</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
   <script src="js/kontaktvalidacija.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>
<body>
    
    <?php include("php/kontaktvalidacija.php"); ?>
    
         <div class="content-naslov">
                Kontakt
         </div>
        <br>
        
		<form class="kontakt-forma" action='kontakt.php' method="POST">
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
			<label class="zvjezdica">*&nbsp;</label><label>Ime i prezime:&nbsp;</label><div class="prikazime"></div>
			<input class="name" size=25 maxlength=25 type="text" name="ime" value="<?php if(isset($_REQUEST['name'])) echo $_REQUEST['name']; else echo ""; ?>"><br><br>
                <div class="greskaime"><?php if(isset($_POST['ime'])) { if(validacijaIme($_POST['ime'])) { echo "greska"; } else { echo "";} }  ?> </div>
            <br>
            
            <!-- Email -->
			<label class="zvjezdica">*&nbsp;</label><label>Email:&nbsp;</label><div class="prikazemail"></div>
			<input class="email" type="email" onChange="enableUnosPoruke()" name="email" value="<?php if(isset($_REQUEST['email'])) echo $_REQUEST['email']; else echo ""; ?>"><br><br>
            <div class="greskaemail"><?php if(isset($_POST['email'])) { if(validacijaEmail($_POST['email'])) { echo "greska"; } else { echo "";} }  ?></div>	
            <br>
            
            <!-- Telefon -->
            <label class="zvjezdica">*&nbsp;</label><label>Telefon:&nbsp;</label><div class="prikaztelefon"></div>
            <input class="telefon" type="text" name="telefon" value="<?php if(isset($_REQUEST['telefon'])) echo $_REQUEST['telefon']; else echo ""; ?>"><br><br>
            <div class="greskatelefon"><?php if(isset($_POST['telefon'])) { if(validacijaTelefon($_POST['telefon'])) { echo "greska"; } else { echo "";} }  ?></div>
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
            <textarea class="message" <?php if(isset($_POST['email'])) { if(validacijaIme($_POST['email'])) { echo ""; } else { echo 'disabled="disabled"';} }  ?>  name="message" value="<?php if(isset($_REQUEST['message'])) echo $_REQUEST['message']; else echo ""; ?>"></textarea><br>
            <div class="greskaporuka"><?php if(isset($_POST['message'])) { if(validacijaPoruka($_POST['message'])) { echo "greska"; } else { echo "";} } ?></div>
            <br>
            <br>
            
			<input class="send" type="submit" value="Pošalji" onclick="return validate();">
             <div><label class="zvjezdica">*&nbsp;</label> ~ Obavezno polje za popunjavanje.</div>
		</form>
         
</body>
</html>