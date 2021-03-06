<?php
session_start();

function zag() 
{
    header("{$_SERVER['SERVER_PROTOCOL']} 200 OK");
    header('Content-Type: text/html');
    header('Access-Control-Allow-Origin: *');
}


function napraviKonekciju()
{
    $conn = new PDO("mysql:dbname=appleordinacija;host=localhost;charset=utf8", "apple", "apple");
    // $conn = new PDO("mysql:dbname=appleordinacija;host=127.2.117.130;charset=utf8", "adminSFSF3dw", "st6BsffknmC7");
    
    return $conn;
}

//REST funkcije za manipulaciju podacima
function rest_get($request, $data) 
{
    $niz = explode("/", $request);
  
    $varijabla = $niz[count($niz)-1];
    $parametri = $niz[count($niz)-2];
    
    
  $conn= napraviKonekciju();
    
 if($parametri=="brojkomentara")
    {
        $vijestiId = $varijabla;  
        
        $komentaribroj = $conn->prepare('select id, vijest, autor, UNIX_TIMESTAMP(datum) datumkomentara, tekst, email from komentar where vijest='.$vijestiId);
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
       $komentari = $conn->query("SELECT id, vijest, autor, datum, vijest, tekst, email  FROM komentar WHERE vijest=".$vijestiId." ORDER BY datum desc");
        
    if (!$komentari) 
     {
          $greska = $conn->errorInfo();
          print "SQL greška: " . $greska[2];
          exit();
     }

    if(isset($_SESSION['admin']) && $_SESSION['admin']!="true")
       $istina  = false;
       else 
       $istina  = true;
       
        $del = array("administrator" => $istina , "komentari" => json_encode( $komentari->fetchAll()));
       
          echo json_encode($del);
    }
}

function rest_post($request, $data) 
{
$conn = napraviKonekciju();
    $insertujkomentar= $conn->prepare('INSERT INTO komentar (vijest, autor, tekst, email) VALUES(?, ?, ?, ?)');
    
    if (!$insertujkomentar) 
     {
          $greska = $conn->errorInfo();
          print "SQL greška: " . $greska[2];
          exit();
     }
    
    
    $ime = htmlentities($data['ime'], ENT_QUOTES);
    $email = htmlentities($data['email'], ENT_QUOTES);
  /*  if(isset($_SESSION['username'])) 
    {
        $ime = $_SESSION['username'];*/
      /*  $ispisikorisnika = $conn->prepare("SELECT id, username, password, email, administrator FROM korisnik where username=".$ime);
        $rezultat = $ispisikorisnika->fetchAll();
        $email = $rezultat['email'][0];*/
     /*   $email = "email@email.com";
    }*/
    
    
    $komentar = htmlentities($data['komentar'], ENT_QUOTES);
    $idVijesti = htmlentities($data['idvijesti'], ENT_QUOTES);

    $insertujkomentar->bindParam(1,$idVijesti);
    $insertujkomentar->bindParam(2,$ime);
    $insertujkomentar->bindParam(3,$komentar);
    $insertujkomentar->bindParam(4,$email);
    $insertujkomentar->execute();
    
    $unos = array('dodajkomentar'=>'true');
    $rezultat = json_encode($unos);
    echo $rezultat;
}


function rest_delete($request) 
{
    
  if(!isset($_SESSION['username']) || !isset($_SESSION['admin']) || (isset($_SESSION['admin']) && $_SESSION['admin'] == "false" ) )
    {
        
        return;
    }
    
    $niz = explode("/", $request);
  
    $varijabla = $niz[count($niz)-1];
    
    $conn= napraviKonekciju();
            
        $izbrisikomentar = $conn->prepare('DELETE from komentar WHERE id=?');
        $izbrisikomentar->bindValue(1, $varijabla, PDO::PARAM_INT);
        $izbrisikomentar->execute();
        
        $del = array('obrisikomentar'=>'true');
        $rezultat = json_encode( $del);
        echo $rezultat;
}

function rest_put($request, $data) 
{
    
}

function rest_error($request) 
{
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