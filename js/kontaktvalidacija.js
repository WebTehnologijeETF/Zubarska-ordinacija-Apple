var regexIme = /\b([a-zA-Z]+)\b(\s\b([a-zA-Z]+)\b)*/;
var regexTelefon = /^\+?(\d{5})[-| ]?(\d{3})[-| ]?(\d{3})$/;
var regexEmail = /\b[a-zA-Z0-9+_-]+@+[a-zA-Z]+([.][a-z]+)*\b$/;


function validate()
{
    var imePrezime = document.getElementsByClassName('name')[0];
    var email = document.getElementsByClassName('email')[0];
    var telefon = document.getElementsByClassName('telefon')[0];
    var godiste = document.getElementsByClassName('godiste')[0];
    var hitnost = document.getElementsByClassName('hitnost')[0];
    var poruka = document.getElementsByClassName('message')[0];
    
    
    // Validacija imena i prezimena
    // Sa regexom
    var niz = regexIme.exec(imePrezime.value);
    var greska = document.getElementsByClassName('greskaime')[0];
    if(imePrezime.value == "null" || imePrezime.value == "")
    {
        greska.innerHTML="Obavezno polje za unos!";
        imePrezime.style.border = "solid 1px #ff0000";
    }
    else if(imePrezime.value.length < 3) 
    {
        greska.innerHTML = "Prekratko ime.";
        imePrezime.style.border = "solid 1px #ff0000";
    }
    else if(niz == null)
    {
        greska.innerHTML = "Unos dozvoljava samo slova.";
        imePrezime.style.border = "solid 1px #ff0000";
    }
    else
    {
        greska.innerHTML="";
        vratiBorder(imePrezime);
    }
    
    // Validacija email-a
    // Sam se validira, nije zasnovano na nasem regexu
    var greska2 = document.getElementsByClassName('greskaemail')[0];
    if(email.value == "null" || email.value == "")
    {
        greska2.innerHTML="Obavezno polje za unos!";
        email.style.border = "solid 1px #ff0000";
    }
    else
    {
        greska2.innerHTML="";
        vratiBorder(email);
    }
    
    //Validacija broja
    // Sa regexom
    niz = regexTelefon.exec(telefon.value);
    console.log(niz);
    var greska3 = document.getElementsByClassName('greskatelefon')[0];
    if(telefon.value == "null" || telefon.value == "")
    {
        greska3.innerHTML="Obavezno polje za unos!";
        telefon.style.border = "solid 1px #ff0000";
    }
    else if(niz == null)
    {
        greska3.innerHTML="Neispravan format broja! Mora biti xxxxx xxx xxx ili xxxxx-xxx-xxx ili xxxxxxxxxxx"
        telefon.style.border = "solid 1px #ff0000";
    }
    else
    {
        greska3.innerHTML="";
        vratiBorder(telefon);
    }
    
    // Validacija poruke 
    // Bez regexa
    var greska4 = document.getElementsByClassName('greskaporuka')[0];
    if(poruka.value == "null" || poruka.value == "")
    {
        greska4.innerHTML="Obavezno polje za unos!";
        poruka.style.border = "solid 1px #ff0000";
    }
    else
    {
        greska4.innerHTML="";
        vratiBorder(poruka);
    }
    
}

function vratiBorder(objekat)
{
     objekat.style.borderTop = "thin solid #B0B0B0";
     objekat.style.borderBottom = "thin solid #E0E0E0";
     objekat.style.borderLeft = "thin solid #E0E0E0";
     objekat.style.borderRight = "thin solid #E0E0E0 ";
}

function enableUnosPoruke()
{
    var poruka = document.getElementsByClassName('message')[0];
    var email = document.getElementsByClassName('email')[0];
    var niz = regexEmail.exec(email.value);
    console.log(niz);
    if(poruka.value.length > 0 || niz == null)
        poruka.disabled = true;
    else 
        poruka.disabled = false;
        
}