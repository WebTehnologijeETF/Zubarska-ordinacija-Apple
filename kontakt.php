<!DOCTYPE html>
<html>
<head>
	<title>Ordinacija</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
   <!-- <script src="js/kontaktvalidacija.js"></script>-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <!-- <script>
        var opcina = document.getElementsByClassName("opcina")[0];
        opcina.addEventListener("change",functionOnChange,false);
        
        function functionOnChange()
        {
            alert("huhu");
            console.log("askd");
        }
    </script>-->
</head>
<body>
         <div class="content-naslov">
                Kontakt
         </div>
        <br>
        
		<form class="kontakt-forma" action='kontakt.php' method="POST">
           <div id="testopcina"><label>Općina:</label><br>
           
    <script src="js/kontaktvalidacija.js"></script> <input type="text" class="opcina" onChange="enablebutton()">
            <label>Mjesto:</label>
            <input type="text" class="mjesto" onChange="enablebutton()">
            <input class="send" type="button" value="Provjeri" onclick="provjeriajax()" disabled>
            <div id="tekst"></div>
            <div id="tekst2">
            Za provjeru potrebno unijeti i općinu i mjesto.</div>
             </div> <br><br><br><br><br>
			<label class="zvjezdica">*&nbsp;</label><label>Ime i prezime:&nbsp;</label><div class="prikazime"></div>
			<input class="name" size=25 maxlength=25 type="text" name="ime"><br><br>
            <div class="greskaime"></div>
            <br>
			<label class="zvjezdica">*&nbsp;</label><label>Email:&nbsp;</label><div class="prikazemail"></div>
			<input class="email" type="email" onChange="enableUnosPoruke()" name="email"><br><br>
            <div class="greskaemail"></div>	
            <br>
            <label class="zvjezdica">*&nbsp;</label><label>Telefon:&nbsp;</label><div class="prikaztelefon"></div>
            <input class="telefon" type="text" name="telefon"><br><br>
            <div class="greskatelefon"></div>
            <br>
            <label>Godiste:</label><br>
            <input type="number" name="quantity" min="1960" max="2000" class="godiste"><br>
            <br>
            <label>Hitno:</label><br>
            <input type="range" name="points" min="0" max="10"><br>
            <br>
			<label class="zvjezdica">*&nbsp;</label><label>Poruka:&nbsp;</label><div class="prikazporuka"></div>
            <textarea class="message" disabled="disabled" name="message"></textarea><br>
            <div class="greskaporuka"></div>
            <br>
            <br>
			<input class="send" type="submit" value="Pošalji" onclick="return validate();">
             <div><label class="zvjezdica">*&nbsp;</label> ~ Obavezno polje za popunjavanje.</div>
		</form>
         
</body>
</html>