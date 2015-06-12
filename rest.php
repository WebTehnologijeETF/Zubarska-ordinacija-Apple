<?php
session_start();

function zag() 
{
    header("{$_SERVER['SERVER_PROTOCOL']} 200 OK");
    header('Content-Type: text/html');
    header('Access-Control-Allow-Origin: *');
}

//REST funkcije za manipulaciju podacima
function rest_get($request, $data) 
{
    $niz = explode("/", $request);
  
    $varijabla = $niz[count($niz)-1];
    $parametri = $niz[count($niz)-2];
    
   /* if(!isset($_SESSION['username']) || !isset($_SESSION['admin']) && $varijabla == "korisnik")
    {
        return;
    }*/
    
    $conn = new PDO("mysql:dbname=appleordinacija;host=localhost;charset=utf8", "apple", "apple");
        //$conn = new PDO("mysql:dbname=appleordinacija;host=127.2.117.130;charset=utf8", "adminSFSF3dw", "st6BsffknmC7");
   
    if($varijabla == "korisnik")
    { 
        
        $ispisikorisnika = $conn->query("SELECT id, username, password, email, administrator FROM korisnik ORDER BY id");
            if (!$ispisikorisnika) 
             {
                  $greska = $conn->errorInfo();
                  print "SQL greška: " . $greska[2];
                  exit();
             }
            $rezultat = "{ \"korisnici\": ".json_encode($ispisikorisnika->fetchAll())."}";
            echo $rezultat;
    }
    else if($varijabla=="vijesti")
    {
    
         $vijesti= $conn->query("select id, naslov, tekst, UNIX_TIMESTAMP(datum) datumvijesti, autor, detaljnije,slika from vijest order by datum desc");

             if (!$vijesti) 
             {
                  $greska = $conn->errorInfo();
                  print "SQL greška: " . $greska[2];
                  exit();
             }
        $rezultat = "{ \"vijesti\": ".json_encode($vijesti->fetchAll())."}";
        echo $rezultat;
    }
    else if($parametri=="brojkomentara")
    {
        $vijestiId = $varijabla;  
        
        $komentaribroj = $conn->prepare('select id, vijest, autor, UNIX_TIMESTAMP(datum) datumkomentara, tekst, email from komentar where vijest='.$vijestiId.' order by datumkomentara desc');
            if (!$komentaribroj) 
             {
                  $greska = $conn->errorInfo();
                  print "SQL greška: " . $greska[2];
                  exit();
             }
        $komentaribroj->execute();
        $brojac = $komentaribroj->rowCount();
        $brojkomentara = "{ \"brojkomentara\": ".json_encode($brojac)."}";
        echo $brojkomentara;
    }
    else if($parametri == "komentari")
    {
        $vijestiId = $varijabla;
       $komentari = $conn->query("SELECT id, vijest, autor, datum, vijest, tekst, email  FROM komentar WHERE vijest=".$vijestiId." ORDER BY datum");
            if (!$komentari) 
             {
                  $greska = $conn->errorInfo();
                  print "SQL greška: " . $greska[2];
                  exit();
             }
         $rezultat = "{ \"komentari\": ".json_encode( $komentari->fetchAll())."}";
          echo $rezultat;
    }

    
  /*  $uri = explode("/", $request);
    $class = $uri[count($uri)-2];
    if($class!=="poruke")
    {
        return;
    }
    $number = $uri[count($uri)-1];
    if($number==="all")
    {
        try{
            $veza = new PDO("mysql:dbname=zadaci;host=localhost;charset=utf8", "korisnik", "pasvord");
        }catch (PDOException $ex){
            print "MYSQL greška: ".$ex->getMessage();
            die();
        }
        $rezultat = $veza->query("SELECT * FROM chat ORDER BY vrijeme DESC LIMIT 50");
        if(!$rezultat){
            print "Greška: ".$rezultat->errorInfo();
            die();
        }
        header('Content-Type: application/json');
        print "{ \"poruke\": " . json_encode($rezultat->fetchAll()) . "}";
    }else if(strpos($number,'timestamp') !== false){
        try{
            $veza = new PDO("mysql:dbname=zadaci;host=localhost;charset=utf8", "korisnik", "pasvord");
        }catch (PDOException $ex){
            print "MYSQL greška: ".$ex->getMessage();
            die();
        }
        $tmst = htmlentities($data['timestamp']);
        $tmst = date("Y-m-d H:i:s", strtotime($tmst));
        $rezultat = $veza->prepare("SELECT * FROM chat  WHERE   vrijeme > ? ORDER BY vrijeme DESC LIMIT 50");
        $rezultat->bindParam(1, $tmst);
        $rezultat->execute();
        if(!$rezultat){
            print "Greška: ".$rezultat->errorInfo();
            die();
        }
        if($rezultat->rowCount()>0) {
            header('Content-Type: application/json');
            print "{ \"poruke\": " . json_encode($rezultat->fetchAll()) . "}";
        }else{
            //rest_error($request);
            http_response_code(300);
            $greska = array('vrsta'=>"Nema novih poruka");
            $json = "{ \"Notifikacija\": ".json_encode($greska)."}";
            print $json;
        }
    }*/
}

