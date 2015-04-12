function pomjeriscroll(varijabla)
{
   var scrollTo = $(varijabla).offset().top;
   $("html, body").animate({ scrollTop: scrollTo });

}
