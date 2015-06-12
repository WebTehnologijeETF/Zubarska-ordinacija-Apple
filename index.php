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

<body onLoad="otvoriajax('pocetna')"  >
	<div class="header">
		<div class="login">
            
            <?php 
                if(isset($_REQUEST['logout']))
                {
                    unset($_SESSION['username']);
                    session_unset();
                }
                
            ?>
         <?php if(isset($_POST['reset'])):?>
                <!--
   require "Mail.php";
   // Identify the sender, recipient, mail subject, and body
   $sender    = "sender@gmail.com";
   $recipient = "egazetic1@gmail.com";
   $addCc = "egazetic1@gmail.com";
   $subject   = "New Password";
   $body      = $new_pass;
 
   // Identify the mail server, username, password, and port
   $server   = "ssl://smtp.gmail.com";
   $username = "egazetic1@gmail.com";
   $password = "";
   $port     = "465";
 
   // Set up the mail headers
   $headers = array(
      "From"    => $sender,
      "To"      => $recipient,
      "Subject" => $subject
   );
 
   // Configure the mailer mechanism
   $smtp = Mail::factory("smtp",
      array(
        "host"     => "appleordinacija-wete.rhcloud.com",
        "username" => "adminSFSF3dw"
        "password" => "st6BsffknmC7",
        "auth"     => true,
        "port"     => 465
      )
   );
 
   // Send the message
   $mail = $smtp->send($recipient, $headers, $body);
  
   if (PEAR::isError($mail)) {
    echo ($mail->getMessage());
   }
   else
   {
      echo '<script>alert("Novi password je poslan na Vašu email adresu.")</script>';
      header( 'refresh: 0; index.php' );
   }
   -->

     <?php endif;?> 
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

	</div>
	<div class="footer"></div>
</body>
</html>