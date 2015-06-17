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
                var unesikorisnika = '<table class="dodajkorisnika2"><tr><td>Korisnicko ime:</td><td>Lozinka:</td><td>Email:</td><td>Administrator:</td><td></td></tr>'+
                '<tr><td class="ulaz"><input class="username" type="input"></td>'+
                    '<td class="ulaz"><input class="lozinka" type="input"></td>'+
                    '<td class="ulaz"><input class="email" stype="input"></td>'+
                    '<td class="checkb"><input class="administrator" type="checkbox"></td>'+
                    '<tr><td></td><td></td><td class="izlaz"><input type="button" value="Dodaj korisnika" onclick=ajaxpostkorisnik("dodajKorisnika")></td><tr><table><br/>';
                
                
                  var myString =  '<table class="dodajkorisnika">'+
                    '<tr >' +
                        '<td>Korisničko ime</td>'+
                        '<td>Lozinka</td>'+
                        '<td>Email </td>'+
                        '<td>Administrator</td>'+
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
                    '<td class="ulaz"><input type="text" class="editusername" name="korisnickoime" value="'+x[i].username+'" disabled>'+
                    '</td>'+
                    '<td class="ulaz"><input type="text" class="editlozinka"  name="lozinka" value="'+x[i].password+'" disabled>'+
                    '</td>'+
                    '<td class="ulaz"><input type="text" class="editemail" name="email" value="'+x[i].email+'" disabled>'+
                    '</td>'+
                    '<td class="checkb"><input type="checkbox" class="editadministrator" name="administrator" '+checked+' disabled>'+
                    '</td>'+
                    '</tr><tr><td class="izlaz"><input class="spasipromjene" type="button" value="Spasi promjene" onclick=\'ajaxputkorisnik(\"izmjenikorisnika\",'+x[i].id+','+i+')\' disabled> '+
                    '</td>'+
                    '<td class="izlaz"><input type="button" value="Edituj korisnika" onclick=\'disableinbokse(\"editujkorisnika\",'+i+')\'>'+
                    '</td>'+
                    '<td class="izlaz"><input type="button" value="Obrisi korisnika" onclick=\'ajaxdeletekorisnik(\"obrisikorisnika\",'+x[i].id+')\'>'+
                    '</td><br/>'+
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
               // console.log(ajax.responseText);
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

