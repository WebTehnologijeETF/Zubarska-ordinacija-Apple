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
      //  $conn = new PDO("mysql:dbname=appleordinacija;host=127.2.117.130;charset=utf8", "adminSFSF3dw", "st6BsffknmC7");
    
    return $conn;
}

//REST funkcije za manipulaciju podacima
function rest_get($request, $data) 
{
    $niz = explode("/", $request);
  
    $varijabla = $niz[count($niz)-1];
    

   if(!isset($_SESSION['username']) || !isset($_SESSION['admin']) || (isset($_SESSION['admin']) && $_SESSION['admin'] == "false" ) )
    {
        
        return;
    }
    
    
    $conn = napraviKonekciju();
   
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
}

function rest_post($request, $data) 
{
    
   if(!isset($_SESSION['username']) || !isset($_SESSION['admin']) || (isset($_SESSION['admin']) && $_SESSION['admin'] == "false" ) )
    {
        
        return;
    }
    
      
    $username = htmlentities($data['username'],ENT_QUOTES);
    $lozinka = htmlentities($data['lozinka'],ENT_QUOTES);
    $administrator = htmlentities($data['administrator'],ENT_QUOTES);
    $email = $data['email'];
    
    $conn = napraviKonekciju();
    
        $insertujkorisnika= $conn->prepare('INSERT INTO korisnik (username, password, email, administrator) VALUES(?, ?, ?, ?)');
        if (!$insertujkorisnika) 
         {
              $greska = $conn->errorInfo();
              print "SQL greška: " . $greska[2];
              exit();
         }

        $insertujkorisnika->bindParam(1,$username);
        $insertujkorisnika->bindParam(2,$lozinka);
        $insertujkorisnika->bindParam(3,$email);
        $insertujkorisnika->bindParam(4,$administrator);
        $insertujkorisnika->execute();
    
    
    $unos = array('dodajkorisnika'=>'true');
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
    $conn =  napraviKonekciju();
        $izbrisikorisnika = $conn->prepare('DELETE from korisnik WHERE id=?');

        $idkorisnika = htmlentities($varijabla, ENT_QUOTES);
        $izbrisikorisnika->execute(array($idkorisnika));
    
     $del = array('izbrisikorisnika'=>'true');
        $rezultat = "{ \"izbrisikorisnika\": ".json_encode( $del)."}";
        echo $rezultat;
}
function rest_put($request, $data) 
{
    
  if(!isset($_SESSION['username']) || !isset($_SESSION['admin']) || (isset($_SESSION['admin']) && $_SESSION['admin'] == "false" ) )
    {
        
        return;
    }
    
    $username = htmlentities($data['username'],ENT_QUOTES);
    $lozinka = htmlentities($data['lozinka'],ENT_QUOTES);
    $administrator = htmlentities($data['administrator'],ENT_QUOTES);
    $email = $data['email'];
    $id=$data['id'];
    
 $conn = napraviKonekciju();
    
                   $spasipromjenekorisnika = $conn->prepare('UPDATE korisnik SET username=?, password=?, email=?, administrator=? WHERE id=?');
                     if (!$spasipromjenekorisnika) 
                     {
                          $greska = $conn->errorInfo();
                          print "SQL greška: " . $greska[2];
                          exit();
                     }
                
    $spasipromjenekorisnika->execute(array($username,$lozinka,$email,$administrator,$id)); 
    
    $del = array('editujkorisnika'=>'true');
        $rezultat = json_encode($del);
        echo $rezultat;
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