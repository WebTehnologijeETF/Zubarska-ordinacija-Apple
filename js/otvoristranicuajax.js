function otvoriajax(varijabla)
{
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() 
        {
            var obj = document.getElementsByClassName("content")[0];
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                obj.innerHTML = ajax.responseText;

                if(varijabla == "lokacija")
                    pokrenimapu();
            }
            else if (ajax.readyState == 4 && ajax.status == 404)
                obj.innerHTML = "Greska: nepoznat URL";
        }
        
        if(varijabla=="kontakt" || varijabla=="novosti" || varijabla=="detaljnije" || varijabla=="adminpanel")
            var s = varijabla + ".php";
        else
             var s = varijabla + ".html";
    
        console.log(s);
        ajax.open("GET", s, true);
        ajax.send();
    
}

function novostiajax(datum,autor,naslov,slika,tekst,det)
{
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() 
        {
            var obj = document.getElementsByClassName("content")[0];
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                obj.innerHTML = ajax.responseText;
            }
            else if (ajax.readyState == 4 && ajax.status == 404)
                obj.innerHTML = "Greska: nepoznat URL";
        }
        
        var s = "detaljnije.php?"+"det="+det+"&autor="+autor+"&datum="+datum+"&naslov="+naslov+"&slika="+slika+"&tekst="+tekst;

        console.log(s);
        ajax.open("POST", s, true);
        ajax.send();

}

function vratiInputeZaDodavanje()
{
    var s = '<br>' 
            +'<div>Odaberite opciju: </div>'
            +'<select id="akcija" onchange="promjenaakcije()">'
            +'<option value = "Dodavanje">Dodavanje</option>'
            +'<option value = "Promjena">Promjena</option>'
            +'<option value = "Brisanje">Brisanje</option>'
            +'</select><br><br>'
            +'<label>Naziv: </label><br>'
            +'<input type="text" id="inaziv"><br>'
            +'<label>Cijena: </label><br>'
            +'<textarea id="icijena"></textarea><br>'
            +'<label>Opis: </label><br>'
            +'<textarea id="iopis"></textarea><br>'
            +'<label>Galerija: </label><br>'
            +'<input id="islika1" type="text"><br>'
            +'<input class="dodaj" type="button" value="Dodaj" onClick="dodajBrisiPromijeni()">';
    
    return s;
}

function enableInputBrisanje()
{
    var id = document.getElementById('iid').value;
    var nazivp = document.getElementById('inaziv');
    var cijenap = document.getElementById('icijena');
    var opisp = document.getElementById('iopis');
    var slika1 = document.getElementById('islika1');
    var dugme = document.getElementById('obrisi');
    
    var proizvodi=[];
    var usluge = document.getElementsByClassName("usluge-opis")[0];
    var ajax = new XMLHttpRequest();
    var tekst = "";
    ajax.onreadystatechange = function() {// Anonimna funkcija
        if (ajax.readyState == 4 && ajax.status == 200)
        {
            if (tekst!==ajax.responseText)
            {
                tekst = ajax.responseText;
                proizvodi = JSON.parse(tekst);
               
                for(var i=0; i<proizvodi.length; i++)
                {
                     var p = proizvodi[i];
                    if(id == p.id && id.length > 0)
                    {
                        nazivp.value =  p.naziv;
                        cijenap.value = p.cijena;
                        opisp.value = p.opis;
                        slika1.value = p.slika;
                        
                        dugme.disabled = false;
                        break;
                    }
                    else
                        dugme.disabled = true;
                }      
            }
        }
        if (ajax.readyState == 4 && ajax.status == 404)
            alert("Nepostojeći proizvod!");
        if (ajax.readyState == 4 && ajax.status == 400)
            alert("Neispravni podaci!");
    };
    ajax.open("GET", "http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=16353", true);
    ajax.send();
            
}

