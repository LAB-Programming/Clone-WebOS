$(document).ready(function(){
	//alert("hello world");
	$("#overlay").hide();
	$("#SS").click(function(){
		$("#mainDesktop").css( "-webkit-filter", "blur(5px)" );
		$("#mainDesktop").css( "filter", "blur(5px)" );
		$(".appIcon").css( "-webkit-filter", "blur(5px)" );
		$(".appIcon").css( "filter", "blur(5px)" );
		$("#overlay").show();
	});
	$("#exit").click(function(){
		$("#mainDesktop").css( "-webkit-filter", "blur(0px)" );
		$("#mainDesktop").css( "filter", "blur(0px)" );
		$(".appIcon").css( "-webkit-filter", "blur(0px)" );
		$(".appIcon").css( "filter", "blur(0px)" );
		$("#overlay").hide();
	});
});