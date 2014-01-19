$(document).ready(function(){
    $(".del").hide();
    $(".iconHolder").hover(
        function(){
            $(this).find(".del").show();
        }, function(){
         $(this).find(".del").hide();
        }
    );
});