function rest_post($request, $data) 
{
   /* if(isset($_SESSION['username'])){
        $korisnik = $_SESSION['username'];
    }else{
        $korisnik = "Anoniman";
    }
    $uri = explode("/", $request);
    $class = $uri[count($uri)-1];
    if($class!=="poruke" && $class!=="komentari"){
        return;
    }
    if($class==="komentari"){
        try{
            $veza = new PDO("mysql:dbname=zadaci;host=localhost;charset=utf8", "korisnik", "pasvord");
        }catch (PDOException $ex){
            print "MYSQL greška: ".$ex->getMessage();
            die();
        }
        $json = json_decode($data['komentar'], true);
        $tekst = $json['tekst'];
        $novostId = $json['vijestID'];
        $novostId = htmlentities($novostId);
        $cleanText = htmlentities($tekst);
        $upit = $veza->prepare("INSERT INTO komentari (vijest, tekst, autor) VALUES (:news, :txt, :usr)");
        $upit->bindParam(':news', $novostId);
        $upit->bindParam(':txt', $cleanText);
        $upit->bindParam(':usr', $korisnik);
        $upit->execute();
        if(!$upit){
            print "Greška: ".$upit->errorInfo();
            die();
        }
        $poruka = $veza->query("SELECT * FROM komentari ORDER BY vrijeme DESC LIMIT 1");
        if(!$poruka){
            print "Greška: ".$poruka->errorInfo();
            die();
        }
        header('Content-Type: application/json');
        print "{ \"komentar\": ". json_encode($poruka->fetch()) . "}";
        die();
    }
    try{
        $veza = new PDO("mysql:dbname=zadaci;host=localhost;charset=utf8", "korisnik", "pasvord");
    }catch (PDOException $ex){
        print "MYSQL greška: ".$ex->getMessage();
        die();
    }
    $json = json_decode($data['poruka'], true);
    $tekst = $json['tekst'];
    $cleanText = htmlentities($tekst);
    $upit = $veza->prepare("INSERT INTO chat (korisnik, tekst) VALUES (:usr, :txt)");
    $upit->bindParam(':usr', $korisnik);
    $upit->bindParam(':txt', $cleanText);
    $upit->execute();
    if(!$upit){
        print "Greška: ".$upit->errorInfo();
        die();
    }
    $poruka = $veza->query("SELECT * FROM chat ORDER BY vrijeme DESC LIMIT 1");
    if(!$poruka){
        print "Greška: ".$poruka->errorInfo();
        die();
    }
//    header('Content-Type: application/json');
    print "{ \"poruka\": ". json_encode($poruka->fetch()) . "}";*/
}


function rest_delete($request) {

}
function rest_put($request, $data) {

}

function rest_error($request) {
    $greska = array('greska'=>"Vrsta greške");
    $json = "{ \"Greška\": ".json_encode($greska)."}";
    header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
    print $json;
}

$method  = $_SERVER['REQUEST_METHOD'];
$request = $_SERVER['REQUEST_URI'];

switch($method) {
    case 'PUT':
        parse_str(file_get_contents('php://input'), $put_vars);
        zag(); $data = $put_vars; rest_put($request, $data); break;
    case 'POST':
        zag(); $data = $_POST; rest_post($request, $data); break;
    case 'GET':
        zag(); $data = $_GET; rest_get($request, $data); break;
    case 'DELETE':
        zag(); rest_delete($request); break;
    default:
        header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
        rest_error($request); break;
}
?>