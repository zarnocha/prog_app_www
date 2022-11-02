($(document.getElementsByClassName('czas')).on({
	"click": function() {
		$(this).animate(
            {
			    fontSize: "70px"
		    }, 
            400, 
            function() {
                $(this).animate({
                    fontSize: "40px"
                })
            });
    }
}))
