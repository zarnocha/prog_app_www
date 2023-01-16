($(document.getElementsByClassName('obraz_przedmiotu')).on({
	"mouseover": function() {
		$(this).animate({
			width: '11vw',
			height: '13vw',
		}, 800);	
	},
	"mouseout": function() {
		$(this).animate({
			width: '9vw',
			height: '11vw',
		}, 800);
	}	
}));