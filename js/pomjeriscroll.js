// Meiniji i scroll ce biti ce doradjeni kada budemo radili u PHP-u, 
// kada budem u mogucnosti da prenososim preko linka neke informacije :)
// Pa ce se onda moci skrolati odmah kada se izabere opcija
// u main-u

var trenutna = "";
function pomjeriscroll(varijabla, stranica)
{
    /* U slucaju da zelimo da kliknemo na neki od linkova u meniju, a trenutna
    stranica nije otvorena, moramo prvo otvoriti tu stranicu, pa onda scroll-ati*/
    if(trenutna!=stranica)
    {
        trenutna = stranica;
        var ajax = new XMLHttpRequest();
        
        ajax.onreadystatechange = function() 
        {
            var obj = document.getElementsByClassName("content")[0];
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                obj.innerHTML = ajax.responseText;

                if(varijabla == "lokacija")
                    pokrenimapu();

                var scrollTo =  document.getElementById(varijabla).offsetTop; 

                document.body.scrollTop = scrollTo; //firefox
                document.querySelector('html, body').scrollTop = scrollTo; // chrome

            }
            else if (ajax.readyState == 4 && ajax.status == 404)
                obj.innerHTML = "Greska: nepoznat URL";
        }
        
        var s = stranica + ".html";
        console.log(s);
        ajax.open("GET", s, true);
        ajax.send();
    }
    else // U suprotnom samo scroll-amo 
    {
        var scrollTo =  document.getElementById(varijabla).offsetTop; 

        document.body.scrollTop = scrollTo; //firefox
        document.querySelector('html, body').scrollTop = scrollTo; // chrome
    }
}
