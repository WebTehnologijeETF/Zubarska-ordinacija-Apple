// Meiniji i scroll ce biti ce doradjeni kada budemo radili u PHP-u, 
// kada budem u mogucnosti da prenososim preko linka neke informacije :)
// Pa ce se onda moci skrolati odmah kada se izabere opcija
// u main-u
function pomjeriscroll(varijabla)
{
 
   var scrollTo =  document.getElementById(varijabla.id).offsetTop; // firefox
    document.querySelector('html, body').scrollTop = scrollTo; // chrome
    document.body.scrollTop = scrollTo;

}
