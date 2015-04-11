function novosti(variable)
{
    var uslugeMeni = $("#usluge-meni");
  
    if(variable && uslugeMeni.hasClass('usluge-zatvoreno'))
    {
        uslugeMeni.removeClass('usluge-zatvoreno');
        uslugeMeni.addClass('usluge-otvoreno');
    }
    else
    {
        uslugeMeni.removeClass('usluge-otvoreno');
        uslugeMeni.addClass('usluge-zatvoreno');
    }
}