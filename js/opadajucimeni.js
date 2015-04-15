function novosti(variable, broj)
{
    var uslugeMeni = document.getElementById("usluge-meni" + broj);
    
    var otvoreno = false;
    if(variable && !otvoreno)
    {
               uslugeMeni.className = 'usluge-otvoreno'+broj;
        otvoreno= true;
    }
    else
    {
       
     uslugeMeni.className = 'usluge-zatvoreno'+broj;
        otvoreno = false;
    }
}


function pokrenimapu()
{
    
    document.getElementById('lokacija').src = "https://www.google.com/maps/embed/v1/place?key=AIzaSyDFOyDPHp2p6lXcBv5IwJf_c2TgjYBkzV4 &q=Sarajevo,Bosnia,Kampus";

}