function vratiInputeZaBrisanje()
{
        var s = '<br>' 
            +'<div>Odaberite opciju: </div>'
            +'<select id="akcija" onchange="promjenaakcije()">'
            +'<option value = "Brisanje">Brisanje</option>'
            +'<option value = "Promjena">Promjena</option>'
            +'<option value = "Dodavanje">Dodavanje</option>'
            +'</select><br><br>'
            +'<label>ID: </label><br>'
            +'<input type="text" id="iid" onchange="enableInputBrisanje()"><br>'
            +'<label>Naziv: </label><br>'
            +'<input type="text" id="inaziv" disabled><br>'
            +'<label>Cijena: </label><br>'
            +'<textarea id="icijena" disabled></textarea><br>'
            +'<label>Opis: </label><br>'
            +'<textarea id="iopis" disabled></textarea><br>'
            +'<label>Galerija: </label><br>'
            +'<input id="islika1" type="text" disabled><br>'
            +'<input class="dodaj" id="obrisi" type="button" value="Brisanje" onClick="dodajBrisiPromijeni()" disabled>';
    
    return s;
}

function enableInput()
{
    var id = document.getElementById('iid').value;
    var nazivp = document.getElementById('inaziv');
    var cijenap = document.getElementById('icijena');
    var opisp = document.getElementById('iopis');
    var slika1 = document.getElementById('islika1');
    var dugme = document.getElementById('promijeni');
    
      var proizvodi=[];
    var usluge = document.getElementsByClassName("usluge-opis")[0];
    var ajax = new XMLHttpRequest();
    var tekst = "";
    ajax.onreadystatechange = function() {// Anonimna funkcija
        if (ajax.readyState == 4 && ajax.status == 200)
        {
            if (tekst!==ajax.responseText)
            {
                tekst = ajax.responseText;
                proizvodi = JSON.parse(tekst);
               
                for(var i=0; i<proizvodi.length; i++)
                {
                     var p = proizvodi[i];
                    if(id == p.id && id.length > 0)
                    {
                        nazivp.disabled = false;
                        cijenap.disabled = false;
                        opisp.disabled = false;
                        slika1.disabled = false;
                        dugme.disabled = false;
                       
                        nazivp.value =  p.naziv;
                        cijenap.value = p.cijena;
                        opisp.value = p.opis;
                        slika1.value = p.slika;
                        
                        break;
                    }
                    else
                    {
                        nazivp.disabled = true;
                        cijenap.disabled = true;
                        opisp.disabled = true;
                        slika1.disabled = true;
                        dugme.disabled = true;
                    }
                }      
            }
        }
        if (ajax.readyState == 4 && ajax.status == 404)
            alert("Nepostojeći proizvod!");
        if (ajax.readyState == 4 && ajax.status == 400)
            alert("Neispravni podaci!");
    };
    ajax.open("GET", "http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=16353", true);
    ajax.send();
            
}

function vratiInputeZaPromjenu()
{
    var s = '<br>' 
            +'<div>Odaberite opciju: </div>'
            +'<select id="akcija" onchange="promjenaakcije()">'
            +'<option value = "Promjena">Promjena</option>'
            +'<option value = "Dodavanje">Dodavanje</option>'
            +'<option value = "Brisanje">Brisanje</option>'
            +'</select><br><br>'
            +'<label>ID: </label><br>'
            +'<input type="text" id="iid" onchange="enableInput()"><br>'
            +'<label>Naziv: </label><br>'
            +'<input type="text" id="inaziv" disabled><br>'
            +'<label>Cijena: </label><br>'
            +'<textarea id="icijena" disabled></textarea><br>'
            +'<label>Opis: </label><br>'
            +'<textarea id="iopis" disabled></textarea><br>'
            +'<label>Galerija: </label><br>'
            +'<input id="islika1" type="text" disabled><br>'
            +'<input class="dodaj" id="promijeni" type="button" value="Promijeni" onClick="dodajBrisiPromijeni()" disabled>';
    
    return s;
}

//USLUGE
function promjenaakcije()
{
    var izbor = document.getElementById("akcija").value.toLowerCase();
    console.log(izbor);
    switch(izbor)
    {
            case "dodavanje": 
                document.getElementsByClassName('usluge-forma')[0].innerHTML = vratiInputeZaDodavanje();
            break;
            case "brisanje": 
                document.getElementsByClassName('usluge-forma')[0].innerHTML = vratiInputeZaBrisanje();
            break;
            case "promjena":
                document.getElementsByClassName('usluge-forma')[0].innerHTML = vratiInputeZaPromjenu();
            break;
    }
}

