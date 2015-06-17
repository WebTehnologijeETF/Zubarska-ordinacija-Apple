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
    $conn = napraviKonekciju();
       $poruke = $conn->query("SELECT id, korisnik, email, telefon, poruka, datum, procitana FROM poruka ORDER BY datum desc");
        
    if (!$poruke) 
     {
          $greska = $conn->errorInfo();
          print "SQL greška: " . $greska[2];
          exit();
     }

    if(isset($_SESSION['admin']) && $_SESSION['admin']!="true")
       $istina  = false;
       else 
       $istina  = true;
       
        $del = array("administrator" => $istina , "poruke" => json_encode( $poruke->fetchAll()));
       
          echo json_encode($del);
 }


function rest_post($request, $data) 
{
    $conn = napraviKonekciju();
    $insertujporuku= $conn->prepare('INSERT INTO poruka (korisnik,email,telefon,poruka,procitana) VALUES(?, ?, ?, ?, ?)');
    
    if (!$insertujporuku) 
     {
          $greska = $conn->errorInfo();
          print "SQL greška: " . $greska[2];
          exit();
     }
    
    
    $telefon = htmlentities($data['telefon'], ENT_QUOTES);
    $email = htmlentities($data['email'], ENT_QUOTES);
    $poruka = htmlentities($data['poruka'], ENT_QUOTES);
    $korisnik = htmlentities($data['korisnik'], ENT_QUOTES);
    $procitana = htmlentities($data['procitana'], ENT_QUOTES);

    $insertujporuku->bindParam(1,$korisnik);
    $insertujporuku->bindParam(2,$email);
    $insertujporuku->bindParam(3,$telefon);
    $insertujporuku->bindParam(4,$poruka);
    $insertujporuku->bindParam(5,$procitana);
    $insertujporuku->execute();
    
    $unos = array('dodajporuku'=>'true');
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
            
        $izbrisikomentar = $conn->prepare('DELETE from poruka WHERE id=?');
        $izbrisikomentar->bindValue(1, $varijabla, PDO::PARAM_INT);
        $izbrisikomentar->execute();
        
        $del = array('obrisiporuku'=>'true');
        $rezultat = json_encode( $del);
        echo $rezultat;
}

function rest_put($request, $data) 
{
      if(!isset($_SESSION['username']) || !isset($_SESSION['admin']) || (isset($_SESSION['admin']) && $_SESSION['admin'] == "false" ) )
    {
        
        return;
    }
    
    $telefon = htmlentities($data['telefon'], ENT_QUOTES);
    $email = htmlentities($data['email'], ENT_QUOTES);
    $poruka = htmlentities($data['poruka'], ENT_QUOTES);
    $korisnik = htmlentities($data['korisnik'], ENT_QUOTES);
    $procitana = htmlentities($data['procitana'], ENT_QUOTES);
    $id = htmlentities($data['id'], ENT_QUOTES);
    
    $conn = napraviKonekciju();
    
   $spasipromjeneporuke = $conn->prepare('UPDATE poruka SET telefon=?, email=?, poruka=?, korisnik=?, procitana=? WHERE id=?');
         if (!$spasipromjeneporuke) 
         {
              $greska = $conn->errorInfo();
              print "SQL greška: " . $greska[2];
              exit();
         }
                
    $spasipromjeneporuke->execute(array($telefon, $email, $poruka, $korisnik, $procitana, $id)); 
    
    $del = array('editujporuku'=>'true');
        $rezultat = json_encode($del);
        echo $rezultat;
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