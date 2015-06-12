function ajaxgetvijesti(varijabla)
{
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() 
        {
            var obj = document.getElementsByClassName("content")[0];
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                //console.log(ajax.responseText);
               var x = JSON.parse(ajax.responseText);
               x = x.vijesti;
                
            
               // x.sort(function(a,b){return b.datum - a.datum});
                obj.innerHTML ="";
                for(var i= 0; i<x.length; i++)
                {
                    var tekst = x[i].tekst;
                    var detaljnije = x[i].detaljnije;
                    
                    var tempstring ='<div class="novost">'+
            '<div class="naslov">'+
                 '<div>'+
                     '<div class="datum">'+
                         '<div class="date-icon">▦</div>'+x[i].datumvijesti+
                      '</div>'+          
            ' <div class="autor">'+x[i].autor+'</div>'+
                  '</div>'+ x[i].naslov +
            '</div>'+
            '<div class="tekst">'+
                x[i].tekst;
                    var neispisi = false;
                    if(detaljnije == "") neispisi = true;
           if(neispisi == false)         
           {
               tempstring+='<input value = "Detaljnije" type="button" class="detaljnije" onclick=novostiajax("'+x[i].datumvijesti+'","'+x[i].autor+'","'+x[i].naslov+'","'+x[i].slika+'","'+tekst+'","'+detaljnije+'") >'+
                    '</div><br/>';
           }
                    
                    obj.innerHTML +=tempstring;
                    
                 ajaxgetbrojkomentara("brojkomentara",x[i].id,i);
                }
                    
            }
            else if (ajax.readyState == 4 && ajax.status == 404)
                obj.innerHTML = "Greska: nepoznat URL";
        }
        
        console.log(varijabla);
      
        if(varijabla === "ispisivijesti")
        {
            ajax.open("GET", "phpval/rest_vijesti.php/vijesti", true);
            ajax.send();
        }
}

function ajaxdeletekomentari(varijabla,idVijesti,k)
{
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() 
        {
            var obj = document.getElementsByClassName("novost")[k];
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                var x = JSON.parse(ajax.responseText);    
              
                ajaxgetbrojkomentara("brojkomentara",idVijesti,k);
                ajaxgetkomentari("ispisikomentare",idVijesti,k);
                
            }
            else if (ajax.readyState == 4 && ajax.status == 404)
                obj.innerHTML = "Greska: nepoznat URL";
        }
        
        console.log(varijabla);
        if(varijabla === "izbrisikomentar")
        {
            ajax.open("DELETE", "phpval/rest_komentari.php/"+idVijesti, true);
            ajax.send();
        }
    
}

function ajaxgetkomentari(varijabla,idVijesti,k)
{
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() 
        {
            obj = document.getElementsByClassName("ispiskomentara")[k];
            if (ajax.readyState == 4 && ajax.status == 200)
            {
              console.log(ajax.responseText);
                var x = JSON.parse(ajax.responseText);
                
                   obj.innerHTML ="</br>";
                    x = x.komentari;
                
                var forma = '<div class="formaadmin">'+
                    '<div class="naslovforme">Postavite komentar na vijest:</div></br>'+
                    '<label>Ime</label></br>'+
                    '<input name="ime" class="ime"></br>'+
                    '<label>Email</label></br>'+
                    '<input name="email" class="email"></br>'+
                    '<label>Komentar</label><br>'+
                    '<textarea name="komentar" class="komentar"></textarea></br>'+
                    '<input type="button" name="posaljikomentar" class="posalji" onclick="ajaxpostkomentar(\'dodajkomentar\','+idVijesti+','+k+')" value="Postavi komentar"><br></div>';
                obj.innerHTML+=forma;
                
                
                    for(var i=0; i<x.length; i++)
                    {
                        
                     var myString = '<table class="tabelaadmin">'+
                         '<tr>'+
                         '<td class="lijevo">' + x[i].datum +'</td>'+
                         '<td class="desno" rowspan="2"><a href="mailto:'+x[i].email+'">'+x[i].autor+'</a></td>'+
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
                          '<td><input type="button" value="Izbrisi" onclick=\'ajaxdeletekomentari(\"izbrisikomentar\",'+x[i].id+','+k+')\' >'+
                         '</tr>'+
                         '</table></br>';
                        
                    obj.innerHTML+=myString;
                    }            
            }
            else if (ajax.readyState == 4 && ajax.status == 404)
                obj.innerHTML = "Greska: nepoznat URL";
        }
        
        console.log(varijabla);
            ajax.open("GET", "phpval/rest_komentari.php/komentari/"+idVijesti, true);
            ajax.send();
        
    
}

