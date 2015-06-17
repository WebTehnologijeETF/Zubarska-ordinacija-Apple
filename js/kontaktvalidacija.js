var regexIme = /\b([a-zA-Z]+)\b(\s\b([a-zA-Z]+)\b)*/;
var regexTelefon = /^\+?(\d{5})[-| ]?(\d{3})[-| ]?(\d{3})$/;
var regexEmail = /\b[a-zA-Z0-9+_-]+@+[a-zA-Z]+([.][a-z]+)*\b$/;


 function provjeriajax()
    {
        var opcina = document.getElementsByClassName('opcina')[0];
        var mjesto = document.getElementsByClassName('mjesto')[0];
        var tekst = document.getElementById('tekst');
        tekst.style.float="left";
        
        var ajax = new XMLHttpRequest();

        ajax.onreadystatechange = function()
            {
                if(ajax.readyState == 4 && ajax.status == 200)
                {
                    var odgovor = ajax.responseText;
                    var parsodgovor = JSON.parse(odgovor);
                   
                    if (parsodgovor['ok'] === "Mjesto je iz date općine")
                    document.getElementById("tekst").innerHTML="Mjesto je iz date općine";
                    else if (parsodgovor['greska'] === "Nepostojeće mjesto")
                    document.getElementById("tekst").innerHTML="Nepostojeće mjesto";
                    else
                    document.getElementById("tekst").innerHTML = "Nepostojeće mjesto";
                }
            }
        
        ajax.open("GET", "http://zamger.etf.unsa.ba/wt/mjesto_opcina.php?opcina="+opcina.value+"&mjesto="+mjesto.value, true);
        ajax.send();
        }


function validate()
{
    var imePrezime = document.getElementsByClassName('name')[0];
    var email = document.getElementsByClassName('email')[0];
    var telefon = document.getElementsByClassName('telefon')[0];
    var poruka = document.getElementsByClassName('message')[0];
    
    var brojac = 0;
    // Validacija imena i prezimena
    // Sa regexom
    var niz = regexIme.exec(imePrezime.value);
    var greska = document.getElementsByClassName('greskaime')[0];
    var slika1 = document.getElementsByClassName('prikazime')[0];
       
    if(imePrezime.value == "null" || imePrezime.value == "")
    {
        slika1.style.background ="url(img/false.png) no-repeat";
        greska.innerHTML="Obavezno polje za unos!";
        imePrezime.style.border = "solid 1px #ff0000";
        brojac++;
    }
    else if(imePrezime.value.length < 3) 
    {
        greska.innerHTML = "Prekratko ime.";
        imePrezime.style.border = "solid 1px #ff0000";
        slika1.style.background ="url(img/false.png) no-repeat";
        brojac++;
        
    }
    else if(niz == null)
    {
        greska.innerHTML = "Unos dozvoljava samo slova.";
        imePrezime.style.border = "solid 1px #ff0000";
        slika1.style.background ="url(img/false.png) no-repeat";
        brojac++;
    }
    else
    {
        greska.innerHTML="";
        vratiBorder(imePrezime);
        slika1.style.background ="url(img/true.png) no-repeat";
        brojac--;
    }
    
    
    var nizemail = regexEmail.exec(email.value);

    var greska2 = document.getElementsByClassName('greskaemail')[0];
    var slika2 = document.getElementsByClassName('prikazemail')[0];
    if(email.value == "null" || email.value == "" || niz==null)
    {
        greska2.innerHTML="Obavezno polje za unos!";
        email.style.border = "solid 1px #ff0000";
        slika2.style.background ="url(img/false.png) no-repeat";
        brojac++;
    }
    else if(nizemail!=null)
    {
        greska2.innerHTML="";
        vratiBorder(email);
        slika2.style.background ="url(img/true.png) no-repeat";
        brojac--;
    }
    
    //Validacija broja
    // Sa regexom
    niz = regexTelefon.exec(telefon.value);
    var greska3 = document.getElementsByClassName('greskatelefon')[0];
    var slika3 = document.getElementsByClassName('prikaztelefon')[0];
     var p = telefon.value;
    if(p.trim().length == 0 || telefon.value == "null" || telefon.value == "")
    {
        greska3.innerHTML="Obavezno polje za unos!";
        telefon.style.border = "solid 1px #ff0000";
        slika3.style.background = "url(img/false.png) no-repeat";
        brojac++;
    }
    else if(niz == null)
    {
        greska3.innerHTML="Neispravan format broja! Mora biti xxxxx xxx xxx ili xxxxx-xxx-xxx ili xxxxxxxxxxx"
        telefon.style.border = "solid 1px #ff0000";
        slika3.style.background ="url(img/false.png) no-repeat";
        vratiFalse = true;
        brojac++;
    }
    else
    {
        greska3.innerHTML="";
        vratiBorder(telefon);
        slika3.style.background ="url(img/true.png) no-repeat";
        brojac--;
    }
    
    // Validacija poruke 
    // Bez regexa
    var greska4 = document.getElementsByClassName('greskaporuka')[0];
    var slika4 = document.getElementsByClassName('prikazporuka')[0];
    var s = poruka.value;
    
    if(s.trim().length == 0 || s == "null" || s == "" )
    {
        greska4.innerHTML="Obavezno polje za unos!";
        poruka.style.border = "solid 1px #ff0000";
        slika4.style.background ="url(img/false.png) no-repeat";
        brojac++;
    }
    else
    {
        greska4.innerHTML="";
        vratiBorder(poruka);
        slika4.style.background ="url(img/true.png) no-repeat";
        brojac--;
    }
    
    console.log(brojac);
    if(brojac== -4)
    {
        return true;
    }
    
    return false;
}

function vratiBorder(objekat)
{
     objekat.style.borderTop = "thin solid #B0B0B0";
     objekat.style.borderBottom = "thin solid #E0E0E0";
     objekat.style.borderLeft = "thin solid #E0E0E0";
     objekat.style.borderRight = "thin solid #E0E0E0 ";
}

