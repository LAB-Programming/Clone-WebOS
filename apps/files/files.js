$(document).ready(function(){
    var DirName = '';
    var DropDir = '';
    var GETobject = new URL(document.URL);

    $(".del").hide();
    $("#UpDir").hide();
    $("#downDir").hide();
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
                $("#downDir").show();  
            },
            stop: function( event, ui ) {
                $("#UpDir").hide();
                $("#downDir").hide();
            }
        });
        $(".iconHolder").droppable({ accept: ".iconHolder", tolerance: "touch",//only lets other iconHolder's be dropped
            drop: function(event, ui){//function is triggered when draggable of iconHolder is dragged over
                DropDir = $(this).find("p").text();
                var currentDirectory = GETobject.findGET("Dir", GETobject.getGETs());
                if(currentDirectory === false) currentDirectory = '';
                var finalURL = GETobject.sendGET([
                        ['Dir', currentDirectory], 
                        ['cpDir', currentDirectory+'/'+DirName],
                        ['cpDest', currentDirectory+'/'+DropDir]
                    ]);
                window.location.href = finalURL;
            }
        });
        $("#UpDir").droppable({ accept: ".iconHolder", tolerance: "touch",
            drop: function(event, ui){
                var getArray = GETobject.findGET("Dir", GETobject.getGETs());
                if(getArray != false && getArray != '' && getArray != '/'){
                	var CurrentURL = getArray;
                	var preveiusURL = GETobject.removeLastSegment(CurrentURL);
                	var finalURL = GETobject.sendGET([
                			['Dir', CurrentURL], 
                			['cpDir', CurrentURL+'/'+DirName],
                			['cpDest', preveiusURL]
                		]);
                	window.location.href = finalURL;
                }
            }
        });
        $("#downDir").droppable({ accept: ".iconHolder", tolerance: "touch",
            drop: function(event, ui){
                var getArray = GETobject.findGET("Dir", GETobject.getGETs());
                if(getArray === false) getArray = '';
                var CurrentURL = getArray;
                var finalGet = GETobject.sendGET([
                        ['dir', CurrentURL],
                        ['rmdir', CurrentURL+'/'+DirName]
                    ]);
                if(confirm("Deleat this file?")){
                    window.location.href = finalGet;
                }
            }
        });
    });
});