function ajaxgetbrojkomentara(varijabla,idVijesti,k)
{
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() 
        {
            
            var obj = document.getElementsByClassName("novost")[k];
            if (ajax.readyState == 4 && ajax.status == 200)
            {
              // console.log(ajax.responseText);
                var x = JSON.parse(ajax.responseText);
                  
                x = x.brojkomentara;
                var mystring = '<input type="button" onclick=\'ajaxgetkomentari(\"ispisikomentare\",'+idVijesti+',' + k+')\' value="Broj komenatara: '+x+'"><div class="ispiskomentara"></div>';
                
                obj.innerHTML += mystring;


            }
            else if (ajax.readyState == 4 && ajax.status == 404)
                obj.innerHTML = "Greska: nepoznat URL";
        }
        
        console.log(varijabla);
       if(varijabla === "brojkomentara")
        {           
            ajax.open("GET", "phpval/rest_komentari.php/brojkomentara/"+idVijesti, true);
            ajax.send();   
        }
    
}

function ajaxpostkomentar(varijabla,idVijesti,k)
{
        var ajax = new XMLHttpRequest();
    
        var ime = document.getElementsByClassName('ime')[0].value;
        var email = document.getElementsByClassName('email')[0].value;
        var komentar = document.getElementsByClassName('komentar')[0].value;
        console.log(ime +" " + email +" " +  komentar);
        ajax.onreadystatechange = function() 
        {
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                //console.log(ajax.responseText);
                 var x = JSON.parse(ajax.responseText);
                 x = x.dodajkomentar;
                 if(x === "true")
                {
                    ajaxgetkomentari("ispisikomentare",idVijesti,k);
                }
                 
            }
            else if (ajax.readyState == 4 && ajax.status == 404)
                obj.innerHTML = "Greska: nepoznat URL";
        }
        
        console.log(varijabla);
       if(varijabla ==="dodajkomentar")
        {           
            ajax.open("POST", "phpval/rest_komentari.php", true);
            ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajax.send("ime="+ime+"&email="+email+"&komentar="+komentar+"&idvijesti="+idVijesti);   
        }
    
}

function ajaxgetkorisnik(varijabla)
{
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() 
        {
            var obj = document.getElementsByClassName("content")[0];
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                 var x = JSON.parse(ajax.responseText);
                
                x = x['korisnici'];
                var unesikorisnika = '<table><tr><td>Korisnicko ime:</td><td>Lozinka:</td><td>Email:</td><td>Administrator:</td><td></td></tr>'+
                '<tr><td><input class="username" type="input"></td>'+
                    '<td><input class="lozinka" type="input"></td>'+
                    '<td><input class="email" stype="input"></td>'+
                    '<td><input class="administrator" type="checkbox"></td>'+
                    '<td><input type="button" value="Dodaj korisnika" onclick=ajaxpostkorisnik("dodajKorisnika")></td><tr><table><br/>';
                
                
                  var myString =  '<table>'+
                    '<tr>' +
                        '<td>Korisničko ime</td>'+
                        '<td>Lozinka</td>'+
                        '<td>Email </td>'+
                        '<td>Administrator</td>'+
                        '<td></td>'+
                        '<td></td>'+
                        '<td></td>'+
                    '</tr>';
               obj.innerHTML="</br>";
                obj.innerHTML+=unesikorisnika;
                
                console.log(x.length);
                
        for(var i = 0; i< x.length; i++)
        {
            if(x[i]['id'] != -1) 
            {
                
                var checked = "";
                if(x[i].administrator == 1)
                {
                     checked = "checked";
                }
                
                var tempstring = '<tr>'+
                    '<td><input type="text" class="editusername" name="korisnickoime" value="'+x[i].username+'" disabled>'+
                    '</td>'+
                    '<td><input type="text" class="editlozinka"  name="lozinka" value="'+x[i].password+'" disabled>'+
                    '</td>'+
                    '<td><input type="text" class="editemail" name="email" value="'+x[i].email+'" disabled>'+
                    '</td>'+
                    '<td><input type="checkbox" class="editadministrator" name="administrator" '+checked+' disabled>'+
                    '</td>'+
                    '<td><input class="spasipromjene" type="button" value="Spasi promjene" onclick=\'ajaxputkorisnik(\"izmjenikorisnika\",'+x[i].id+','+i+')\' disabled> '+
                    '</td>'+
                    '<td><input type="button" value="Edituj korisnika" onclick=\'disableinbokse(\"editujkorisnika\",'+i+')\'>'+
                    '</td>'+
                    '<td><input type="button" value="Obrisi korisnika" onclick=\'ajaxdeletekorisnik(\"obrisikorisnika\",'+x[i].id+')\'>'+
                    '</td>'+
                    '</tr>';
                myString+=tempstring;
               
            }
                
        }
                myString += "</table>";
                obj.innerHTML += myString;
                
    }
            else if (ajax.readyState == 4 && ajax.status == 404)
                obj.innerHTML = "Greska: nepoznat URL";
        }
        
        console.log(varijabla);
            ajax.open("GET", "phpval/rest_korisnici.php/korisnik", true);
            ajax.send();
        
}

