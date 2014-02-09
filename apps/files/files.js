$(document).ready(function(){
    var DirName = '';
    var GETobject = new URL(document.URL);

    $(".del").hide();
    $("#UpDir").hide();
    $(".iconHolder").hover(
        function(){
            $(this).find(".del").show();
            //DirName = $(this).find("p").text();
        }, function(){
            $(this).find(".del").hide();
        }
    );
    /*
    * this is for copying files in to other files
    * */
    $(function() {
        //turns all of the .iconHolder's in to a draggable
        $(".iconHolder").draggable({ revert: true , stack: "div",
            start: function( event, ui ) {
                DirName = $(this).find("p").text();
                $("#UpDir").show();  
            },
            stop: function( event, ui ) {
                $("#UpDir").hide();
            }
        });
        $(".iconHolder").droppable({ accept: ".iconHolder", //only lets other iconHolder's be dropped
            drop: function(event, ui){//function is triggered when draggable of iconHolder is dragged over
                alert(DirName);
            }
        });
        $("#UpDir").droppable({ accept: ".iconHolder",
            drop: function(event, ui){
                alert(GETobject.getGETs());
            }
        });
    });
});