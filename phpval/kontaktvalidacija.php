<?php

function validacijaIme($ime) 
{
    $regexIme = "/\b([a-zA-Z]+)\b(\s\b([a-zA-Z]+)\b)*/"; 
    
    if(strlen(preg_replace('/\s+/','',$ime)) == 0 || !preg_match($regexIme,$ime)) 
        return false;
    else
    return true;
}

function validacijaEmail($email) 
{
    
    $regexEmail = "/\b[a-zA-Z0-9+_-]+@+[a-zA-Z]+([.][a-z]+)*\b$/";
    if(strlen(preg_replace('/\s+/','',$email)) == 0 || !preg_match($regexEmail, $email)) 
        return false;
    else
    return true;
}

function validacijaTelefon($telefon) 
{
    
    $regexTelefon = "/^\+?(\d{5})[-| ]?(\d{3})[-| ]?(\d{3})$/";
    
    if(strlen(preg_replace('/\s+/','',$telefon)) == 0 || !preg_match($regexTelefon, $telefon)) 
        return false;
    else
    return true;
}

function validacijaPoruka($poruka) 
{
    if(strlen(preg_replace('/\s+/','',$poruka)) == 0 ) 
        return false;
    else
    return true;
}

?>