($(document.getElementsByClassName('obraz_przedmiotu')).on({
	"mouseover": function() {
		$(this).animate({
			width: 180,
			height: 200,
		}, 800);	
	},
	"mouseout": function() {
		$(this).animate({
			width: 90,
			height: 120,
		}, 800);
	}	
}));