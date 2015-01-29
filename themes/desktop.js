$(document).ready(function(){
	//alert("hello world");
	$("#overlay").hide();
	$("#SS").click(function(){
		$("#mainDesktop").css( "-webkit-filter", "blur(5px)" );
		$("#mainDesktop").css( "filter", "blur(5px)" );
		$("#mainDesktop").css( "filter", "url(themes/blur.svg#blur)" );

		$(".appIcon").css( "-webkit-filter", "blur(5px)" );
		$(".appIcon").css( "filter", "blur(5px)" );
		$(".appIcon").css( "filter", "url(themes/blur.svg#blur)" );

		$("#overlay").show();
	});
	$("#exit").click(function(){
		$("#mainDesktop").css( "-webkit-filter", "blur(0px)" );
		$("#mainDesktop").css( "filter", "blur(0px)" );
		$("#mainDesktop").css( "filter", "none");

		$(".appIcon").css( "-webkit-filter", "blur(0px)" );
		$(".appIcon").css( "filter", "blur(0px)" );
		$(".appIcon").css( "filter", "none");

		$("#overlay").hide();
	});
});