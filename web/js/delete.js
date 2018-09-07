$(function() {
	$("#dialog").hide();
  	$(".delete-trick").on("click", function(event) {
  		event.preventDefault(); 

    	var name = $(this).data("name");
    	var href = $(this).attr("href");

    	$("#dialog form").attr("action", href);

    	$("#dialog").dialog({
    	  	resizable: false,
    	  	height: "auto",
    	  	width: 400,
    	  	modal: true,
    	  	title: "Delete trick \"" + name + "\" ?",
    	  	buttons: {
    	    	"Delete trick": function() {
    	      		$(this).dialog("close");
    	      		$("form").unbind("submit").submit();
    	    	},
    	    	Cancel: function() {
    	      		$(this).dialog("close");
    	    	}
    	  	}
    	});
  	});
});