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
    
  $conn = napraviKonekciju();
   
    if($varijabla=="vijesti")
    {
         $vijesti= $conn->query("select id, naslov, tekst,datum datumvijesti, autor, detaljnije,slika from vijest order by datum desc");

             if (!$vijesti) 
             {
                  $greska = $conn->errorInfo();
                  print "SQL greška: " . $greska[2];
                  exit();
             }
        
        $rezultat = "{ \"vijesti\": ".json_encode($vijesti->fetchAll())."}";
        echo $rezultat;
    }
  
}

function rest_post($request, $data) 
{

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