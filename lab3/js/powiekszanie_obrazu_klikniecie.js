var naglowek_size = $(document.getElementsByClassName("naglowek")).css("fontSize");

($(document.getElementsByClassName('logo')).on("click", function() {
    if (!$(this).is(":animated")) 
    {
        $(this).animate({
            width: "-=" - 100,
            height: "+=" + 10,
            duration: 3000,
        })

        naglowek_size = parseFloat(naglowek_size)
        if (naglowek_size < '145')
        {
            $(document.getElementsByClassName("naglowek")).css("fontSize", "+=" + 5),
            $(document.getElementsByClassName("dopisek")).css("fontSize", "+=" + 5),
            $(document.getElementById("football_o")).css({width: "+=" + 5}),
            naglowek_size += 5
        }
    }
}
));