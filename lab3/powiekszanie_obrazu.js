$('').on({
	"mouseover" : function() {
		$(this).animate({
			width:300	
		}, 800);	
	},
	"mouseout" : function() {
		$(this).animate({
			width:200
		}, 800);
		}	
	}
};