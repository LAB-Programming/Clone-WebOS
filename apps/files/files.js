$(document).ready(function(){
    var DirName = '';

    $(".del").hide();
    $("#UpDir").hide();
    $(".iconHolder").hover(
        function(){
            $(this).find(".del").show();
            $("#UpDir").show();
            DirName = $(this).find("p").text();
        }, function(){
             $(this).find(".del").hide();
            $("#UpDir").hide();
        }
    );
    /*
    * this is for copying files in to other files
    * */
    $(function() {
        //turns all of the .iconHolder's in to a draggable
        $(".iconHolder").draggable({ revert: true});
        $(".iconHolder").droppable({ accept: ".iconHolder", //only lets other iconHolder's be dropped
            drop: function(event, ui){//function is triggered when draggable of iconHolder is dragged over
                alert("you have droped me!");
            }
        });
        $("#UpDir").droppable({ accept: ".iconHolder",
            drop: function(event, ui){
                var newURL = document.URL;

            }
        });
    });
});