function ajaxpostkorisnik(varijabla)
{
        var ajax = new XMLHttpRequest();
        var username = document.getElementsByClassName('username')[0].value;
        var email = document.getElementsByClassName('email')[0].value;
        var lozinka= document.getElementsByClassName('lozinka')[0].value;
    
        var administrator = document.getElementsByClassName('administrator')[0];
    if(administrator.checked == true)
        administrator = 1;
    else 
        administrator = 0;
        ajax.onreadystatechange = function() 
        {
            var obj = document.getElementsByClassName("content")[0];
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                var x = JSON.parse(ajax.responseText);
                x = x.dodajkorisnika;
                if(x === "true")
                {
                    ajaxgetkorisnik("dodajkorisnika");
                }
            }
                
          
            else if (ajax.readyState == 4 && ajax.status == 404)
                obj.innerHTML = "Greska: nepoznat URL";
        }
        
        console.log(username + " " + lozinka + " " + email + " " + administrator);
        ajax.open("POST", "phpval/rest_korisnici.php", true);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send("username="+username+"&lozinka="+lozinka+"&email="+email+"&administrator="+administrator);

}

function disableinbokse(varijabla, inp)
{
    inp= inp-1;
    console.log(inp);
        var username = document.getElementsByClassName('editusername')[inp];
        username.disabled = !username.disabled;
        var email = document.getElementsByClassName('editemail')[inp];
        email.disabled = !email.disabled;
        var lozinka= document.getElementsByClassName('editlozinka')[inp];
        lozinka.disabled = !lozinka.disabled;
    
        var administrator = document.getElementsByClassName('editadministrator')[inp];
    administrator.disabled = !administrator.disabled;
    
        var btnpromjene = document.getElementsByClassName('spasipromjene')[inp];
    btnpromjene.disabled = !btnpromjene.disabled;
}

function ajaxputkorisnik(varijabla,idKorisnik,k)
{
        var ajax = new XMLHttpRequest();
    k=k-1;
        var username = document.getElementsByClassName('editusername')[k].value;
        var email = document.getElementsByClassName('editemail')[k].value;
        var lozinka= document.getElementsByClassName('editlozinka')[k].value;
    
        var administrator = document.getElementsByClassName('editadministrator')[k];
    
    if(administrator.checked == true)
        administrator = 1;
    else 
        administrator = 0;
    
        ajax.onreadystatechange = function() 
        {
            var obj = document.getElementsByClassName("content")[0];
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                var x = JSON.parse(ajax.responseText);
                x = x.editkorisnika;
                ajaxgetkorisnik("dodajkorisnika");
                
            }
                
          
            else if (ajax.readyState == 4 && ajax.status == 404)
                obj.innerHTML = "Greska: nepoznat URL";
        }
        
        console.log(username + " " + lozinka + " " + email + " " + administrator);
        ajax.open("PUT", "phpval/rest_korisnici.php", true);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send("username="+username+"&lozinka="+lozinka+"&email="+email+"&administrator="+administrator+"&id="+idKorisnik);

}
  

function ajaxdeletekorisnik(varijabla,idKorisnik)
{
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() 
        {
            
            var obj = document.getElementsByClassName("content")[0];
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                var x = JSON.parse(ajax.responseText); 
                ajaxgetkorisnik("ispisikorisnika");
            
                
            }
            else if (ajax.readyState == 4 && ajax.status == 404)
                obj.innerHTML = "Greska: nepoznat URL";
        }
        
        console.log(varijabla);
        if(varijabla === "obrisikorisnika")
        {
            ajax.open("DELETE", "phpval/rest_korisnici.php/"+idKorisnik, true);
            ajax.send();
        }
    
}


//////////////////////////////////////////////////////////////////////////////////


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