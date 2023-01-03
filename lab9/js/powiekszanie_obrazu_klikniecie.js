var naglowek_size = $(document.getElementsByClassName("naglowek")).css("fontSize");
naglowek_size = parseFloat(naglowek_size);
var oryginalna_szerokosc = parseFloat($(document.getElementsByClassName("logo")).css('width'));
var oryginalna_wysokosc = parseFloat($(document.getElementsByClassName("logo")).css('height'));

($(document.getElementsByClassName('logo')).on("click", function() {
    if (!$(this).is(":animated")) 
    {
        $(this).animate({
            width: "-=" - 100,
            height: "+=" + 10,
            duration: 3000,
        });
        
        if (naglowek_size < 145)
        {
            $(document.getElementsByClassName("naglowek")).css("fontSize", "+=" + 5);
            $(document.getElementsByClassName("dopisek")).css("fontSize", "+=" + 5);
            $(document.getElementById("football_o")).css({width: "+=" + 5});
            naglowek_size += 5;
        }
        else if (naglowek_size >= 145) {
            $(document.getElementsByClassName("naglowek")).css("fontSize", "-=" + 75);
            $(document.getElementsByClassName("dopisek")).css("fontSize", "-=" + 75);
            $(document.getElementById("football_o")).css("width", "-=" + 75);
            $(document.getElementsByClassName('logo')).height(oryginalna_wysokosc);
            $(document.getElementsByClassName('logo')).width(oryginalna_szerokosc);
            naglowek_size = 70;
        }
    }
}
));
