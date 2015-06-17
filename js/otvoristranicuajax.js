function ajaxdetaljnije(datum,autor,naslov,slika,tekst,det,idVijesti)
{
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() 
        {
            var obj2 = document.getElementsByClassName("content")[0];
            obj2.innerHTML = '<div class="ispiskomentara"></div>';
            var obj = document.getElementsByClassName("ispiskomentara")[0];
            
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                var x_1 = JSON.parse(ajax.responseText);
                var x_admin = x_1.administrator;
                var x_kom = x_1.komentari;
                var myString = '<div class="content-naslov">Novosti</div>';
                x = JSON.parse(x_kom);
            
                myString += '<div class="novost">'+
                '<div class="naslov">'+
                     '<div>'+
                         '<div class="datum">'+
                             '<div class="date-icon">▦</div>'+datum+
                          '</div>'+          
                ' <div class="autor">'+autor+'</div>'+
                      '</div>'+ naslov +
                '</div>';
                if(slika!="")
                myString+='<div style=\'width:500px; margin:20px auto;\'><img width=500 height=300 src="'+slika+'"></div>';
                myString+='<div class="tekst">'+
                    tekst +
                     '</div>' +
                     '<div class="tekst">'+
                    det + '</div>';
                
                
                obj.innerHTML += myString;
                
                var forma = '<div class="formaadmin">';
                    
                forma+='<div class="naslovforme">Postavite komentar na vijest:</div></br>'+
                '<label>Ime</label></br>'+
                '<input name="ime" class="ime"></br>'+
                '<label>Email</label></br>'+
                '<input name="email" class="email"></br>'+
                '<label>Komentar</label><br>';


                forma+='<textarea name="komentar" class="komentar"></textarea></br>'+
                '<input type="button" name="posaljikomentar" class="posalji" onclick="ajaxpostkomentar(\'dodajkomentar\','+idVijesti+','+"0"+','+x_admin+')" value="Postavi komentar"><br></div>';
                obj.innerHTML+=forma;
                
                console.log(x.length);
                    for(var i=0; i<x.length; i++)
                    {
                         var myString = '<table class="tabelaadmin">'+
                         '<tr>'+
                         '<td class="lijevo">' + x[i].datum +'</td>'+
                         '<td class="desno" rowspan="2">';
                         if(x[i].email != "")
                         myString +='<a href="mailto:'+x[i].email+'">'+x[i].autor+'</a>';
                        else 
                            myString +=x[i].autor;
                        
                        myString+='</td>'+
                         '</tr>'+
                         '<tr>'+
                         '<td class="centaremail">Email: '+x[i].email+'</td>'+
                         '</tr>'+
                         '<tr>'+
                         '<td colspan="2" class="centarlabela">Komentar:</td>'+
                         '</tr>'+
                         '<tr>'+
                         '<td colspan="2" class="centar">'+x[i].tekst+'</td>'+
                         '</tr>'+
                         '<tr>'+
                         '<td>';
                        
                        if(x_admin == "true")
                        myString+='<input type="button" value="Izbrisi" onclick=\'ajaxdeletekomentari(\"izbrisikomentar\",'+x[i].id+','+"0"+')\' >';
                        
                         myString += '</tr>'+
                         '</table>';
                       
                        myString +="<br/>";
                        obj.innerHTML += myString;
                    }
                        
                        
            }
            else if (ajax.readyState == 4 && ajax.status == 404)
                obj.innerHTML = "Greska: nepoznat URL";
        }
        
    
        ajax.open("GET", "phpval/rest_komentari.php/komentari/"+idVijesti, true);
        ajax.send();
    
}

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