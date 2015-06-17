function ajaxgetvijesti(varijabla)
{
        var ajax = new XMLHttpRequest();
    
        ajax.onreadystatechange = function() 
        {
            var obj = document.getElementsByClassName("content")[0];
            if (ajax.readyState == 4 && ajax.status == 200)
            {
               var x = JSON.parse(ajax.responseText);
               x = x.vijesti;
                
        
                obj.innerHTML ='<div class="content-naslov">'+
                'NOVOSTI'+
                '</div>';
                for(var i=0; i<x.length; i++)
                {
                    var tekst = x[i].tekst;
                    var detaljnije = x[i].detaljnije;
                    var datum = x[i].datumvijesti.replace(new RegExp('\r?\n','g'),'<br />');
                    
                    var tempstring ='<div class="novost">'+
                    '<div class="naslov">'+
                         '<div>'+
                             '<div class="datum">'+
                                 '<div class="date-icon">▦</div>'+x[i].datumvijesti+
                              '</div>'+          
                    ' <div class="autor">'+x[i].autor+'</div>'+
                          '</div>'+ x[i].naslov +
                    '</div>'+
                    '<div style=\'width:500px; margin:20px auto;\'><img width=500 height=300 src="'+x[i].slika+'"></div>'+
                    '<div class="tekst">'+
                        tekst;

                    tempstring+='</div><br/>';
                    var neispisi = false;
                    if(detaljnije === "") neispisi = true;
                    
                   if(neispisi == false)         
                   {
                       tempstring+="<input value = 'Detaljnije' type='button' class='brojkomentara' onclick=\"ajaxdetaljnije('" + x[i].datumvijesti +"','"+x[i].autor+"','"+x[i].naslov+"','"+x[i].slika+"','"+tekst+"','"+detaljnije+"','"+x[i].id+"')\" >";
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

