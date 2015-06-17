function ajaxdeletekomentari(varijabla,idVijesti,k)
{
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() 
        {
            var obj = document.getElementsByClassName("novost")[k];
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                var x = JSON.parse(ajax.responseText);    
              
               //  ajaxgetbrojkomentara("brojkomentara",idVijesti,k);
              //  ajaxgetkomentari("ispisikomentare",idVijesti,k);
                ajaxgetvijesti("ispisivijesti");
                
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
    
        k = parseInt(k);
    
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() 
        {
            obj = document.getElementsByClassName("ispiskomentara")[k];
            if (ajax.readyState == 4 && ajax.status == 200)
            {
               var x = JSON.parse(ajax.responseText);
               obj.innerHTML ="<br/>";

               x_kom= x.komentari;
               x_admin= x.administrator;

               x = JSON.parse(x_kom);
               var forma = '<div class="formaadmin">';

                forma += '<div class="naslovforme">Postavite komentar na vijest:</div></br>'+
                '<label>Ime</label></br>'+
                '<input name="ime" class="ime"></br>'+
                '<label>Email</label></br>'+
                '<input name="email" class="email"></br>'+
                '<label>Komentar</label><br>';

                forma += '<textarea name="komentar" class="komentar"></textarea></br>'+
                '<input type="button" name="posaljikomentar" class="posalji" onclick="ajaxpostkomentar(\'dodajkomentar\','+idVijesti+','+k+','+x_admin+')" value="Postavi komentar"><br/><br/><br/></div>';

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


                    myString += '<input type="button" value="Izbrisi" onclick=\'ajaxdeletekomentari(\"izbrisikomentar\",'+x[i].id+','+k+')\'>';

                     myString += '</tr>'+
                     '</table>';

                    myString += "<br/>";
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
                var mystring = '<input class="brojkomentara" type="button" onclick=\'ajaxgetkomentari(\"ispisikomentare\",'+idVijesti+',' + k+')\' value="Broj komenatara: '+x+'"><div class="ispiskomentara"></div>';
                
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

function ajaxpostkomentar(varijabla,idVijesti,k,admin)
{
        var ajax = new XMLHttpRequest();
    
        var ime = " ";
        var email = " ";
       /* if(admin == false)
        {*/
            ime = document.getElementsByClassName('ime')[0].value;
            email = document.getElementsByClassName('email')[0].value;
       // }
        var komentar = document.getElementsByClassName('komentar')[0].value;
        
        console.log(ime +" " + email +" " +  komentar);
        ajax.onreadystatechange = function() 
        {
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                console.log(ajax.responseText);
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



