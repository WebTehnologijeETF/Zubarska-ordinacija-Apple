// Meiniji i scroll ce biti ce doradjeni kada budemo radili u PHP-u, 
// kada budem u mogucnosti da prenososim preko linka neke informacije :)
// Pa ce se onda moci skrolati odmah kada se izabere opcija
// u main-u
function pomjeriscroll(varijabla)
{
  //  console.log("tes");
     console.log(varijabla.id);
   var scrollTo =  document.getElementById(varijabla.id).offset().top;
   
  // console.log(scrollTo + document.querySelector('html, body'));
  document.querySelector('html, body').scrollTop = 400;
      //.animate({ scrollTop: scrollTo });
}