function dodajBrisiPromijeni()
{
        var ajax = new XMLHttpRequest();
        
        ajax.onreadystatechange = function() {// Anonimna funkcija
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                    alert("Uspješno dodani/promijenjeni podaci proizvoda!");
            }
            if (ajax.readyState == 4 && ajax.status == 404)
                alert("Nepostojeći proizvod!");
            if (ajax.readyState == 4 && ajax.status == 400)
                alert("Neispravni podaci!");
        };

        ajax.open("POST", "http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=16353", true);
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
         var akcija = document.getElementById('akcija').value.toLowerCase();
         var nazivp = document.getElementById('inaziv').value;
         var cijenap = document.getElementById('icijena').value;
         var opisp = document.getElementById('iopis').value;
         var slika1 = document.getElementById('islika1').value;
    
        var A=[];
        if(akcija == "promjena")
        {
            var iid = document.getElementById('iid').value;
            A = {id:iid,naziv: nazivp, cijena: cijenap, opis: opisp, slika: slika1};
        }
        else if(akcija == "brisanje")
        {
           var iid = document.getElementById('iid').value;
           A = {id:iid};  
        }
        else
        {
            A = {naziv: nazivp, cijena: cijenap, opis: opisp, slika: slika1};
        }
         
         console.log("akcija= " + akcija);
         ajax.send("akcija=" + akcija + "&proizvod=" + JSON.stringify(A));
}


function KreirajTabelu(proizvodi)
{
    var s="";
    for(var i = 0; i<proizvodi.length; i++)
    {
        var p = proizvodi[i];
        s+= "<tr><td class='margina'>ID: "+p.id+"</td></tr>";
        s+="<tr><th class='naziv'>"+p.naziv+"</th></tr>";
        s+="<tr><td class='podnaslov'>Cijena</td></tr>";
        s+="<tr><td class='cijena'>"+p.cijena+"</td></tr>";
        s+="<tr><td class='podnaslov'>Opis</td></tr>";
        s+="<tr><td class='opis'>"+p.opis+"</td></tr>;";
        s+="<tr><td class='podnaslov'>Galerija</td></tr>";
        s+="<tr><td class='gallery'><div class='picture1"+i+"'></div></td></tr>";
    } 
    
    return s;
}

function podesiVelicine(proizvodi)
{
    for(var i = 0; i<proizvodi.length; i++)
    {
        var p = proizvodi[i];
       document.getElementsByClassName('picture1'+i)[0].style.background="url('"+p.slika+"') no-repeat";
       document.getElementsByClassName('picture1'+i)[0].style.backgroundSize="contain";
       document.getElementsByClassName('picture1'+i)[0].style.height = "150px";
       document.getElementsByClassName('picture1'+i)[0].style.width = "300px";
       document.getElementsByClassName('margina')[i].style.paddingTop="50px"; 
       document.getElementsByClassName("usluge-opis")[i].style.width="100%";     
    } 
    
}

function ostaleUsluge()
{
    var proizvodi=[];
    var usluge = document.getElementsByClassName("usluge-opis")[0];
    var ajax = new XMLHttpRequest();
    var tekst = "";
    ajax.onreadystatechange = function() {// Anonimna funkcija
        if (ajax.readyState == 4 && ajax.status == 200)
        {
            if (tekst!==ajax.responseText)
            {
                tekst = ajax.responseText;
                proizvodi = JSON.parse(tekst);
                usluge.innerHTML = KreirajTabelu (proizvodi);
                podesiVelicine(proizvodi);
            }
        }
        if (ajax.readyState == 4 && ajax.status == 404)
            alert("Nepostojeći proizvod!");
        if (ajax.readyState == 4 && ajax.status == 400)
            alert("Neispravni podaci!");
    };
    ajax.open("GET", "http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=16353", true);
        ajax.send();
    
        return false;
}