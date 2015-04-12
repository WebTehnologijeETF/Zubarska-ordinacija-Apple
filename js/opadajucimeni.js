function novosti(variable, broj)
{
    var uslugeMeni = $("#usluge-meni" + broj);
    
    if(variable && uslugeMeni.hasClass('usluge-zatvoreno'+broj))
    {
        uslugeMeni.removeClass('usluge-zatvoreno'+broj);
        uslugeMeni.addClass('usluge-otvoreno'+broj);
    }
    else
    {
        uslugeMeni.removeClass('usluge-otvoreno'+broj);
        uslugeMeni.addClass('usluge-zatvoreno'+broj);
    }
}