$(document).ready(function(){
	
	$( ".arrow" ).click(function() {
		var thisarrow = $(this);
		var classes = $(this).attr("class");
		var response = $.ajax({
			url: "forms/vote.php",
			type: "POST",
			data: {classes: classes},
			success: function(blabla) { 
				$(thisarrow).css({"background":"#F00"});
				$(thisarrow).siblings(".arrow").css({"background": "#00F"});
			}
		});
	});

});