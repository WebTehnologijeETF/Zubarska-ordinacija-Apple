function ajaxdeleteporuke(varijabla,idPoruke,k)
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
              //  ajaxgetvijesti("ispisivijesti");
                
            }
            else if (ajax.readyState == 4 && ajax.status == 404)
                obj.innerHTML = "Greska: nepoznat URL";
        }
        
        console.log(varijabla);
        if(varijabla === "izbrisikomentar")
        {
            ajax.open("DELETE", "phpval/rest_poruke.php/"+idPoruke, true);
            ajax.send();
        }
    
}

function ajaxgetporuke()
{
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() 
        {
            obj = document.getElementsByClassName("content")[0];
            if (ajax.readyState == 4 && ajax.status == 200)
            {
            //    console.log(ajax.responseText);
               var x = JSON.parse(ajax.responseText);
               
               x_kom= x.poruke;
               x_admin= x.administrator;
               obj.innerHTML ='<div class="content-naslov">'+
               'PORUKE'+
               '</div>';
               
               x_poruka = JSON.parse(x_kom);
                      
                for(var i=0; i<x_poruka.length; i++)
                {
                    var myString = '<table class="tabelaadmin">'+
                     '<tr>'+
                     '<td class="lijevo">' + x_poruka[i].datum;
                    if(x_poruka[i].procitana == 0)
                    {
                        myString += "<div style='color:red'>NOVA PORUKA</div>";
                        x_poruka[i].procitana == 1;
                        ajaxputporuke(x_poruka[i].korisnik,x_poruka[i].email,x_poruka[i].telefon,x_poruka[i].poruka,x_poruka[i].id,1);
                    }
                    
                    myString +='</td>'+
                     '<td class="desno" rowspan="2">';

                     if(x_poruka[i].email != "")
                     myString +='<a href="mailto:'+x_poruka[i].email+'">'+x_poruka[i].korisnik+'</a>';
                    else 
                        myString +=x_poruka[i].korisnik;

                    myString+='</td>'+
                     '</tr>'+
                     '<tr>'+
                     '<td class="centaremail">Email: '+x_poruka[i].email+'</td>'+
                     '</tr>'+
                     '<tr>'+
                     '<td colspan="2" class="centarlabela">Poruka:</td>'+
                     '</tr>'+
                     '<tr>'+
                     '<td colspan="2" class="centar">'+x_poruka[i].poruka+'</td>'+
                     '</tr>'+
                     '<tr>'+
                     '<td>';


                   /* myString += '<input type="button" value="Izbrisi" onclick=\'ajaxdeleteporuka(\"izbrisiporuku\",'+x_poruka[i].id+','+i+')\'>';*/

                     myString += '</tr>'+
                     '</table><br/>';
                    obj.innerHTML +=myString;
                }
                         
            }
            else if (ajax.readyState == 4 && ajax.status == 404)
                obj.innerHTML = "Greska: nepoznat URL";
        }
        
        
            ajax.open("GET", "phpval/rest_poruke.php", true);
            ajax.send();
        
    
}

function ajaxputporuke(korisnik,email,telefon,poruka,id,proc)
{
        var ajax = new XMLHttpRequest();
    console.log(korisnik + email + telefon + poruka + id + "____" +proc);
        ajax.onreadystatechange = function() 
        {
            var obj = document.getElementsByClassName("content")[0];
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                console.log(ajax.responseText);
                var x = JSON.parse(ajax.responseText);
              
            } 
          
            else if (ajax.readyState == 4 && ajax.status == 404)
                obj.innerHTML = "Greska: nepoznat URL";
        }
        
        ajax.open("PUT", "phpval/rest_poruke.php", true);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send("korisnik="+korisnik+"&email="+email+"&poruka="+poruka+"&telefon="+telefon+"&procitana="+proc +"&id="+id);   
 

}
  

/*function ajaxgetbrojporuke(varijabla,idVijesti,k)
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
                


            }
            else if (ajax.readyState == 4 && ajax.status == 404)
                obj.innerHTML = "Greska: nepoznat URL";
        }
        
        console.log(varijabla);
       if(varijabla === "brojkomentara")
        {           
            ajax.open("GET", "phpval/rest_poruke.php/brojporuka, true);
            ajax.send();   
        }
    
}*/

function ajaxpostporuke(korisnik,email,telefon,poruka)
{
        var ajax = new XMLHttpRequest();
        var obj = document.getElementsByClassName('content')[0];
    
    
        ajax.onreadystatechange = function() 
        {
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                console.log(ajax.responseText);
                 var x = JSON.parse(ajax.responseText);
                 x = x.dodajporuku;
                
                obj.innerHTML= "<div class='porukaposlana' >Poruka uspješno poslana!</div>";
            }
            else if (ajax.readyState == 4 && ajax.status == 404)
                obj.innerHTML = "Greska: nepoznat URL";
        }
        
            ajax.open("POST", "phpval/rest_poruke.php", true);
            ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajax.send("korisnik="+korisnik+"&email="+email+"&poruka="+poruka+"&telefon="+telefon+"&procitana="+0);   
        
    
}



