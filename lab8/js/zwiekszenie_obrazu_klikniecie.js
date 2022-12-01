($(document.getElementById('zegarek')).on({
	"click": function() {
		$(this).animate(
            {
			    fontSize: "3vw"
		    }, 
            400, 
            function() {
                $(this).animate({
                    fontSize: "2vw"
                })
            });
    }
}));

($(document.getElementById('data')).on({
	"click": function() {
		$(this).animate(
            {
			    fontSize: "3vw"
		    }, 
            400, 
            function() {
                $(this).animate({
                    fontSize: "2vw"
                })
            });
    }
}));
