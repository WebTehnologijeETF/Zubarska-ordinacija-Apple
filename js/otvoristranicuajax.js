function otvoriajax(varijabla)
{
    
    
           var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {// Anonimna funkcija
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
        var s = varijabla + ".html";
    console.log(s);
        ajax.open("GET", s, true);
        ajax.send();
    
}